<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        $pengumumans = Pengumuman::orderBy('tanggal', 'desc')->get();
        return view('backend.pengumuman.index', compact('pengumumans'));
    }

    public function create()
    {
        return view('backend.pengumuman.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'   => 'required|string|max:255',
            'isi'     => 'required|string',
            'tanggal' => 'required|date',
            'foto'    => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan foto
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

            $folder = public_path('uploads/pengumuman');
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }

            $file->move($folder, $filename);
            $validated['foto'] = $filename;
        }

        Pengumuman::create($validated);

        return redirect()->route('backend.pengumuman.index')
                         ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('backend.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        $validated = $request->validate([
            'judul'   => 'required|string|max:255',
            'isi'     => 'required|string',
            'tanggal' => 'required|date',
            'foto'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Jika ada foto baru diupload
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($pengumuman->foto && file_exists(public_path('uploads/pengumuman/' . $pengumuman->foto))) {
                unlink(public_path('uploads/pengumuman/' . $pengumuman->foto));
            }

            $file = $request->file('foto');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

            $folder = public_path('uploads/pengumuman');
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }

            $file->move($folder, $filename);
            $validated['foto'] = $filename;
        }

        $pengumuman->update($validated);

        return redirect()->route('backend.pengumuman.index')
                         ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        // Hapus foto jika ada
        if ($pengumuman->foto && file_exists(public_path('uploads/pengumuman/' . $pengumuman->foto))) {
            unlink(public_path('uploads/pengumuman/' . $pengumuman->foto));
        }

        $pengumuman->delete();

        return redirect()->route('backend.pengumuman.index')
                         ->with('success', 'Pengumuman berhasil dihapus.');
    }
}
