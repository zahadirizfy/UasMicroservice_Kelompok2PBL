<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertandingan;
use App\Models\PenyelenggaraEvent;
use App\Models\Juri;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class PertandinganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pertandingans = Pertandingan::with(['penyelenggaraEvent', 'juri'])
                            ->latest()
                            ->get();

        return view('backend.pertandingan.index', compact('pertandingans'));
    }

    public function create()
    {
        // semua role bebas memilih penyelenggara mana saja
        $penyelenggaras = PenyelenggaraEvent::orderBy('nama_penyelenggara_event')->get();
        $juris = Juri::orderBy('nama_juri')->get();

        return view('backend.pertandingan.create', compact('penyelenggaras', 'juris'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePertandingan($request);

        // ambil penyelenggara
        $penyelenggara = PenyelenggaraEvent::where('id', $validated['penyelenggara_event_id'])->first();
        if (!$penyelenggara) {
            abort(404, 'Penyelenggara tidak ditemukan.');
        }

        // tetap simpan user_id dari penyelenggara untuk konsistensi
        Pertandingan::create(array_merge($validated, ['user_id' => $penyelenggara->user_id]));

        return redirect()->route('backend.pertandingan.index')
            ->with('success', 'Pertandingan berhasil ditambahkan.');
    }

    public function edit(Pertandingan $pertandingan)
    {
        $this->authorizePenyelenggara($pertandingan);

        // semua role bebas memilih penyelenggara mana saja
        $penyelenggaras = PenyelenggaraEvent::orderBy('nama_penyelenggara_event')->get();
        $juris = Juri::orderBy('nama_juri')->get();

        return view('backend.pertandingan.edit', compact('pertandingan', 'penyelenggaras', 'juris'));
    }

    public function update(Request $request, Pertandingan $pertandingan): RedirectResponse
    {
        $this->authorizePenyelenggara($pertandingan);

        $validated = $this->validatePertandingan($request);

        // ambil penyelenggara baru
        $penyelenggara = PenyelenggaraEvent::where('id', $validated['penyelenggara_event_id'])->first();
        if (!$penyelenggara) {
            abort(404, 'Penyelenggara tidak ditemukan.');
        }

        // update termasuk user_id agar tetap konsisten
        $pertandingan->update(array_merge($validated, ['user_id' => $penyelenggara->user_id]));

        return redirect()->route('backend.pertandingan.index')
            ->with('success', 'Pertandingan berhasil diperbarui.');
    }

    public function destroy(Pertandingan $pertandingan): RedirectResponse
    {
        $this->authorizePenyelenggara($pertandingan);

        $pertandingan->delete();

        return redirect()->route('backend.pertandingan.index')
            ->with('success', 'Pertandingan berhasil dihapus.');
    }

    // ===== Helper Methods =====

    private function validatePertandingan(Request $request): array
    {
        return $request->validate([
            'nama_pertandingan'      => 'required|string|min:2|max:255',
            'penyelenggara_event_id' => 'required|exists:penyelenggara_events,id',
            'juri_id'                => 'required|exists:juris,id',
        ]);
    }

    private function authorizePenyelenggara(Pertandingan $pertandingan): void
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return;
        }

        if (!$pertandingan->penyelenggaraEvent || $pertandingan->penyelenggaraEvent->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses data ini.');
        }
    }
}
