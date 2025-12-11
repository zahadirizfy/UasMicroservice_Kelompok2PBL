<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Frontend - Porlempika</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicon -->
    <link href="{{ asset('dashboard/assets/images/logoporlempika.png') }}" rel="icon">
    <link href="{{ asset('dashboard/assets/images/logoporlempika.png') }}" rel="apple-touch-icon">



    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- CSS Files Langsung dari Folder css -->
    <link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS -->
    <link href="{{ asset('frontend/assets/css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        .anggota-img {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: zoom-in;
        }

        .anggota-img.enlarged {
            transform: scale(3);
            z-index: 999;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(3);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 1);
        }
    </style>

    <style>
        .img-text-wrapper {
            display: inline-block;
            max-width: 100%;
        }

        .img-text-wrapper img {
            width: 100%;
            height: auto;
            display: block;
        }

        .img-text-wrapper p {
            max-width: 100%;
            text-align: justify;
            word-break: break-word;
            margin-top: 10px;
        }
    </style>



</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="#" class="logo d-flex align-items-center me-auto">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo.png" alt=""> -->
                <h1 class="sitename">Porlempika</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#rules">Rules</a></li>
                    <li><a href="#portfolio">Portfolio</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="#team">Team</a></li>
                    <li class="dropdown"><a href="#"><span>Menu</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="#fitur">Jadwal Pertandingan</a></li>
                            <li><a href="#fitur">Kategori Pertandingan</a></li>
                            <li><a href="#fitur">Galeri</a></li>
                            <li><a href="#fitur">Pengumuman</a></li>
                        </ul>
                    </li>

                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="cta-btn" href="{{ route('login') }}">Login</a>


        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">

            {{-- Tampilkan gambar jika ada --}}
            @if (!empty($hero?->image))
                <img src="{{ asset($hero->image) }}" alt="Hero Image" data-aos="fade-in">
            @endif

            <div class="container d-flex flex-column align-items-center text-center">
                <h2 data-aos="fade-up" data-aos-delay="100">
                    {{ $hero->judul ?? 'Judul Belum Diatur' }}
                </h2>
                <p data-aos="fade-up" data-aos-delay="200">
                    {{ $hero->deskripsi ?? 'Deskripsi belum tersedia.' }}
                </p>
                <div class="d-flex mt-4 justify-content-center" data-aos="fade-up" data-aos-delay="300">
                    <a href="#about" class="btn-get-started me-2">Get Started</a>
                    <a href="#about" class="glightbox btn-watch-video d-flex align-items-center">
                        <i class="bi bi-play-circle me-2"></i><span>Watch Video</span>
                    </a>
                </div>
            </div>

        </section>


        <!-- About Section -->
        @if (isset($about))
            <section id="about" class="about section">
                <div class="container">
                    <div class="row gy-4 align-items-start">
                        {{-- Kolom Kiri --}}
                        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                            <h2 class="mb-3">{{ $about->judul ?? 'Judul belum tersedia' }}</h2>

                            <div class="img-text-wrapper">
                                @if (!empty($about->image))
                                    <img src="{{ asset($about->image) }}" alt="Gambar About Kiri"
                                        class="img-fluid rounded-4 mb-3">
                                @endif

                                @if (!empty($about->deskripsi_singkat))
                                    <p>{{ $about->deskripsi_singkat }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- Kolom Kanan --}}
                        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="250">
                            <div class="content ps-0 ps-lg-4">
                                @if (!empty($about->deskripsi_lengkap))
                                    <div class="mb-3">
                                        <p style="text-align: justify;">{{ $about->deskripsi_lengkap }}</p>
                                    </div>
                                @endif

                                @if (!empty($about->second_image))
                                    <div class="position-relative">
                                        <img src="{{ asset($about->second_image) }}" class="img-fluid rounded-4"
                                            alt="Gambar About Kanan">
                                        @if (!empty($about->video_link))
                                            <a href="{{ $about->video_link }}" class="glightbox pulsating-play-btn"
                                                target="_blank"></a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif


        <!-- Stats Section -->
        <section id="stats" class="stats section light-background">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item d-flex align-items-center w-100 h-100">
                            <i class="bi bi-person color-blue flex-shrink-0"></i>
                            <div>
                                <span data-purecounter-start="0" data-purecounter-end="{{ $jumlahAnggota }}"
                                    data-purecounter-duration="1" class="purecounter"></span>
                                <p>Anggota</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item d-flex align-items-center w-100 h-100">
                            <i class="bi bi-people color-orange flex-shrink-0"></i>
                            <div>
                                <span data-purecounter-start="0" data-purecounter-end="{{ $jumlahKlub }}"
                                    data-purecounter-duration="1" class="purecounter"></span>
                                <p>Klub</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item d-flex align-items-center w-100 h-100">
                            <i class="bi bi-trophy color-green flex-shrink-0"></i>
                            <div>
                                <span data-purecounter-start="0" data-purecounter-end="{{ $jumlahAtlet }}"
                                    data-purecounter-duration="1" class="purecounter"></span>
                                <p>Atlet</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item d-flex align-items-center w-100 h-100">
                            <i class="bi bi-award color-pink flex-shrink-0"></i>
                            <div>
                                <span data-purecounter-start="0" data-purecounter-end="{{ $jumlahJuri }}"
                                    data-purecounter-duration="1" class="purecounter"></span>
                                <p>Juri</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Stats Section -->

        <!-- Services Section -->
        <section id="rules" class="services section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Porlempika</h2>
                <p>Standar Kompetisi</p>
            </div>

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-5">
                    @foreach ($rules as $rule)
                        <div class="col-xl-3 col-md-6" data-aos="zoom-in"
                            data-aos-delay="{{ 200 + $loop->index * 100 }}">
                            <div class="service-item text-center">
                                <div class="img mb-3">
                                    <img src="{{ asset($rule->gambar) }}" class="img-fluid"
                                        alt="{{ $rule->judul }}">
                                </div>
                                <div class="details position-relative">
                                    <h3>{{ $rule->judul }}</h3>
                                    {{-- Deskripsi tidak ditampilkan di sini --}}
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $rule->id }}">
                                        Show Detail
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Detail -->
                        <div class="modal fade" id="detailModal{{ $rule->id }}" tabindex="-1"
                            aria-labelledby="modalLabel{{ $rule->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel{{ $rule->id }}">
                                            {{ $rule->judul }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <img src="{{ asset($rule->gambar) }}" class="img-fluid mb-3"
                                            alt="{{ $rule->judul }}">
                                        <p style="text-align: justify;">{!! nl2br(e($rule->deskripsi)) !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if ($rules->isEmpty())
                        <div class="col-12 text-center">
                            <p class="text-muted">Belum ada data Standar Kompetisi yang ditambahkan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>




        <!-- Features Section -->
        <section id="fitur" class="features section">

            <div class="container">

                <ul class="nav nav-tabs row d-flex" data-aos="fade-up" data-aos-delay="100">
                    <li class="nav-item col-3">
                        <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#features-tab-1">
                            <i class="bi bi-calendar-event-fill"></i>
                            <h4 class="d-none d-lg-block"> Jadwal Pertandingan </h4>
                        </a>
                    </li>
                    <li class="nav-item col-3">
                        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-2">
                            <i class="bi bi-list-ul"></i>
                            <h4 class="d-none d-lg-block"> Kategori Pertandingan </h4>
                        </a>
                    </li>
                    <li class="nav-item col-3">
                        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-3">
                            <i class="bi bi-images"></i>
                            <h4 class="d-none d-lg-block">Galeri</h4>
                        </a>
                    </li>
                    <li class="nav-item col-3">
                        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-4">
                            <i class="bi bi-megaphone-fill"></i>
                            <h4 class="d-none d-lg-block"> Pengumuman </h4>
                        </a>
                    </li>
                </ul><!-- End Tab Nav -->

                <div class="tab-content" data-aos="fade-up" data-aos-delay="200">

                    <div class="tab-pane fade active show" id="features-tab-1">
                        <div class="row">
                            <div>

                                <div class="text-center mb-4">
                                    <h2>Jadwal Pertandingan</h2>
                                    <hr>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped text-center tableExportArea">
                                        <thead style="background-color: #fd7e14; color: rgb(255, 60, 0);">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Pertandingan</th>
                                                <th>Tanggal</th>
                                                <th>Waktu</th>
                                                <th>Lokasi</th>
                                                <th>Deskripsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($jadwalpertandingans as $jadwal)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $jadwal->pertandingan->nama_pertandingan ?? '-' }}</td>
                                                    <td>{{ optional($jadwal->tanggal)->format('d/m/Y') }}</td>
                                                    <td>{{ optional(\Carbon\Carbon::parse($jadwal->waktu))->format('H:i') }}
                                                    </td>
                                                    <td>{{ $jadwal->lokasi }}</td>
                                                    <td>{{ \Illuminate\Support\Str::limit($jadwal->deskripsi, 50) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                        {{-- Inline Style untuk membatasi panjang konten kolom --}}
                        <style>
                            td {
                                max-width: 200px;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap;
                            }
                        </style>
                    </div>


                    <div class="tab-pane fade" id="features-tab-2">
                        <div class="row">
                            <div>

                                <div class="text-center mb-4">
                                    <h2>Kategori Pertandingan</h2>
                                    <hr>
                                </div>


                                <table id="example"
                                    class="table table-bordered table-striped mt-3 text-center tableExportArea">
                                    <thead style="background-color: #fd7e14; color: rgb(255, 60, 0);">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kategori</th>
                                            <th>Aturan</th>
                                            <th>Batasan</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kategoripertandingans as $index => $kategori)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>{{ $kategori->nama }}</td>
                                                <td>{{ $kategori->aturan }}</td>
                                                <td>{{ $kategori->batasan }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div><!-- End Tab Content Item -->

                    <div class="tab-pane fade" id="features-tab-3">
                        <div class="row">
                            <div>
                                <div class="text-center mb-4">
                                    <h2>Galeri</h2>
                                    <hr>
                                </div>

                                @if ($galeris->isEmpty())
                                    <div class="col-12 text-center">
                                        <p>Belum ada galeri.</p>
                                    </div>
                                @else
                                    <div id="galeriCarousel" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach ($galeris as $index => $galeri)
                                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <img src="{{ asset('uploads/' . $galeri->gambar) }}"
                                                            class="d-block rounded" alt="{{ $galeri->judul }}"
                                                            style="max-height: 450px; object-fit: cover; width: 100%; max-width: 800px;">
                                                        <div class="mt-3 text-center text-dark">
                                                            <h5 class="fw-bold">{{ $galeri->judul }}</h5>
                                                            <p>{{ $galeri->deskripsi }}</p>
                                                        </div>

                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        {{-- Controls --}}
                                        <button class="carousel-control-prev" type="button"
                                            data-bs-target="#galeriCarousel" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Sebelumnya</span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                            data-bs-target="#galeriCarousel" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Berikutnya</span>
                                        </button>
                                    </div>
                                @endif

                                <style>
                                    .carousel-inner {
                                        background-color: #ffffff;
                                        border-radius: 12px;
                                        padding: 20px;
                                    }

                                    .carousel-item {
                                        transition: transform 0.6s ease, opacity 0.6s ease;
                                    }

                                    .carousel-control-prev-icon,
                                    .carousel-control-next-icon {
                                        background-color: rgba(0, 0, 0, 0.5);
                                        border-radius: 50%;
                                    }

                                    .carousel-caption {
                                        background-color: rgba(0, 0, 0, 0.5);
                                        border-radius: 10px;
                                    }
                                </style>

                            </div>

                        </div>
                    </div><!-- End Tab Content Item -->

                    <div class="tab-pane fade" id="features-tab-4">
                        <div class="row">
                            <div>
                                <div class="text-center mb-4">
                                    <h2>Pengumuman</h2>
                                    <hr>
                                </div>


                                @if ($pengumumans->isEmpty())
                                    <div class="text-center">
                                        <p class="text-muted">Belum ada pengumuman.</p>
                                    </div>
                                @else
                                    <div id="pengumumanCarousel" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach ($pengumumans as $index => $item)
                                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                    <div class="row g-4 align-items-center">
                                                        {{-- Kolom Informasi --}}
                                                        <div class="col-md-6">
                                                            <div class="p-3" style="word-wrap: break-word;">
                                                                <h3 class="fw-bold text-dark">{{ $item->judul }}</h3>
                                                                <p class="text-muted mb-2">
                                                                    <i class="bi bi-calendar-event me-1"></i>
                                                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                                                </p>
                                                                <hr>
                                                                <div class="text-secondary overflow-auto"
                                                                    style="max-height: 280px; text-align: justify; word-break: break-word;">
                                                                    {!! nl2br(e($item->isi)) !!}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- Kolom Gambar --}}
                                                        <div class="col-md-6 text-center">
                                                            @if ($item->foto)
                                                                <img src="{{ asset('uploads/pengumuman/' . $item->foto) }}"
                                                                    class="img-fluid rounded shadow-sm"
                                                                    alt="Foto Pengumuman"
                                                                    style="max-height: 350px; object-fit: cover; width: 100%;">
                                                            @else
                                                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded"
                                                                    style="height: 300px;">
                                                                    Tidak ada foto
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        {{-- Navigasi Carousel --}}
                                        <button class="carousel-control-prev" type="button"
                                            data-bs-target="#pengumumanCarousel" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon bg-dark rounded-circle p-2"
                                                aria-hidden="true"></span>
                                            <span class="visually-hidden">Sebelumnya</span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                            data-bs-target="#pengumumanCarousel" data-bs-slide="next">
                                            <span class="carousel-control-next-icon bg-dark rounded-circle p-2"
                                                aria-hidden="true"></span>
                                            <span class="visually-hidden">Berikutnya</span>
                                        </button>
                                    </div>
                                @endif
                            </div>


                        </div><!-- End Tab Content Item -->

                    </div>

                </div>

        </section><!-- /Features Section -->


        <!-- Portfolio Section -->
        <section id="portfolio" class="portfolio section py-5">
            <!-- Section Title -->
            <div class="container section-title my-3" data-aos="fade-up">
                <h2>Portfolio</h2>
                <p>Cek Portofolio Kami</p>
            </div>

            <div class="container">
                @if ($portfolios->isEmpty())
                    <div class="text-center py-5">
                        <h4>Belum ada Portfolio</h4>
                    </div>
                @else
                    <div class="portfolio-grid">
                        @foreach ($portfolios as $portfolio)
                            @php
                                $portfolioImg =
                                    $portfolio->image && file_exists(public_path($portfolio->image))
                                        ? asset($portfolio->image)
                                        : asset('frontend/assets/images/default-image.png');
                            @endphp
                            <div class="portfolio-item" data-aos="fade-up" data-aos-delay="100">
                                <img src="{{ $portfolioImg }}" class="img-fluid portfolio-img"
                                    alt="{{ $portfolio->title }}" data-bs-toggle="modal"
                                    data-bs-target="#portfolioModal{{ $portfolio->id }}">

                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="portfolioModal{{ $portfolio->id }}" tabindex="-1"
                                aria-labelledby="portfolioModalLabel{{ $portfolio->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ $portfolio->title }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="{{ $portfolioImg }}" class="img-fluid rounded mb-3"
                                                alt="{{ $portfolio->title }}">
                                            <h6 class="text-muted">{{ $portfolio->category }}</h6>
                                            <p>{{ $portfolio->description }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>


        <style>
            .portfolio-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
            }

            .portfolio-item img {
                width: 100%;
                height: auto;
                display: block;
                border-radius: 8px;
                cursor: pointer;
                transition: transform 0.3s ease;
            }

            .portfolio-item img:hover {
                transform: scale(1.05);
            }

            .portfolio-item h5 {
                margin-top: 8px;
                font-size: 1rem;
                text-align: center;
            }

            .modal-body {
                max-height: 75vh;
                overflow-y: auto;
            }

            .modal-body p {
                word-wrap: break-word;
                white-space: pre-wrap;
            }
        </style>



        <!-- Clients Section -->
        <section id="clients" class="clients section light-background py-5">
            <div class="container" data-aos="fade-up">
                <div class="row gy-4 justify-content-center">

                    @forelse ($clientlogos as $logo)
                        <div class="col-xl-2 col-md-3 col-6 client-logo text-center">
                            @php
                                $imagePath = public_path($logo->logo);
                                $imageUrl = asset($logo->logo);
                                $fallbackUrl = asset('frontend/assets/images/default-logo.png');
                            @endphp

                            <img src="{{ file_exists($imagePath) ? $imageUrl : $fallbackUrl }}"
                                class="img-fluid rounded shadow-sm" alt="Logo Mitra"
                                style="max-height: 120px; object-fit: contain;">
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted">Belum ada logo mitra ditambahkan.</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </section>
        <!-- /Clients Section -->




        <div class="py-5"></div>

        <!-- Testimonials Section -->
        <section id="testimonials" class="testimonials section dark-background">

            {{-- Background image --}}
            <img src="{{ asset($testimonialBg ?? 'frontend/assets/images/thumbnail.png') }}" class="testimonials-bg"
                alt="">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                @if ($testimonials->isEmpty())
                    <div class="text-center py-5">
                        <h4 class="text-light">Belum ada data testimonial.</h4>
                    </div>
                @else
                    <div class="swiper init-swiper">
                        <script type="application/json" class="swiper-config">
                {
                  "loop": true,
                  "speed": 600,
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": "auto",
                  "pagination": {
                    "el": ".swiper-pagination",
                    "type": "bullets",
                    "clickable": true
                  }
                }
                </script>

                        <div class="swiper-wrapper">
                            @foreach ($testimonials as $testimonial)
                                <div class="swiper-slide">
                                    <div class="testimonial-item">
                                        @php
                                            $testimonialImg = 'uploads/testimonials/' . $testimonial->image;
                                            $imageUrl = file_exists(public_path($testimonialImg))
                                                ? asset($testimonialImg)
                                                : asset('frontend/assets/images/default-avatar.png');
                                        @endphp
                                        <img src="{{ $imageUrl }}" class="testimonial-img"
                                            alt="{{ $testimonial->name }}">
                                        <h3>{{ $testimonial->name }}</h3>
                                        <h4>{{ $testimonial->profession }}</h4>
                                        <div class="stars">
                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </div>
                                        <p>
                                            <i class="bi bi-quote quote-icon-left"></i>
                                            <span>{{ $testimonial->quote }}</span>
                                            <i class="bi bi-quote quote-icon-right"></i>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="swiper-pagination"></div>
                    </div>
                @endif

            </div>
        </section>



        <!-- Structure Section -->
        <style>
            .hover-lift:hover {
                transform: translateY(-5px);
                box-shadow: 0 0.5rem 1rem rgb(0, 0, 0);
                transition: all 0.3s ease;
            }
        </style>
        <section id="structure" class="services-2 section light-background py-5">
            <div class="container">
                <!-- Section Title -->
                <div class="section-title" data-aos="fade-up">
                    <h2>Porlempika</h2>
                    <p>Susunan Organisasi</p>
                </div>

                <div class="row gy-4">
                    @forelse ($structures as $structure)
                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                            <div class="d-flex align-items-start shadow-sm p-3 rounded-4 bg-white h-100 hover-lift">
                                <img src="{{ asset($structure->photo && file_exists(public_path($structure->photo)) ? $structure->photo : 'frontend/assets/images/default-profile.png') }}"
                                    alt="Foto {{ $structure->position }}" class="rounded-circle me-3 flex-shrink-0"
                                    style="width: 100px; height: 100px; object-fit: cover;">

                                <div>
                                    <h5 class="fw-bold mb-1">{{ $structure->name }}</h5>
                                    <p class="text-primary mb-2" style="font-size: 0.95rem;">
                                        {{ $structure->position }}</p>
                                    <p class="text-muted small mb-0">{{ $structure->description }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted">Belum ada data struktur organisasi ditambahkan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>



        <!-- Contact Section -->
        <section id="contact" class="contact section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Contact</h2>
                <p>Porlempika Kota Padang</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">
                    <div class="col-lg-6 ">
                        <div class="row gy-4">

                            <div class="col-lg-12">
                                <div class="info-item d-flex flex-column justify-content-center align-items-center"
                                    data-aos="fade-up" data-aos-delay="200">
                                    <i class="bi bi-geo-alt"></i>
                                    <h3>Alamat</h3>
                                    <p>Alamat: {{ $contact->address ?? '-' }}</p>
                                    <a href="{{ url('/cek-rute') }}" class="btn btn-primary mt-2">
                                        📍 Cek Rute ke Lokasi
                                    </a>
                                </div>
                            </div><!-- End Info Item -->


                            <div class="col-md-6">
                                <div class="info-item d-flex flex-column justify-content-center align-items-center"
                                    data-aos="fade-up" data-aos-delay="300">
                                    <i class="bi bi-telephone"></i>
                                    <h3>Admin</h3>
                                    <p>{{ $contact->phone ?? '-' }}</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="col-md-6">
                                <div class="info-item d-flex flex-column justify-content-center align-items-center"
                                    data-aos="fade-up" data-aos-delay="400">
                                    <i class="bi bi-envelope"></i>
                                    <h3>Email Kami</h3>
                                    <p>{{ $contact->email ?? '-' }}</p>
                                </div>
                            </div><!-- End Info Item -->

                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card shadow border-0 p-4" data-aos="fade-up" data-aos-delay="500">
                            <h4 class="mb-4"><i class="fas fa-envelope me-2"></i> <strong>Kirim Saranmu Disini </strong></h4>
                            <form action="{{ route('contact.send') }}" method="POST">
                                @csrf
                                <div class="row gy-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="name" class="form-control"
                                                id="floatingName" placeholder="Your Name" required>
                                            <label for="floatingName"><i class="fas fa-user me-1"></i> Nama
                                                Anda</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" name="email" class="form-control"
                                                id="floatingEmail" placeholder="Your Email" required>
                                            <label for="floatingEmail"><i class="fas fa-envelope me-1"></i> Email
                                                Anda</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="text" name="subject" class="form-control"
                                                id="floatingSubject" placeholder="Subject" required>
                                            <label for="floatingSubject"><i class="fas fa-tag me-1"></i>
                                                Subjek</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <textarea name="message" class="form-control" placeholder="Message" id="floatingMessage" style="height: 120px;"
                                                required></textarea>
                                            <label for="floatingMessage"><i class="fas fa-comment-dots me-1"></i>
                                                Pesan</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center mt-3">
                                        @if (session('success'))
                                            <div class="alert alert-success alert-dismissible fade show"
                                                role="alert">
                                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif
                                        <button type="submit" class="btn btn-primary px-4 py-2">
                                            <i class="fas fa-paper-plane me-1"></i> Kirim Pesan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- End Contact Form -->


                </div>

            </div>

        </section><!-- /Contact Section -->

        <!-- Team Section -->
        <section id="team" class="team section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Tim</h2>
                <p>PENGEMBANG</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-5">
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="member">
                            <div class="pic"><img src="{{ asset('frontend/assets/images/zahadi.jpg') }}"
                                    class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>Zahadi Rizfy</h4>
                                <span>Project Manager</span>
                                <div class="social">
                                    <a href="https://www.instagram.com/zahadirizfy_?igsh=YnNuOWg1cjllOHA="><i
                                            class="bi bi-instagram"></i></a>

                                </div>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="member">
                            <div class="pic"><img src="{{ asset('frontend/assets/images/yara.jpg') }}"
                                    class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>Syarah Izzati</h4>
                                <span>UI/UX Designer</span>
                                <div class="social">

                                    <a href="https://www.instagram.com/syarazzl?igsh=MWR0Nnpub2lrZTV0YQ=="><i
                                            class="bi bi-instagram"></i></a>

                                </div>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="member">
                            <div class="pic"><img src="{{ asset('frontend/assets/images/vani.jpg') }}"
                                    class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>Givani Arianti</h4>
                                <span>Technical Writer</span>
                                <div class="social">

                                    <a href="https://www.instagram.com/vanii_arn?igsh=MXdndzFlN3gwZG94dw=="><i
                                            class="bi bi-instagram"></i></a>

                                </div>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="member">
                            <div class="pic"><img src="{{ asset('frontend/assets/images/dapi.jpg') }}"
                                    class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>Davi Ahmad Yani</h4>
                                <span>Tester</span>
                                <div class="social">

                                    <a href="https://www.instagram.com/daviahmdy_?igsh=M2RwbmYyeXU4ZnUz"><i
                                            class="bi bi-instagram"></i></a>

                                </div>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                </div>

            </div>

        </section><!-- /Team Section -->

    </main>

    <footer id="footer" class="footer dark-background">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="#" class="logo d-flex align-items-center">
                        <span class="sitename">Porlempika</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>{{ $contact->address ?? '-' }}</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>{{ $contact->phone ?? '-' }}</span></p>
                        <p><strong>Email:</strong> <span>{{ $contact->email ?? '-' }}</span></p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href=""><i class="bi bi-twitter"></i></a>
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Menu Utama</h4>
                    <ul>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Home</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">About us</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Services</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Portfolio</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Team</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Program kami</h4>
                    <ul>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Pelatihan & Workshop</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Seminar & Diskusi</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Pengembangan SDM</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-3 footer-links text-end">
                    <img src="{{ asset('dashboard/assets/images/logoporlempika.png') }}" alt="Logo porlempika"
                        class="img-fluid" style="max-width: 100px;">
                    <img src="{{ asset('frontend/assets/images/koni.png') }}" alt="Logo koni" class="img-fluid"
                        style="max-width: 100px;">

                </div>



            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">Porlempika</strong> <span>Kota Padang</span>
            </p>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you've purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
                Designed by <a href="#">Kel 2</a>
            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/validate.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/aos.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/isotope.pkgd.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const images = document.querySelectorAll('.foto-hover');

            images.forEach(img => {
                let timer;

                img.addEventListener('mouseenter', () => {
                    timer = setTimeout(() => {
                        img.classList.add('enlarged');
                    }, 1000); // tunggu 1 detik
                });

                img.addEventListener('mouseleave', () => {
                    clearTimeout(timer); // batalkan jika belum 3 detik
                    img.classList.remove('enlarged'); // kecilkan kembali
                });
            });
        });
    </script>
    <script>
        (function() {
            if (!window.chatbase || window.chatbase("getState") !== "initialized") {
                window.chatbase = (...arguments) => {
                    if (!window.chatbase.q) {
                        window.chatbase.q = []
                    }
                    window.chatbase.q.push(arguments)
                };
                window.chatbase = new Proxy(window.chatbase, {
                    get(target, prop) {
                        if (prop === "q") {
                            return target.q
                        }
                        return (...args) => target(prop, ...args)
                    }
                })
            }
            const onLoad = function() {
                const script = document.createElement("script");
                script.src = "https://www.chatbase.co/embed.min.js";
                script.id = "sf2RVcB0jTngkTxpn7mQ_";
                script.domain = "www.chatbase.co";
                document.body.appendChild(script)
            };
            if (document.readyState === "complete") {
                onLoad()
            } else {
                window.addEventListener("load", onLoad)
            }
        })();
    </script>
    <script>
        $(document).ready(function() {
            // Default tab saat load pertama
            $('#features-tab-content').load("{{ route('ajax.jadwal') }}");

            // Saat tab diklik
            $('[data-bs-target]').on('click', function() {
                const targetId = $(this).data('bs-target');
                let url = '';

                switch (targetId) {
                    case '#features-tab-1':
                        url = "{{ route('ajax.jadwal') }}";
                        break;
                    case '#features-tab-2':
                        url = "{{ route('ajax.kategori') }}";
                        break;
                    case '#features-tab-3':
                        url = "{{ route('ajax.galeri') }}";
                        break;
                    case '#features-tab-4':
                        url = "{{ route('ajax.pengumuman') }}";
                        break;
                }

                $('#features-tab-content').load(url);
            });
        });
    </script>


</body>

</html>
