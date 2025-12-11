<?php

namespace App\Http\Controllers;

use App\Models\RuleSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RuleSectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Tampilkan semua rule.
     */
    public function index()
    {
        $rules = RuleSection::all();
        return view('backend.page_setting.rule.index', compact('rules'));
    }

    /**
     * Tampilkan form tambah rule baru.
     */
    public function create()
    {
        return view('backend.page_setting.rule.create');
    }

    /**
     * Simpan rule baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar'    => 'required|image|max:15000',
        ]);

        // Upload gambar
        $gambarPath = $request->file('gambar')->store('uploads/rules', 'public');

        // Simpan data
        RuleSection::create([
            'judul'     => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'gambar'    => 'storage/' . $gambarPath,
        ]);

        return redirect()->route('backend.rule.index')->with('success', 'Rule Section berhasil disimpan!');
    }

    /**
     * Tampilkan form edit rule berdasarkan ID.
     */
    public function edit($id)
    {
        $rule = RuleSection::findOrFail($id);
        return view('backend.page_setting.rule.edit', compact('rule'));
    }

    /**
     * Update rule berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $rule = RuleSection::findOrFail($id);

        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar'    => 'nullable|image|max:15000',
        ]);

        // Jika upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($rule->gambar && Storage::disk('public')->exists(str_replace('storage/', '', $rule->gambar))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $rule->gambar));
            }

            // Simpan gambar baru
            $gambarPath = $request->file('gambar')->store('uploads/rules', 'public');
            $rule->gambar = 'storage/' . $gambarPath;
        }

        // Update data lainnya
        $rule->judul     = $validated['judul'];
        $rule->deskripsi = $validated['deskripsi'];
        $rule->save();

        return redirect()->route('backend.rule.index')->with('success', 'Rule Section berhasil diperbarui!');
    }

    /**
     * Hapus rule berdasarkan ID.
     */
    public function destroy($id)
    {
        $rule = RuleSection::findOrFail($id);

        // Hapus file gambar jika ada
        if ($rule->gambar && Storage::disk('public')->exists(str_replace('storage/', '', $rule->gambar))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $rule->gambar));
        }

        $rule->delete();

        return redirect()->route('backend.rule.index')->with('success', 'Data berhasil dihapus.');
    }
}
