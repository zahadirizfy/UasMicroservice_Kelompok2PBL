<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\Galeri;

class GaleriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $galeris = Galeri::latest()->paginate(10);
        return view('backend.galeri.index', compact('galeris'));
    }

    public function create()
    {
        return view('backend.galeri.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateGaleri($request);

        $fileName = $this->uploadImage($request);

        Galeri::create([
            'judul'     => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'gambar'    => $fileName,
            'user_id'   => Auth::id(),
        ]);

        return redirect()->route('backend.galeri.index')->with('success', 'Galeri berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);
        $this->authorizeGaleri($galeri);

        return view('backend.galeri.edit', compact('galeri'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $galeri = Galeri::findOrFail($id);
        $this->authorizeGaleri($galeri);

        $validated = $this->validateGaleri($request, true);

        if ($request->hasFile('gambar')) {
            $this->deleteImage($galeri->gambar);
            $galeri->gambar = $this->uploadImage($request);
        }

        $galeri->update([
            'judul'     => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? $galeri->deskripsi,
            'gambar'    => $galeri->gambar
        ]);

        return redirect()->route('backend.galeri.index')->with('success', 'Galeri berhasil diperbarui.');
    }

    public function destroy($id): RedirectResponse
    {
        $galeri = Galeri::findOrFail($id);
        $this->authorizeGaleri($galeri);

        $this->deleteImage($galeri->gambar);
        $galeri->delete();

        return redirect()->route('backend.galeri.index')->with('success', 'Galeri berhasil dihapus.');
    }

    public function show($id)
    {
        $galeri = Galeri::findOrFail($id);
        return view('backend.galeri.show', compact('galeri'));
    }

    // ============ Helper Methods =============

    private function validateGaleri(Request $request, bool $isUpdate = false): array
    {
        return $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar'    => ($isUpdate ? 'nullable' : 'required') . '|image|mimes:jpg,jpeg,png|max:10000',
        ]);
    }

    private function uploadImage(Request $request): string
    {
        $fileName = time() . '.' . $request->file('gambar')->extension();
        $request->file('gambar')->move(public_path('uploads'), $fileName);
        return $fileName;
    }

    private function deleteImage(?string $fileName): void
    {
        if ($fileName) {
            $filePath = public_path('uploads/' . $fileName);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }
    }

    private function authorizeGaleri(Galeri $galeri): void
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return;
        }

        if ($galeri->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses data ini.');
        }
    }
}
