<?php

namespace App\Http\Controllers;

use App\Models\Juri;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JuriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $juris = Juri::all();
        return view('backend.juri.index', compact('juris'));
    }

    public function create()
    {
        return view('backend.juri.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateJuri($request);
        $validated['sertifikat'] = $this->handleSertifikatUpload($request);
        $validated['user_id'] = Auth::id();

        Juri::create($validated);

        return redirect()->route('backend.juri.index')
                         ->with('success', 'Juri berhasil ditambahkan');
    }

    public function edit($id)
    {
        $juri = Juri::findOrFail($id);
        $this->authorizeJuri($juri);

        return view('backend.juri.edit', compact('juri'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $juri = Juri::findOrFail($id);
        $this->authorizeJuri($juri);

        $validated = $this->validateJuri($request, false);

        if ($request->hasFile('sertifikat')) {
            $this->deleteOldSertifikat($juri->sertifikat);
            $validated['sertifikat'] = $this->handleSertifikatUpload($request);
        }

        $juri->update($validated);

        return redirect()->route('backend.juri.index')
                         ->with('success', 'Juri berhasil diperbarui');
    }

    public function destroy($id): RedirectResponse
    {
        $juri = Juri::findOrFail($id);
        $this->authorizeJuri($juri);

        $this->deleteOldSertifikat($juri->sertifikat);
        $juri->delete();

        return redirect()->route('backend.juri.index')
                         ->with('success', 'Juri berhasil dihapus');
    }

    // ===== Helper Methods =====

    private function validateJuri(Request $request, bool $isStore = true): array
    {
        return $request->validate([
            'nama_juri'     => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'sertifikat'    => ($isStore ? 'required' : 'sometimes').'|mimes:pdf|max:2048',
        ]);
    }

    private function handleSertifikatUpload(Request $request): ?string
    {
        return $request->hasFile('sertifikat')
            ? $request->file('sertifikat')->store('sertifikat', 'public')
            : null;
    }

    private function deleteOldSertifikat(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function authorizeJuri(Juri $juri): void
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return;
        }

        if ($juri->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses data ini.');
        }
    }
}
