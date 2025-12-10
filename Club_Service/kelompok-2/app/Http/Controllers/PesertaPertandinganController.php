<?php

namespace App\Http\Controllers;

use App\Models\Pertandingan;
use App\Models\Atlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class PesertaPertandinganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Menampilkan daftar peserta untuk suatu pertandingan
    public function index($pertandingan_id)
    {
        $user = Auth::user();
        $pertandingan = Pertandingan::with(['atlets', 'penyelenggaraEvent'])->findOrFail($pertandingan_id);

        $this->authorizePenyelenggara($pertandingan);

        $semuaAtlet = Atlet::all();

        return view('backend.pertandingan.peserta.index', compact('pertandingan', 'semuaAtlet', 'user'));
    }

    // Menyimpan peserta baru
    public function store(Request $request, $pertandingan_id): RedirectResponse
    {
        $pertandingan = Pertandingan::with('penyelenggaraEvent')->findOrFail($pertandingan_id);

        $this->authorizePenyelenggara($pertandingan);

        $validated = $request->validate([
            'atlet_id' => 'required|exists:atlets,id',
        ]);

        // Cegah duplikat peserta
        if ($pertandingan->atlets()->where('atlet_id', $validated['atlet_id'])->exists()) {
            return redirect()->back()->with('error', 'Atlet ini sudah terdaftar sebagai peserta.');
        }

        // Insert ke tabel pivot peserta_pertandingans
        $pertandingan->atlets()->attach($validated['atlet_id'], [
            'user_id' => Auth::id() // jika tabel pivot punya user_id
        ]);

        return redirect()->back()->with('success', 'Peserta berhasil ditambahkan.');
    }

    // Menghapus peserta dari pertandingan
    public function destroy($pertandingan_id, $atlet_id): RedirectResponse
    {
        $pertandingan = Pertandingan::with('penyelenggaraEvent')->findOrFail($pertandingan_id);

        $this->authorizePenyelenggara($pertandingan);

        $pertandingan->atlets()->detach($atlet_id);

        return redirect()->back()->with('success', 'Peserta berhasil dihapus.');
    }

    // ===== Helper authorize =====
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
