@extends('backend.layouts.main')
@section('title', 'Halaman Hero Section')
@section('navHero', 'active') {{-- Sesuaikan dengan nama nav di sidebar jika ada --}}

@section('content')
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow border-0">
                    <div
                        class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-photo-video me-2"></i> Hero Section</h4>
                        <a href="{{ route('backend.hero.create') }}" class="btn btn-sm btn-light">
                            <i class="fas fa-plus me-1"></i> Tambah Hero
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
                            <table class="table table-bordered table-hover text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Gambar</th>
                                        <th>Judul</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($heros as $hero)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <img src="{{ asset($hero->image) }}" alt="Hero Image" width="100"
                                                    class="rounded shadow-sm">
                                            </td>
                                            <td>{{ $hero->judul }}</td>
                                            <td class="text-start">{{ $hero->deskripsi }}</td>
                                            <td>
                                                <div class="d-inline-flex align-items-center gap-1">
                                                    <a href="{{ route('backend.hero.edit', $hero->id) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form action="{{ route('backend.hero.destroy', $hero->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus Hero ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach

                                    @if ($heros->isEmpty())
                                        <tr>
                                            <td colspan="5">Belum ada data Hero Section</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">

            <hr>
            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle me-1"></i>
                Halaman ini digunakan untuk mengelola tampilan bagian atas (hero section) pada halaman utama website.
                Hanya satu data yang ditampilkan, dan data lama akan otomatis terhapus jika Anda menambahkan data baru.
            </div>

        </div>
    </div>
@endsection
