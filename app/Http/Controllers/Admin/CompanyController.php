<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::with('fields')->get();
        
        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fields = Field::where('is_active', true)->get();
        
        return view('admin.companies.create', compact('fields'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:companies',
            'website' => 'nullable|url|max:255',
            'industry_type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'quota' => 'required|integer|min:0',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'fields' => 'required|array|min:1',
            'fields.*' => 'exists:fields,id',
            'field_quotas' => 'required|array|min:1',
            'field_quotas.*' => 'integer|min:0',
            'field_requirements' => 'nullable|array',
            'field_requirements.*' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Upload logo jika ada
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');
            $logoName = time() . '_' . Str::slug($request->name) . '.' . $logoFile->getClientOriginalExtension();
            $logoPath = $logoFile->storeAs('public/company_logos', $logoName);
            $logoPath = str_replace('public/', '', $logoPath);
        }

        // Simpan data perusahaan
        $company = Company::create([
            'name' => $request->name,
            'address' => $request->address,
            'city' => $request->city,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'description' => $request->description,
            'industry_type' => $request->industry_type,
            'quota' => $request->quota,
            'logo' => $logoPath,
            'is_active' => $request->has('is_active'),
        ]);

        // Simpan relasi dengan bidang dan kuota
        $fieldsData = [];
        foreach ($request->fields as $key => $fieldId) {
            $fieldsData[$fieldId] = [
                'quota' => $request->field_quotas[$key] ?? 0,
                'requirements' => $request->field_requirements[$key] ?? null,
            ];
        }
        
        $company->fields()->sync($fieldsData);

        return redirect()->route('admin.companies.index')
            ->with('success', 'Perusahaan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        $company->load('fields', 'internships.student');
        
        return view('admin.companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        $company->load('fields');
        $fields = Field::where('is_active', true)->get();
        
        return view('admin.companies.edit', compact('company', 'fields'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:companies,email,' . $company->id,
            'website' => 'nullable|url|max:255',
            'industry_type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'quota' => 'required|integer|min:0',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'fields' => 'required|array|min:1',
            'fields.*' => 'exists:fields,id',
            'field_quotas' => 'required|array|min:1',
            'field_quotas.*' => 'integer|min:0',
            'field_requirements' => 'nullable|array',
            'field_requirements.*' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Upload logo jika ada
        if ($request->hasFile('logo')) {
            // Hapus logo lama
            if ($company->logo) {
                Storage::delete('public/' . $company->logo);
            }
            
            $logoFile = $request->file('logo');
            $logoName = time() . '_' . Str::slug($request->name) . '.' . $logoFile->getClientOriginalExtension();
            $logoPath = $logoFile->storeAs('public/company_logos', $logoName);
            $logoPath = str_replace('public/', '', $logoPath);
        } else {
            $logoPath = $company->logo;
        }

        // Update data perusahaan
        $company->update([
            'name' => $request->name,
            'address' => $request->address,
            'city' => $request->city,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'description' => $request->description,
            'industry_type' => $request->industry_type,
            'quota' => $request->quota,
            'logo' => $logoPath,
            'is_active' => $request->has('is_active'),
        ]);

        // Update relasi dengan bidang dan kuota
        $fieldsData = [];
        foreach ($request->fields as $key => $fieldId) {
            $fieldsData[$fieldId] = [
                'quota' => $request->field_quotas[$key] ?? 0,
                'requirements' => $request->field_requirements[$key] ?? null,
            ];
        }
        
        $company->fields()->sync($fieldsData);

        return redirect()->route('admin.companies.index')
            ->with('success', 'Perusahaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        // Cek apakah perusahaan memiliki internship aktif
        $hasActiveInternships = $company->internships()->whereIn('status', ['pending', 'ongoing', 'approved'])->exists();
        
        if ($hasActiveInternships) {
            return back()->with('error', 'Perusahaan tidak dapat dihapus karena memiliki PKL yang sedang aktif.');
        }
        
        // Hapus logo
        if ($company->logo) {
            Storage::delete('public/' . $company->logo);
        }
        
        // Hapus relasi dengan fields
        $company->fields()->detach();
        
        // Hapus perusahaan
        $company->delete();
        
        return redirect()->route('admin.companies.index')
            ->with('success', 'Perusahaan berhasil dihapus.');
    }
}
