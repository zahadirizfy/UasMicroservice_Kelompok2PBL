@extends('backend.layouts.main')
@section('title', 'Output Data Atlet')

@section('content')
    <div class="text-center mb-4">
        <h2>Data Atlet</h2>
        <hr>
    </div>

    {{-- Tombol Export --}}
    <div class="mb-4 d-flex justify-content-end gap-2">
        <a href="{{ route('backend.output.atlet.excel') }}" class="btn btn-success">
            <i class="fas fa-file-excel me-1"></i> Export Excel
        </a>
        <a href="{{ route('backend.output.atlet.pdf') }}" class="btn btn-danger" target="_blank">
            <i class="fas fa-file-pdf me-1"></i> Export PDF
        </a>
    </div>

    <div class="row">
        @forelse ($atlets as $atlet)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    {{-- Foto Atlet --}}
                    @if ($atlet->foto && file_exists(public_path('storage/' . $atlet->foto)))
                        <img src="{{ asset('storage/' . $atlet->foto) }}" alt="Foto {{ $atlet->nama }}" class="card-img-top"
                             style="height: 200px; object-fit: cover; border-top-left-radius: .5rem; border-top-right-radius: .5rem;">
                    @else
                        <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center text-white"
                             style="height: 200px; border-top-left-radius: .5rem; border-top-right-radius: .5rem;">
                            Tidak Ada Foto
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title">{{ $atlet->nama }}</h5>
                            <p class="mb-1"><strong>Klub:</strong> {{ $atlet->club->nama ?? '-' }}</p>
                            <p class="mb-2"><strong>Prestasi:</strong> {{ $atlet->prestasi ?: '-' }}</p>
                        </div>

                        {{-- Tombol Cetak Nomor Peserta --}}
                        <a href="{{ route('backend.output.nomorpeserta', $atlet->id) }}" target="_blank"
                           class="btn btn-sm btn-primary mt-auto">
                            <i class="fas fa-print me-1"></i> Cetak Nomor
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada data atlet.</p>
            </div>
        @endforelse
    </div>
@endsection
