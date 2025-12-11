<?php

namespace App\Http\Controllers;

use App\Models\AboutSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutSectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        $abouts = AboutSection::all();
        return view('backend.page_setting.about.index', compact('abouts'));
    }

    public function create()
    {
        return view('backend.page_setting.about.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi_singkat' => 'required|string',
            'deskripsi_lengkap' => 'required|string',
            'image' => 'required|image|max:15000',
            'second_image' => 'required|image|max:15000',
            'video_link' => 'required|url',
        ]);

        // Hapus data lama (jika hanya 1 about yang disimpan)
        $old = AboutSection::first();
        if ($old) {
            if ($old->image) Storage::disk('public')->delete(str_replace('storage/', '', $old->image));
            if ($old->second_image) Storage::disk('public')->delete(str_replace('storage/', '', $old->second_image));
            AboutSection::truncate();
        }

        // Upload gambar
        $imagePath = $request->file('image')->store('uploads/about', 'public');
        $secondImagePath = $request->file('second_image')->store('uploads/about', 'public');

        AboutSection::create([
            'judul' => $validated['judul'],
            'deskripsi_singkat' => $validated['deskripsi_singkat'],
            'deskripsi_lengkap' => $validated['deskripsi_lengkap'],
            'image' => 'storage/' . $imagePath,
            'second_image' => 'storage/' . $secondImagePath,
            'video_link' => $validated['video_link'],
        ]);

        return redirect()->route('backend.about.index')->with('success', 'About Section berhasil disimpan!');
    }

    public function edit($id)
    {
        $about = AboutSection::findOrFail($id);
        return view('backend.page_setting.about.edit', compact('about'));
    }

    public function update(Request $request, $id)
    {
        $about = AboutSection::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi_singkat' => 'required|string',
            'deskripsi_lengkap' => 'required|string',
            'image' => 'nullable|image|max:15000',
            'second_image' => 'nullable|image|max:15000',
            'video_link' => 'required|url',
        ]);

        // Update gambar kiri jika diunggah
        if ($request->hasFile('image')) {
            if ($about->image) Storage::disk('public')->delete(str_replace('storage/', '', $about->image));
            $imagePath = $request->file('image')->store('uploads/about', 'public');
            $about->image = 'storage/' . $imagePath;
        }

        // Update gambar kanan jika diunggah
        if ($request->hasFile('second_image')) {
            if ($about->second_image) Storage::disk('public')->delete(str_replace('storage/', '', $about->second_image));
            $secondImagePath = $request->file('second_image')->store('uploads/about', 'public');
            $about->second_image = 'storage/' . $secondImagePath;
        }

        // Update data lainnya
        $about->judul = $validated['judul'];
        $about->deskripsi_singkat = $validated['deskripsi_singkat'];
        $about->deskripsi_lengkap = $validated['deskripsi_lengkap'];
        $about->video_link = $validated['video_link'];
        $about->save();

        return redirect()->route('backend.about.index')->with('success', 'About Section berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $about = AboutSection::findOrFail($id);

        if ($about->image) Storage::disk('public')->delete(str_replace('storage/', '', $about->image));
        if ($about->second_image) Storage::disk('public')->delete(str_replace('storage/', '', $about->second_image));
        
        $about->delete();

        return redirect()->route('backend.about.index')->with('success', 'Data berhasil dihapus.');
    }
}
