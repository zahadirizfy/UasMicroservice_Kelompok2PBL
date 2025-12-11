<?php

namespace App\Http\Controllers;

use App\Models\KategoriPertandingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class KategoriPertandinganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Tampilkan SEMUA data untuk semua role
        $kategoripertandingans = KategoriPertandingan::latest()->get();

        return view('backend.kategori_pertandingan.index', compact('kategoripertandingans'));
    }

    public function create()
    {
        return view('backend.kategori_pertandingan.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateKategori($request);
        $validated['user_id'] = Auth::id();

        KategoriPertandingan::create($validated);

        return redirect()->route('backend.kategori_pertandingan.index')
                         ->with('success', 'Kategori pertandingan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kategori = KategoriPertandingan::findOrFail($id);
        $this->authorizeKategori($kategori);

        return view('backend.kategori_pertandingan.edit', compact('kategori'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $kategori = KategoriPertandingan::findOrFail($id);
        $this->authorizeKategori($kategori);

        $validated = $this->validateKategori($request);

        $kategori->update($validated);

        return redirect()->route('backend.kategori_pertandingan.index')
                         ->with('success', 'Kategori pertandingan berhasil diperbarui');
    }

    public function destroy($id): RedirectResponse
    {
        $kategori = KategoriPertandingan::findOrFail($id);
        $this->authorizeKategori($kategori);

        $kategori->delete();

        return redirect()->route('backend.kategori_pertandingan.index')
                         ->with('success', 'Kategori pertandingan berhasil dihapus');
    }

    // ===== Helper Methods =====

    private function validateKategori(Request $request): array
    {
        return $request->validate([
            'nama'    => 'required|string|max:255',
            'aturan'  => 'required|string|max:255',
            'batasan' => 'required|string|max:255',
        ]);
    }

    private function authorizeKategori(KategoriPertandingan $kategori): void
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return;
        }

        if ($kategori->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses data ini.');
        }
    }
}
