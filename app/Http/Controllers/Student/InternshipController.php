<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Field;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class InternshipController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:student');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $internships = Internship::where('student_id', $user->id)
            ->with(['company', 'supervisor', 'fieldSupervisor'])
            ->get();
        
        return view('student.internships.index', compact('internships'));
    }

    /**
     * Show form for applying to internship
     */
    public function showApplyForm()
    {
        $user = Auth::user();
        
        // Cek apakah mahasiswa sudah memiliki PKL aktif
        $hasActiveInternship = Internship::where('student_id', $user->id)
            ->whereIn('status', ['pending', 'approved', 'ongoing'])
            ->exists();
            
        if ($hasActiveInternship) {
            return redirect()->route('student.internships.index')
                ->with('error', 'Anda sudah memiliki pengajuan PKL yang aktif.');
        }
        
        $companies = Company::where('is_active', true)
            ->where('quota', '>', 0)
            ->with('fields')
            ->get();
            
        $fields = Field::where('is_active', true)->get();
        
        return view('student.internships.apply', compact('companies', 'fields'));
    }
    
    /**
     * Process internship application
     */
    public function apply(Request $request)
    {
        $user = Auth::user();
        
        // Cek apakah mahasiswa sudah memiliki PKL aktif
        $hasActiveInternship = Internship::where('student_id', $user->id)
            ->whereIn('status', ['pending', 'approved', 'ongoing'])
            ->exists();
            
        if ($hasActiveInternship) {
            return redirect()->route('student.internships.index')
                ->with('error', 'Anda sudah memiliki pengajuan PKL yang aktif.');
        }
        
        // Validasi input
        $validator = Validator::make($request->all(), [
            'company_id' => 'required|exists:companies,id',
            'field_id' => 'required|exists:fields,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'position' => 'required|string|max:255',
            'job_description' => 'required|string',
            'internship_letter' => 'required|file|mimes:pdf|max:2048',
        ]);
        
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Cek apakah kombinasi company dan field valid
        $company = Company::find($request->company_id);
        $companyHasField = $company->fields()->where('field_id', $request->field_id)->exists();
        
        if (!$companyHasField) {
            return back()
                ->with('error', 'Bidang yang dipilih tidak tersedia pada perusahaan ini.')
                ->withInput();
        }
        
        // Cek kuota
        $field = $company->fields()->where('field_id', $request->field_id)->first();
        $fieldQuota = $field->pivot->quota ?? 0;
        
        $usedFieldQuota = Internship::where('company_id', $company->id)
            ->whereIn('status', ['approved', 'ongoing'])
            ->where('department', $field->name)
            ->count();
            
        if ($fieldQuota <= $usedFieldQuota) {
            return back()
                ->with('error', 'Kuota untuk bidang ini telah penuh.')
                ->withInput();
        }
        
        // Upload surat PKL
        $letterPath = null;
        if ($request->hasFile('internship_letter')) {
            $letterFile = $request->file('internship_letter');
            $letterName = time() . '_' . $user->nim . '_internship_letter.pdf';
            $letterPath = $letterFile->storeAs('public/internship_letters', $letterName);
            $letterPath = str_replace('public/', '', $letterPath);
        }
        
        // Buat pengajuan PKL
        $internship = Internship::create([
            'student_id' => $user->id,
            'company_id' => $request->company_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'position' => $request->position,
            'department' => $field->name,
            'job_description' => $request->job_description,
            'status' => 'pending',
            'internship_letter' => $letterPath,
        ]);
        
        return redirect()->route('student.internships.show', $internship)
            ->with('success', 'Pengajuan PKL berhasil dikirim. Silakan tunggu persetujuan dari koordinator PKL.');
    }

    /**
     * Show form for uploading final report
     */
    public function showReportUploadForm()
    {
        $user = Auth::user();
        
        $internship = Internship::where('student_id', $user->id)
            ->where('status', 'ongoing')
            ->first();
            
        if (!$internship) {
            return redirect()->route('student.internships.index')
                ->with('error', 'Anda tidak memiliki PKL yang sedang berlangsung.');
        }
        
        return view('student.internships.upload_report', compact('internship'));
    }
    
    /**
     * Process final report upload
     */
    public function uploadReport(Request $request)
    {
        $user = Auth::user();
        
        $internship = Internship::where('student_id', $user->id)
            ->where('status', 'ongoing')
            ->first();
            
        if (!$internship) {
            return redirect()->route('student.internships.index')
                ->with('error', 'Anda tidak memiliki PKL yang sedang berlangsung.');
        }
        
        // Validasi input
        $validator = Validator::make($request->all(), [
            'completion_letter' => 'required|file|mimes:pdf|max:2048',
        ]);
        
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Upload laporan akhir
        $reportPath = null;
        if ($request->hasFile('completion_letter')) {
            $reportFile = $request->file('completion_letter');
            $reportName = time() . '_' . $user->nim . '_completion_letter.pdf';
            $reportPath = $reportFile->storeAs('public/completion_letters', $reportName);
            $reportPath = str_replace('public/', '', $reportPath);
        }
        
        // Update data PKL
        $internship->update([
            'completion_letter' => $reportPath,
            'status' => 'completed',
        ]);
        
        return redirect()->route('student.internships.show', $internship)
            ->with('success', 'Laporan akhir PKL berhasil diunggah.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Internship $internship)
    {
        $user = Auth::user();
        
        // Validasi bahwa internship milik mahasiswa yang login
        if ($internship->student_id !== $user->id) {
            abort(403);
        }
        
        $internship->load([
            'company', 
            'supervisor', 
            'fieldSupervisor',
            'dailyReports' => function ($query) {
                $query->latest()->take(5);
            },
            'evaluations'
        ]);
        
        return view('student.internships.show', compact('internship'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Internship $internship)
    {
        $user = Auth::user();
        
        // Validasi bahwa internship milik mahasiswa yang login
        if ($internship->student_id !== $user->id) {
            abort(403);
        }
        
        // Hanya pengajuan dengan status 'pending' yang dapat diedit
        if ($internship->status !== 'pending') {
            return redirect()->route('student.internships.show', $internship)
                ->with('error', 'Hanya pengajuan PKL dengan status menunggu yang dapat diedit.');
        }
        
        $companies = Company::where('is_active', true)->get();
        $fields = Field::where('is_active', true)->get();
        
        return view('student.internships.edit', compact('internship', 'companies', 'fields'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Internship $internship)
    {
        $user = Auth::user();
        
        // Validasi bahwa internship milik mahasiswa yang login
        if ($internship->student_id !== $user->id) {
            abort(403);
        }
        
        // Hanya pengajuan dengan status 'pending' yang dapat diedit
        if ($internship->status !== 'pending') {
            return redirect()->route('student.internships.show', $internship)
                ->with('error', 'Hanya pengajuan PKL dengan status menunggu yang dapat diedit.');
        }
        
        // Validasi input
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'position' => 'required|string|max:255',
            'job_description' => 'required|string',
            'internship_letter' => 'nullable|file|mimes:pdf|max:2048',
        ]);
        
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Upload surat PKL jika ada
        if ($request->hasFile('internship_letter')) {
            // Hapus surat lama
            if ($internship->internship_letter) {
                Storage::delete('public/' . $internship->internship_letter);
            }
            
            $letterFile = $request->file('internship_letter');
            $letterName = time() . '_' . $user->nim . '_internship_letter.pdf';
            $letterPath = $letterFile->storeAs('public/internship_letters', $letterName);
            $letterPath = str_replace('public/', '', $letterPath);
        } else {
            $letterPath = $internship->internship_letter;
        }
        
        // Update data PKL
        $internship->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'position' => $request->position,
            'job_description' => $request->job_description,
            'internship_letter' => $letterPath,
        ]);
        
        return redirect()->route('student.internships.show', $internship)
            ->with('success', 'Pengajuan PKL berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Internship $internship)
    {
        $user = Auth::user();
        
        // Validasi bahwa internship milik mahasiswa yang login
        if ($internship->student_id !== $user->id) {
            abort(403);
        }
        
        // Hanya pengajuan dengan status 'pending' yang dapat dibatalkan
        if ($internship->status !== 'pending') {
            return redirect()->route('student.internships.show', $internship)
                ->with('error', 'Hanya pengajuan PKL dengan status menunggu yang dapat dibatalkan.');
        }
        
        // Hapus surat PKL
        if ($internship->internship_letter) {
            Storage::delete('public/' . $internship->internship_letter);
        }
        
        // Hapus pengajuan PKL
        $internship->delete();
        
        return redirect()->route('student.internships.index')
            ->with('success', 'Pengajuan PKL berhasil dibatalkan.');
    }
}
