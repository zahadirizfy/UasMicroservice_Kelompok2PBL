<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Atlet;
use App\Models\Club;
use App\Models\Juri;
use App\Models\Pertandingan;
use App\Models\PenyelenggaraEvent;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

// Exports
use App\Exports\AnggotaExport;
use App\Exports\AtletExport;
use App\Exports\ClubExport;
use App\Exports\HasilPertandinganExport;
use App\Exports\JuriExport;
use App\Exports\PenyelenggaraExport;

class OutputController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    // =============== OUTPUT ANGGOTA =============== //

    public function output_anggota()
    {
        $anggotas = Anggota::all();
        return view('backend.output.anggota.index', compact('anggotas'));
    }

    public function cetak_kartu($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('backend.output.anggota.cetak', compact('anggota'));
    }

    public function exportExcel()
    {
        return Excel::download(new AnggotaExport, 'data_anggota.xlsx');
    }

    public function exportPDF()
    {
        $anggotas = Anggota::all();
        $pdf = Pdf::loadView('backend.output.anggota.pdf', compact('anggotas'))
                  ->setPaper('A4', 'landscape');

        return $pdf->download('data_anggota.pdf');
    }

    // =============== OUTPUT ATLET =============== //

    public function output_atlet()
    {
        $atlets = Atlet::with('club')->get();
        return view('backend.output.atlet.index', compact('atlets'));
    }

    public function cetak_nomor_peserta($id)
    {
        $atlet = Atlet::with('club')->findOrFail($id);
        $nomorPeserta = 'PES-' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);

        return view('backend.output.atlet.nomor_peserta', compact('atlet', 'nomorPeserta'));
    }

    public function exportAtletExcel()
    {
        return Excel::download(new AtletExport, 'data_atlet.xlsx');
    }

    public function exportAtletPDF()
    {
        $atlets = Atlet::with('club')->get();
        $pdf = Pdf::loadView('backend.output.atlet.pdf', compact('atlets'))
                  ->setPaper('A4', 'landscape');

        return $pdf->download('data_atlet.pdf');
    }

    // =============== OUTPUT CLUB =============== //

    public function output_club()
    {
        $clubs = Club::all();
        return view('backend.output.club.index', compact('clubs'));
    }

    public function exportClubExcel()
    {
        return Excel::download(new ClubExport, 'data_klub.xlsx');
    }

    public function exportClubPDF()
    {
        $clubs = Club::all();
        $pdf = Pdf::loadView('backend.output.club.pdf', compact('clubs'))
                  ->setPaper('A4', 'landscape');

        return $pdf->download('data_klub.pdf');
    }

    // =============== OUTPUT JURI =============== //

    public function output_juri()
    {
        $juris = Juri::all();
        return view('backend.output.juri.index', compact('juris'));
    }

    public function exportJuriExcel()
    {
        return Excel::download(new JuriExport, 'data_juri.xlsx');
    }

    public function exportJuriPDF()
    {
        $juris = Juri::all();
        $pdf = Pdf::loadView('backend.output.juri.pdf', compact('juris'))
                  ->setPaper('A4', 'landscape');

        return $pdf->download('data_juri.pdf');
    }

    // =============== OUTPUT PENYELENGGARA EVENT =============== //

    public function output_penyelenggara()
    {
        $penyelenggaras = PenyelenggaraEvent::all();
        return view('backend.output.penyelenggara.index', compact('penyelenggaras'));
    }

    public function exportPenyelenggaraExcel()
    {
        return Excel::download(new PenyelenggaraExport, 'data_penyelenggara.xlsx');
    }

    public function exportPenyelenggaraPDF()
    {
        $penyelenggaras = PenyelenggaraEvent::all();
        $pdf = Pdf::loadView('backend.output.penyelenggara.pdf', compact('penyelenggaras'))
                  ->setPaper('A4', 'landscape');

        return $pdf->download('data_penyelenggara.pdf');
    }

    // =============== OUTPUT HASIL PERTANDINGAN =============== //

    public function output_hasilpertandingan()
    {
        $pertandingans = Pertandingan::with([
            'penyelenggaraEvent',
            'juri',
            'jadwalPertandingan'
        ])->get();

        return view('backend.output.hasilpertandingan.index', compact('pertandingans'));
    }

    public function cetakHasilPDF($id)
    {
        $pertandingan = Pertandingan::with([
            'penyelenggaraEvent',
            'juri',
            'jadwalPertandingan',
            'hasilPertandingan.atlet'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('backend.output.hasilpertandingan.pdf', compact('pertandingan'))
                  ->setPaper('A4', 'landscape');

        return $pdf->download('hasil_pertandingan_' . Str::slug($pertandingan->nama_pertandingan) . '.pdf');
    }

    public function exportHasilExcel($id)
    {
        $pertandingan = Pertandingan::findOrFail($id);
        return Excel::download(
            new HasilPertandinganExport($id),
            'hasil_pertandingan_' . Str::slug($pertandingan->nama_pertandingan) . '.xlsx'
        );
    }
}
