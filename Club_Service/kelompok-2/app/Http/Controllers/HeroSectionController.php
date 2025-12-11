<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HeroSection;
use Illuminate\Support\Facades\Storage;

class HeroSectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    // Tampilkan semua hero
    public function index()
    {
        $heros = HeroSection::all();
        return view('backend.page_setting.hero.index', compact('heros'));
    }

    // Tampilkan form tambah hero
    public function create()
    {
        return view('backend.page_setting.hero.create');
    }

    // Simpan data baru, hapus lama jika ada
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:15000',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        // Hapus data lama
        $oldData = HeroSection::first();
        if ($oldData) {
            if ($oldData->image && Storage::disk('public')->exists(str_replace('storage/', '', $oldData->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $oldData->image));
            }
            HeroSection::truncate();
        }

        $path = $request->file('image')->store('uploads/heros', 'public');

        HeroSection::create([
            'image' => 'storage/' . $path,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('backend.hero.index')->with('success', 'Hero Section berhasil ditambahkan!');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $hero = HeroSection::findOrFail($id);
        return view('backend.page_setting.hero.edit', compact('hero'));
    }

    // Update data hero
    public function update(Request $request, $id)
    {
        $hero = HeroSection::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'image' => 'nullable|image|max:15000',
        ]);

        // Jika ada file baru diupload, ganti
        if ($request->hasFile('image')) {
            if ($hero->image && Storage::disk('public')->exists(str_replace('storage/', '', $hero->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $hero->image));
            }

            $path = $request->file('image')->store('uploads/heros', 'public');
            $hero->image = 'storage/' . $path;
        }

        $hero->judul = $validated['judul'];
        $hero->deskripsi = $validated['deskripsi'];
        $hero->save();

        return redirect()->route('backend.hero.index')->with('success', 'Hero Section berhasil diperbarui!');
    }

    // Hapus
    public function destroy($id)
    {
        $hero = HeroSection::findOrFail($id);

        if ($hero->image && Storage::disk('public')->exists(str_replace('storage/', '', $hero->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $hero->image));
        }

        $hero->delete();

        return redirect()->route('backend.hero.index')->with('success', 'Hero Section berhasil dihapus!');
    }
}
