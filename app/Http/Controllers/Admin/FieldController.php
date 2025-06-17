<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FieldController extends Controller
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
        $fields = Field::withCount('companies')->get();
        
        return view('admin.fields.index', compact('fields'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.fields.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:fields',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Simpan data bidang
        Field::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.fields.index')
            ->with('success', 'Bidang PKL berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Field $field)
    {
        $field->load('companies');
        
        return view('admin.fields.show', compact('field'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Field $field)
    {
        return view('admin.fields.edit', compact('field'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Field $field)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:fields,name,' . $field->id,
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update data bidang
        $field->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.fields.index')
            ->with('success', 'Bidang PKL berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Field $field)
    {
        // Cek apakah bidang memiliki perusahaan terkait
        if ($field->companies()->count() > 0) {
            return back()->with('error', 'Bidang tidak dapat dihapus karena masih digunakan oleh beberapa perusahaan.');
        }
        
        $field->delete();
        
        return redirect()->route('admin.fields.index')
            ->with('success', 'Bidang PKL berhasil dihapus.');
    }
}
