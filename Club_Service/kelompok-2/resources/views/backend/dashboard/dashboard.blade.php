@extends('backend.layouts.main')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <i class="bx bx-home-alt fs-1 text-primary"></i>
                    </div>
                    <div>
                        <h4 class="mb-1">Selamat Datang, {{ Auth::user()->name ?? Auth::user()->email }}</h4>
                        <p class="mb-0 text-light">Anda login sebagai <strong>{{ ucfirst(Auth::user()->role) }}</strong>.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card statistik --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <i class="bx bx-user fs-1 text-success"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">{{ \App\Models\Atlet::count() }}</h5>
                        <small class="text-light">Total Atlet</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <i class="bx bx-group fs-1 text-info"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">{{ \App\Models\Club::count() }}</h5>
                        <small class="text-light">Total Klub</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <i class="bx bx-calendar-event fs-1 text-warning"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">{{ \App\Models\Pertandingan::count() }}</h5>
                        <small class="text-light">Total Pertandingan</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <i class="bx bx-user-check fs-1 text-primary"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">{{ \App\Models\Anggota::count() }}</h5>
                        <small class="text-light">Total Anggota</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <i class="bx bx-microphone fs-1 text-danger"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">{{ \App\Models\Juri::count() }}</h5>
                        <small class="text-light">Total Juri</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <i class="bx bx-briefcase-alt fs-1 text-secondary"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">{{ \App\Models\PenyelenggaraEvent::count() }}</h5>
                        <small class="text-light">Total Penyelenggara</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Info tambahan --}}
        <div class="col-12">
            <div class="alert alert-primary shadow-sm" role="alert">
                <i class="bx bx-info-circle me-2"></i>
                Selamat bekerja dan gunakan sistem ini dengan bijak. Jika ada kendala, hubungi admin IT.
            </div>
        </div>
    </div>
</div>
@endsection
