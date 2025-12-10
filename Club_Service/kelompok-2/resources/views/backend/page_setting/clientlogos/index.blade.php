@extends('backend.layouts.main')
@section('title', 'Halaman Client Logo')
@section('navClientLogo', 'active')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow border-0">
                    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-handshake me-2"></i> Client Logo</h4>
                        <a href="{{ route('backend.clientlogos.create') }}" class="btn btn-sm btn-light">
                            <i class="fas fa-plus me-1"></i> Tambah Logo
                        </a>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-center align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Logo</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($logos as $logo)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($logo->logo)
                                                    <img src="{{ asset($logo->logo) }}" width="80" class="rounded shadow-sm">
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-inline-flex align-items-center gap-1">
                                                    <a href="{{ route('backend.clientlogos.edit', $logo->id) }}" class="btn btn-warning btn-sm me-1 mb-1">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form action="{{ route('backend.clientlogos.destroy', $logo->id) }}" method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus logo ini?');">
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
                                            <td colspan="3">Belum ada logo yang ditambahkan.</td>
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
                Halaman ini digunakan untuk menampilkan dan mengelola logo-logo client yang ditampilkan di halaman utama.
            </div>
        </div>
    </div>
@endsection
