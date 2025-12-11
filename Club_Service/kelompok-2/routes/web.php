<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    AboutSectionController,
    ClubController,
    JuriController,
    AtletController,
    GaleriController,
    AnggotaController,
    PengumumanController,
    HasilPertandinganController,
    JadwalPertandinganController,
    KategoriPertandinganController,
    PertandinganController,
    PenyelenggaraEventController,
    FrontendController,
    KonfirmasiController,
    UserController,
    PesertaPertandinganController,
    RekapLatihanController,
    DetailHasilPertandinganController,
    OutputController,
    HeroSectionController,
    RuleSectionController,
    ClientLogoController,
    OrganizationalStructureController,
    ContactController,
    TestimonialController,
    PortfolioController,
    ContactFormController
    
};

// ==============================
// FRONTEND
// ==============================

Route::get('/cek-rute', function () {
    return view('frontend.cek-rute');
});

Route::post('/contact', [ContactFormController::class, 'send'])->name('contact.send');

Route::get('/', [FrontendController::class, 'index'])->name('frontend.index');

// Login & Auth
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Register
Route::get('/register', [AuthController::class, 'register'])->name('authentikasi.register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('authentikasi.register.post');

// Password Reset
Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'handleForgot'])->name('password.handle');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'handleReset'])->name('password.update');

// Halaman Lain
// AJAX untuk frontend (akses via tab fitur, tanpa reload)
Route::prefix('ajax')->name('ajax.')->group(function () {
    Route::get('/jadwal', [FrontendController::class, 'ajaxJadwal'])->name('jadwal');
    Route::get('/kategori', [FrontendController::class, 'ajaxKategori'])->name('kategori');
    Route::get('/galeri', [FrontendController::class, 'ajaxGaleri'])->name('galeri');
    Route::get('/pengumuman', [FrontendController::class, 'ajaxPengumuman'])->name('pengumuman');
});




// ==============================
// BACKEND
// ==============================

Route::middleware(['auth'])->prefix('backend')->name('backend.')->group(function () {
    // Dashboard
    Route::view('/dashboard', 'backend.dashboard.dashboard')->name('dashboard');

    // Konfirmasi User
    Route::get('/konfirmasi', [KonfirmasiController::class, 'index'])->name('konfirmasi.index');
    Route::post('/konfirmasi/{id}/approve', [KonfirmasiController::class, 'approve'])->name('konfirmasi.approve');

    // Resource Controllers
    Route::resources([
        'atlet' => AtletController::class,
        'juri' => JuriController::class,
        'galeri' => GaleriController::class,
        'club' => ClubController::class,
        'pengumuman' => PengumumanController::class,
        'anggota' => AnggotaController::class,
        'pertandingan' => PertandinganController::class,
        'penyelenggara_event' => PenyelenggaraEventController::class,
        'users' => UserController::class,
        'kategori_pertandingan' => KategoriPertandinganController::class,
        'jadwal_pertandingan' => JadwalPertandinganController::class,
    ]);

    // Hasil Pertandingan
    Route::get('hasil_pertandingan/create', [HasilPertandinganController::class, 'create'])->name('hasil_pertandingan.create');
    Route::resource('hasil_pertandingan', HasilPertandinganController::class)->except(['create']);

    // Peserta Pertandingan
    Route::prefix('pertandingan/{id}/peserta')->name('peserta.')->group(function () {
        Route::get('/', [PesertaPertandinganController::class, 'index'])->name('index');
        Route::post('/', [PesertaPertandinganController::class, 'store'])->name('store');
        Route::delete('/{atlet_id}', [PesertaPertandinganController::class, 'destroy'])->name('destroy');
    });

    // Rekap Latihan
    Route::prefix('rekap-latihan')->name('rekap_latihan.')->group(function () {
        Route::get('/{anggota}', [RekapLatihanController::class, 'index'])->name('index');
        Route::post('/{anggota}', [RekapLatihanController::class, 'store'])->name('store');
        Route::delete('/{id}', [RekapLatihanController::class, 'destroy'])->name('destroy');
    });

    // Detail Hasil Pertandingan
    Route::prefix('hasil-pertandingan/{hasil_pertandingan_id}/detail')->name('detail_hasil_pertandingan.')->group(function () {
        Route::get('/', [DetailHasilPertandinganController::class, 'index'])->name('index');
        Route::get('/create', [DetailHasilPertandinganController::class, 'create'])->name('create');
        Route::post('/', [DetailHasilPertandinganController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [DetailHasilPertandinganController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DetailHasilPertandinganController::class, 'update'])->name('update');
        Route::delete('/{id}', [DetailHasilPertandinganController::class, 'destroy'])->name('destroy');
    });

    // ==============================
    // OUTPUT (CETAK / EXPORT)
    // ==============================

    Route::prefix('output')->name('output.')->group(function () {

        // Output Anggota
        Route::get('/anggota', [OutputController::class, 'output_anggota'])->name('anggota');
        Route::get('/anggota/cetak/{id}', [OutputController::class, 'cetak_kartu'])->name('anggota.cetak');
        Route::get('/anggota/export/excel', [OutputController::class, 'exportExcel'])->name('anggota.excel');
        Route::get('/anggota/export/pdf', [OutputController::class, 'exportPDF'])->name('anggota.pdf');

        // Output Atlet
        Route::get('/atlet', [OutputController::class, 'output_atlet'])->name('atlet');
        Route::get('/atlet/{id}/cetak-nomor', [OutputController::class, 'cetak_nomor_peserta'])->name('nomorpeserta');
        Route::get('/atlet/export/excel', [OutputController::class, 'exportAtletExcel'])->name('atlet.excel');
        Route::get('/atlet/export/pdf', [OutputController::class, 'exportAtletPDF'])->name('atlet.pdf');

        // Output Hasil Pertandingan
        Route::get('/hasil-pertandingan', [OutputController::class, 'output_hasilpertandingan'])->name('hasilpertandingan');
        Route::get('/hasil-pertandingan/{id}/cetak-pdf', [OutputController::class, 'cetakHasilPDF'])->name('hasilpertandingan.pdf');
        Route::get('/hasil-pertandingan/{id}/export-excel', [OutputController::class, 'exportHasilExcel'])->name('hasilpertandingan.excel');

        // Output Klub
        Route::get('/club', [OutputController::class, 'output_club'])->name('club');
        Route::get('/club/export/excel', [OutputController::class, 'exportClubExcel'])->name('club.excel');
        Route::get('/club/export/pdf', [OutputController::class, 'exportClubPDF'])->name('club.pdf');

        // Output Juri
        Route::get('/juri', [OutputController::class, 'output_juri'])->name('juri');
        Route::get('/juri/export/excel', [OutputController::class, 'exportJuriExcel'])->name('juri.excel');
        Route::get('/juri/export/pdf', [OutputController::class, 'exportJuriPDF'])->name('juri.pdf');

        // ===== Penyelenggara Event =====
        Route::get('/penyelenggara', [OutputController::class, 'output_penyelenggara'])->name('penyelenggara');
        Route::get('/penyelenggara/export/excel', [OutputController::class, 'exportPenyelenggaraExcel'])->name('penyelenggara.excel');
        Route::get('/penyelenggara/export/pdf', [OutputController::class, 'exportPenyelenggaraPDF'])->name('penyelenggara.pdf');
    });

    // ==============================
    // Page Setting - Hero Section
    // ==============================
    Route::prefix('page-setting/hero')->name('hero.')->group(function () {
        Route::get('/', [HeroSectionController::class, 'index'])->name('index');
        Route::get('/create', [HeroSectionController::class, 'create'])->name('create');
        Route::get('/{id}/edit', [HeroSectionController::class, 'edit'])->name('edit');
        Route::put('/{id}', [HeroSectionController::class, 'update'])->name('update');
        Route::post('/store', [HeroSectionController::class, 'store'])->name('store');
        Route::delete('/{id}', [HeroSectionController::class, 'destroy'])->name('destroy');
    });

    // ==============================
    // Page Setting - About Section
    // ==============================
    Route::prefix('page-setting/about')->name('about.')->group(function () {
        Route::get('/', [AboutSectionController::class, 'index'])->name('index');
        Route::get('/create', [AboutSectionController::class, 'create'])->name('create');
        Route::post('/store', [AboutSectionController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AboutSectionController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AboutSectionController::class, 'update'])->name('update');
        Route::delete('/{id}', [AboutSectionController::class, 'destroy'])->name('destroy');
    });


    // ==============================
    // Page Setting - Rule Section
    // ==============================
    Route::prefix('page-setting/rule')->name('rule.')->group(function () {
        Route::get('/', [RuleSectionController::class, 'index'])->name('index');
        Route::get('/create', [RuleSectionController::class, 'create'])->name('create');
        Route::post('/store', [RuleSectionController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [RuleSectionController::class, 'edit'])->name('edit');
        Route::put('/{id}', [RuleSectionController::class, 'update'])->name('update');
        Route::delete('/{id}', [RuleSectionController::class, 'destroy'])->name('destroy');
    });

    // Page Setting - Client Logo Section
    // ==============================
    Route::prefix('page-setting/clientlogo')->name('clientlogos.')->group(function () {
        Route::get('/', [ClientLogoController::class, 'index'])->name('index');
        Route::get('/create', [ClientLogoController::class, 'create'])->name('create');
        Route::post('/store', [ClientLogoController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ClientLogoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ClientLogoController::class, 'update'])->name('update');
        Route::delete('/{id}', [ClientLogoController::class, 'destroy'])->name('destroy');
    });


    // Page Setting - organization Section
    // ==============================
    Route::prefix('page-setting/organization')->name('organization.')->group(function () {
        Route::get('/', [OrganizationalStructureController::class, 'index'])->name('index');
        Route::get('/create', [OrganizationalStructureController::class, 'create'])->name('create');
        Route::post('/store', [OrganizationalStructureController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [OrganizationalStructureController::class, 'edit'])->name('edit');
        Route::put('/{id}', [OrganizationalStructureController::class, 'update'])->name('update');
        Route::delete('/{id}', [OrganizationalStructureController::class, 'destroy'])->name('destroy');
    });

    // Page Setting - Contact Section
    // ==============================
    Route::prefix('page-setting/contact')->name('contact.')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('index');
        Route::get('/create', [ContactController::class, 'create'])->name('create');
        Route::post('/store', [ContactController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ContactController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ContactController::class, 'update'])->name('update');
        Route::delete('/{id}', [ContactController::class, 'destroy'])->name('destroy');
    });


    // Page Setting - Testimonial Section
    // ==================================
    Route::prefix('page-setting/testimonials')->name('testimonials.')->group(function () {
        Route::get('/', [TestimonialController::class, 'index'])->name('index');
        Route::get('/create', [TestimonialController::class, 'create'])->name('create');
        Route::post('/', [TestimonialController::class, 'store'])->name('store');
        Route::get('/{testimonial}/edit', [TestimonialController::class, 'edit'])->name('edit');
        Route::put('/{testimonial}', [TestimonialController::class, 'update'])->name('update');
        Route::delete('/{testimonial}', [TestimonialController::class, 'destroy'])->name('destroy');
    });

    // Page Setting - Testimonial Section
    // ==================================
    Route::prefix('page-setting/portfolio')->name('portfolio.')->group(function () {
        Route::get('/', [PortfolioController::class, 'index'])->name('index');
        Route::get('/create', [PortfolioController::class, 'create'])->name('create');
        Route::post('/', [PortfolioController::class, 'store'])->name('store');
        Route::get('/{testimonial}/edit', [PortfolioController::class, 'edit'])->name('edit');
        Route::put('/{testimonial}', [PortfolioController::class, 'update'])->name('update');
        Route::delete('/{testimonial}', [PortfolioController::class, 'destroy'])->name('destroy');
    });
});
