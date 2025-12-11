@extends('backend.layouts.main')
@section('title', 'Halaman Portfolio')
@section('navPortfolio', 'active') {{-- jika ada nav di sidebar --}}

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-briefcase me-2"></i> Portfolio</h4>
                    <a href="{{ route('backend.portfolio.create') }}" class="btn btn-sm btn-light">
                        <i class="fas fa-plus me-1"></i> Tambah Portfolio
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
                                    <th>Gambar</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($portfolios as $portfolio)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($portfolio->image && file_exists(public_path($portfolio->image)))
                                                <img src="{{ asset($portfolio->image) }}" alt="Portfolio Image" width="100"
                                                    class="rounded shadow-sm">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                                        <td>{{ $portfolio->title }}</td>
                                        <td>{{ $portfolio->category }}</td>
                                        <td class="text-start">{{ Str::limit($portfolio->description, 50) }}</td>
                                        <td>
                                            <div class="d-inline-flex align-items-center gap-1">
                                                <a href="{{ route('backend.portfolio.edit', $portfolio->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('backend.portfolio.destroy', $portfolio->id) }}"
                                                    method="POST" onsubmit="return confirm('Yakin ingin menghapus portfolio ini?');">
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
                                        <td colspan="6">Belum ada data Portfolio</td>
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

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <hr>
        <div class="alert alert-info" role="alert">
            <i class="fas fa-info-circle me-1"></i>
            Halaman ini digunakan untuk mengelola portfolio yang akan ditampilkan pada halaman utama website.
        </div>
    </div>
</div>
@endsection
