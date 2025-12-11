<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Jadwal_Pertandingan;
use App\Models\Pertandingan;

class JadwalPertandinganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Tampilkan semua data tanpa filter user
        $jadwalpertandingans = Jadwal_Pertandingan::with('pertandingan')
            ->latest()
            ->get();

        return view('backend.jadwal_pertandingan.index', compact('jadwalpertandingans'));
    }

    public function create()
    {
        $pertandingans = Pertandingan::select('id', 'nama_pertandingan')->latest()->get();
        return view('backend.jadwal_pertandingan.create', compact('pertandingans'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateJadwal($request);
        $validated['user_id'] = Auth::id();

        Jadwal_Pertandingan::create($validated);

        return redirect()->route('backend.jadwal_pertandingan.index')
            ->with('success', 'Jadwal pertandingan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwalpertandingan = Jadwal_Pertandingan::findOrFail($id);
        $this->authorizeJadwal($jadwalpertandingan);

        $pertandingans = Pertandingan::select('id', 'nama_pertandingan')->latest()->get();

        return view('backend.jadwal_pertandingan.edit', compact('jadwalpertandingan', 'pertandingans'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $jadwalpertandingan = Jadwal_Pertandingan::findOrFail($id);
        $this->authorizeJadwal($jadwalpertandingan);

        $validated = $this->validateJadwal($request);

        $jadwalpertandingan->update($validated);

        return redirect()->route('backend.jadwal_pertandingan.index')
            ->with('success', 'Jadwal pertandingan berhasil diperbarui.');
    }

    public function destroy($id): RedirectResponse
    {
        $jadwalpertandingan = Jadwal_Pertandingan::findOrFail($id);
        $this->authorizeJadwal($jadwalpertandingan);

        $jadwalpertandingan->delete();

        return redirect()->route('backend.jadwal_pertandingan.index')
            ->with('success', 'Jadwal pertandingan berhasil dihapus.');
    }

    // ===== Helper Methods =====

    private function validateJadwal(Request $request): array
    {
        return $request->validate([
            'pertandingan_id' => 'required|exists:pertandingans,id',
            'tanggal'         => 'required|date',
            'waktu'           => 'required|date_format:H:i',
            'lokasi'          => 'required|string|max:255',
            'deskripsi'       => 'nullable|string|max:1000',
        ]);
    }

    private function authorizeJadwal(Jadwal_Pertandingan $jadwal): void
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return;
        }

        if ($jadwal->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses data ini.');
        }
    }
}
