<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DailyReportController extends Controller
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
        
        $internship = Internship::where('student_id', $user->id)
            ->whereIn('status', ['ongoing', 'completed'])
            ->latest()
            ->first();
            
        if (!$internship) {
            return redirect()->route('student.internships.index')
                ->with('error', 'Anda tidak memiliki data PKL yang aktif.');
        }
        
        $dailyReports = DailyReport::where('internship_id', $internship->id)
            ->orderBy('date', 'desc')
            ->paginate(10);
            
        return view('student.daily_reports.index', compact('internship', 'dailyReports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        
        $internship = Internship::where('student_id', $user->id)
            ->where('status', 'ongoing')
            ->first();
            
        if (!$internship) {
            return redirect()->route('student.daily-reports.index')
                ->with('error', 'Anda tidak memiliki PKL yang sedang berlangsung.');
        }
        
        // Cek apakah sudah membuat laporan untuk hari ini
        $today = now()->format('Y-m-d');
        $existingReport = DailyReport::where('internship_id', $internship->id)
            ->where('date', $today)
            ->first();
            
        if ($existingReport) {
            return redirect()->route('student.daily-reports.edit', $existingReport)
                ->with('info', 'Anda sudah membuat laporan untuk hari ini. Silakan edit laporan yang sudah ada.');
        }
        
        return view('student.daily_reports.create', compact('internship'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $internship = Internship::where('student_id', $user->id)
            ->where('status', 'ongoing')
            ->first();
            
        if (!$internship) {
            return redirect()->route('student.daily-reports.index')
                ->with('error', 'Anda tidak memiliki PKL yang sedang berlangsung.');
        }
        
        // Validasi input
        $validator = Validator::make($request->all(), [
            'date' => 'required|date|before_or_equal:today',
            'activity' => 'required|string',
            'problems' => 'nullable|string',
            'solutions' => 'nullable|string',
            'documentation' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Cek apakah sudah membuat laporan untuk tanggal yang sama
        $existingReport = DailyReport::where('internship_id', $internship->id)
            ->where('date', $request->date)
            ->first();
            
        if ($existingReport) {
            return redirect()->route('student.daily-reports.edit', $existingReport)
                ->with('info', 'Anda sudah membuat laporan untuk tanggal ini. Silakan edit laporan yang sudah ada.');
        }
        
        // Upload foto dokumentasi
        $docPath = null;
        if ($request->hasFile('documentation')) {
            $docFile = $request->file('documentation');
            $docName = time() . '_' . $user->nim . '_' . $request->date . '.' . $docFile->getClientOriginalExtension();
            $docPath = $docFile->storeAs('public/daily_reports', $docName);
            $docPath = str_replace('public/', '', $docPath);
        }
        
        // Buat laporan harian
        $dailyReport = DailyReport::create([
            'internship_id' => $internship->id,
            'date' => $request->date,
            'activity' => $request->activity,
            'problems' => $request->problems,
            'solutions' => $request->solutions,
            'documentation' => $docPath,
            'is_approved' => false,
            'supervisor_comment' => null,
            'field_supervisor_comment' => null,
        ]);
        
        return redirect()->route('student.daily-reports.show', $dailyReport)
            ->with('success', 'Laporan harian berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DailyReport $dailyReport)
    {
        $user = Auth::user();
        $internship = Internship::where('student_id', $user->id)
            ->whereIn('status', ['ongoing', 'completed'])
            ->latest()
            ->first();
            
        if (!$internship || $dailyReport->internship_id !== $internship->id) {
            abort(403);
        }
        
        return view('student.daily_reports.show', compact('dailyReport', 'internship'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailyReport $dailyReport)
    {
        $user = Auth::user();
        $internship = Internship::where('student_id', $user->id)
            ->whereIn('status', ['ongoing', 'completed'])
            ->latest()
            ->first();
            
        if (!$internship || $dailyReport->internship_id !== $internship->id) {
            abort(403);
        }
        
        // Jika laporan sudah disetujui, tidak bisa diedit
        if ($dailyReport->is_approved) {
            return redirect()->route('student.daily-reports.show', $dailyReport)
                ->with('error', 'Laporan yang sudah disetujui tidak dapat diedit.');
        }
        
        return view('student.daily_reports.edit', compact('dailyReport', 'internship'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DailyReport $dailyReport)
    {
        $user = Auth::user();
        $internship = Internship::where('student_id', $user->id)
            ->whereIn('status', ['ongoing', 'completed'])
            ->latest()
            ->first();
            
        if (!$internship || $dailyReport->internship_id !== $internship->id) {
            abort(403);
        }
        
        // Jika laporan sudah disetujui, tidak bisa diedit
        if ($dailyReport->is_approved) {
            return redirect()->route('student.daily-reports.show', $dailyReport)
                ->with('error', 'Laporan yang sudah disetujui tidak dapat diedit.');
        }
        
        // Validasi input
        $validator = Validator::make($request->all(), [
            'activity' => 'required|string',
            'problems' => 'nullable|string',
            'solutions' => 'nullable|string',
            'documentation' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Upload foto dokumentasi jika ada
        if ($request->hasFile('documentation')) {
            // Hapus foto lama
            if ($dailyReport->documentation) {
                Storage::delete('public/' . $dailyReport->documentation);
            }
            
            $docFile = $request->file('documentation');
            $docName = time() . '_' . $user->nim . '_' . $dailyReport->date . '.' . $docFile->getClientOriginalExtension();
            $docPath = $docFile->storeAs('public/daily_reports', $docName);
            $docPath = str_replace('public/', '', $docPath);
        } else {
            $docPath = $dailyReport->documentation;
        }
        
        // Update laporan
        $dailyReport->update([
            'activity' => $request->activity,
            'problems' => $request->problems,
            'solutions' => $request->solutions,
            'documentation' => $docPath,
        ]);
        
        return redirect()->route('student.daily-reports.show', $dailyReport)
            ->with('success', 'Laporan harian berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyReport $dailyReport)
    {
        $user = Auth::user();
        $internship = Internship::where('student_id', $user->id)
            ->whereIn('status', ['ongoing', 'completed'])
            ->latest()
            ->first();
            
        if (!$internship || $dailyReport->internship_id !== $internship->id) {
            abort(403);
        }
        
        // Jika laporan sudah disetujui, tidak bisa dihapus
        if ($dailyReport->is_approved) {
            return redirect()->route('student.daily-reports.show', $dailyReport)
                ->with('error', 'Laporan yang sudah disetujui tidak dapat dihapus.');
        }
        
        // Hapus foto dokumentasi
        if ($dailyReport->documentation) {
            Storage::delete('public/' . $dailyReport->documentation);
        }
        
        // Hapus laporan
        $dailyReport->delete();
        
        return redirect()->route('student.daily-reports.index')
            ->with('success', 'Laporan harian berhasil dihapus.');
    }
}
