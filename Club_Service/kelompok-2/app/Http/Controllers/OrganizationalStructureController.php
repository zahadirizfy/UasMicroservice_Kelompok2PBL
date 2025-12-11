<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OrganizationalStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationalStructureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    // Tampilkan data struktur organisasi
    public function index()
    {
        $structures = OrganizationalStructure::all();
        return view('backend.page_setting.organization.index', compact('structures'));
    }

    // Tampilkan form tambah
    public function create()
    {
        return view('backend.page_setting.organization.create');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'position' => 'required|string|max:100',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'photo' => 'required|image|max:2048',
        ]);

        $path = $request->file('photo')->store('uploads/organizational_structures', 'public');

        OrganizationalStructure::create([
            'position' => $validated['position'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'photo' => 'storage/' . $path,
        ]);

        return redirect()->route('backend.organization.index')->with('success', 'Struktur organisasi berhasil ditambahkan!');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $structure = OrganizationalStructure::findOrFail($id);
        return view('backend.page_setting.organization.edit', compact('structure'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $structure = OrganizationalStructure::findOrFail($id);

        $validated = $request->validate([
            'position' => 'required|string|max:100',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($structure->photo && Storage::disk('public')->exists(str_replace('storage/', '', $structure->photo))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $structure->photo));
            }

            $path = $request->file('photo')->store('uploads/organizational_structures', 'public');
            $structure->photo = 'storage/' . $path;
        }

        $structure->position = $validated['position'];
        $structure->name = $validated['name'];
        $structure->description = $validated['description'];
        $structure->save();

        return redirect()->route('backend.organization.index')->with('success', 'Struktur organisasi berhasil diperbarui!');
    }

    // Hapus data
    public function destroy($id)
    {
        $structure = OrganizationalStructure::findOrFail($id);

        if ($structure->photo && Storage::disk('public')->exists(str_replace('storage/', '', $structure->photo))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $structure->photo));
        }

        $structure->delete();

        return redirect()->route('backend.organization.index')->with('success', 'Struktur organisasi berhasil dihapus!');
    }
}
