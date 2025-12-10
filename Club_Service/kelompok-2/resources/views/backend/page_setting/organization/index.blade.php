@extends('backend.layouts.main')
@section('title', 'Halaman Struktur Organisasi')
@section('navorganization', 'active') {{-- Sesuaikan dengan nav sidebar --}}

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-sitemap me-2"></i> Struktur Organisasi</h4>
                    <a href="{{ route('backend.organization.create') }}" class="btn btn-sm btn-light">
                        <i class="fas fa-plus me-1"></i> Tambah Anggota
                    </a>
                </div>

                <div class="card-body">
                    {{-- Pesan Sukses --}}
                    @if (session('success'))
                        <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($structures as $structure)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ asset($structure->photo) }}" alt="Foto Struktur"
                                                width="80" class="shadow-sm">
                                        </td>
                                        <td>{{ $structure->name }}</td>
                                        <td>{{ $structure->position }}</td>
                                        <td class="text-start">{{ $structure->description }}</td>
                                        <td>
                                            <div class="d-inline-flex align-items-center gap-1">
                                                <a href="{{ route('backend.organization.edit', $structure->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('backend.organization.destroy', $structure->id) }}"
                                                    method="POST" onsubmit="return confirm('Yakin ingin menghapus anggota ini?');">
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
                                        <td colspan="6">Belum ada data struktur organisasi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
                Halaman ini digunakan untuk mengelola struktur organisasi yang tampil pada website.
                Anda dapat menambah, mengedit, atau menghapus data anggota organisasi.
            </div>
        </div>
    </div>
</div>
@endsection
