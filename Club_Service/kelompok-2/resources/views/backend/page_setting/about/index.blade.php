@extends('backend.layouts.main')
@section('title', 'Halaman About Section')
@section('navAbout', 'active')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow border-0">
                    <div
                        class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-info-circle me-2"></i> About Section</h4>
                        <a href="{{ route('backend.about.create') }}" class="btn btn-sm btn-light">
                            <i class="fas fa-plus me-1"></i> Tambah About
                        </a>
                    </div>

                    <div class="card-body">
                        {{-- Pesan Sukses --}}
                        @if (session('success'))
                            <div
                                style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-center align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Gambar 1</th>
                                        <th>Gambar 2</th>
                                        <th>Judul</th>
                                        <th>Deskripsi 1</th>
                                        <th>Deskripsi 2</th>
                                        <th>Link Video</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($abouts as $about)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($about->image)
                                                    <img src="{{ asset($about->image) }}" width="80"
                                                        class="rounded shadow-sm">
                                                @endif
                                            </td>
                                            <td>
                                                @if ($about->second_image)
                                                    <img src="{{ asset($about->second_image) }}" width="80"
                                                        class="rounded shadow-sm">
                                                @endif
                                            </td>
                                            <td>{{ $about->judul }}</td>
                                            <td class="text-start">{{ Str::limit($about->deskripsi_singkat, 100) }}</td>
                                            <td class="text-start">{{ Str::limit($about->deskripsi_lengkap, 100) }}</td>
                                            <td class="text-truncate" style="max-width: 120px;">
                                                @if ($about->video_link)
                                                    <a href="{{ $about->video_link }}" target="_blank">Lihat Video</a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-inline-flex align-items-center gap-1">
                                                <a href="{{ route('backend.about.edit', $about->id) }}" class="btn btn-warning btn-sm me-1 mb-1">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('backend.about.destroy', $about->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">Belum ada data About Section</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Penjelasan --}}
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle me-1"></i>
                Halaman ini digunakan untuk mengelola bagian <strong>About</strong> pada halaman utama website.
                Hanya satu data yang ditampilkan, dan data lama akan otomatis terhapus jika Anda menambahkan data baru.
            </div>
        </div>
    </div>
@endsection
