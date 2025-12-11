<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Juri;
use App\Models\Atlet;
use App\Models\Galeri;
use App\Models\Anggota;
use App\Models\Contact;
use App\Models\Portfolio;
use App\Models\ClientLogo;
use App\Models\Pengumuman;
use App\Models\HeroSection;
use App\Models\RuleSection;
use App\Models\Testimonial;
use App\Models\AboutSection;
use App\Models\Jadwal_Pertandingan;
use Illuminate\Support\Facades\View;
use App\Models\KategoriPertandingan;
use App\Models\OrganizationalStructure;



class FrontendController extends Controller
{
    /**
     * Konstruktor: Bagikan data statistik global ke semua view frontend.
     */
    public function __construct()
    {
        View::share([
            'jumlahAnggota' => Anggota::count(),
            'jumlahKlub'    => Club::count(),
            'jumlahAtlet'   => Atlet::count(),
            'jumlahJuri'    => Juri::count(),
        ]);
    }

    /**
     * Tampilkan halaman utama frontend beserta data langsung tanpa AJAX.
     */
    public function index()
    {
        $hero = HeroSection::latest()->first();
        $about = AboutSection::latest()->first();
        $jadwalpertandingans = Jadwal_Pertandingan::with('pertandingan')->get();
        $kategoripertandingans = KategoriPertandingan::all();
        $galeris = Galeri::latest()->get();
        $pengumumans = Pengumuman::latest()->get();
        $rules = RuleSection::all();
        $clientlogos = ClientLogo::latest()->get();
        $structures = OrganizationalStructure::all();
        $contact = Contact::first();
        $testimonials = Testimonial::all();
        $portfolios = Portfolio::all();

        return view('frontend.index', compact(
            'hero',
            'about',
            'jadwalpertandingans',
            'kategoripertandingans',
            'galeris',
            'pengumumans',
            'rules',
            'clientlogos',
            'structures',
            'contact',
            'testimonials',
            'portfolios'

        ));
    }


    // ============================
    // OPSIONAL: AJAX Tab Content
    // ============================

    public function ajaxJadwal()
    {
        $jadwalpertandingans = Jadwal_Pertandingan::with('pertandingan')->get();
        return view('frontend.ajax.jadwal', compact('jadwalpertandingans'));
    }

    public function ajaxKategori()
    {
        $kategoripertandingans = KategoriPertandingan::all();
        return view('frontend.ajax.kategori', compact('kategoripertandingans'));
    }

    public function ajaxGaleri()
    {
        $galeris = Galeri::latest()->get();
        return view('frontend.ajax.galeri', compact('galeris'));
    }

    public function ajaxPengumuman()
    {
        $pengumumans = Pengumuman::latest()->get();
        return view('frontend.ajax.pengumuman', compact('pengumumans'));
    }
}
