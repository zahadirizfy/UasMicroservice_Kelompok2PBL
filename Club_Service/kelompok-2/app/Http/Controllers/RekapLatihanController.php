<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\RekapLatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class RekapLatihanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Menampilkan halaman input & daftar rekap dalam satu halaman
    public function index($anggota_id)
    {
        $user = Auth::user();

        $anggota = Anggota::findOrFail($anggota_id);

        $this->authorizeAnggota($anggota);

        $rekap = RekapLatihan::where('anggota_id', $anggota_id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('backend.anggota.rekap_latihan.index', compact('anggota', 'rekap', 'user'));
    }

    // Menyimpan data rekap baru
    public function store(Request $request, $anggota_id): RedirectResponse
    {
        $anggota = Anggota::findOrFail($anggota_id);

        $this->authorizeAnggota($anggota);

        $validated = $request->validate([
            'tanggal'   => 'required|date',
            'jarak'     => 'required|string|max:255',
            'lemparan1' => 'required|numeric',
            'lemparan2' => 'nullable|numeric',
            'lemparan3' => 'nullable|numeric',
            'lemparan4' => 'nullable|numeric',
            'lemparan5' => 'nullable|numeric',
        ]);

        RekapLatihan::create([
            'tanggal'    => $validated['tanggal'],
            'jarak'      => $validated['jarak'],
            'lemparan1'  => $validated['lemparan1'],
            'lemparan2'  => $validated['lemparan2'] ?? null,
            'lemparan3'  => $validated['lemparan3'] ?? null,
            'lemparan4'  => $validated['lemparan4'] ?? null,
            'lemparan5'  => $validated['lemparan5'] ?? null,
            'anggota_id' => $anggota_id,
            'user_id'    => Auth::id(), // ✅ pastikan user_id ikut disimpan
        ]);

        return redirect()
            ->route('backend.rekap_latihan.index', $anggota_id)
            ->with('success', 'Data rekap latihan berhasil ditambahkan.');
    }

    public function destroy($id): RedirectResponse
    {
        $rekap = RekapLatihan::findOrFail($id);
        $anggota = $rekap->anggota;

        $this->authorizeAnggota($anggota);

        $rekap->delete();

        return back()->with('success', 'Data rekap latihan berhasil dihapus.');
    }

    // ===== Helper Authorization =====
    private function authorizeAnggota(Anggota $anggota): void
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return;
        }

        if ($anggota->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses data ini.');
        }
    }
}
