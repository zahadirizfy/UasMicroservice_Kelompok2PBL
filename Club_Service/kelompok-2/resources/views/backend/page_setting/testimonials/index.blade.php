@extends('backend.layouts.main')
@section('title', 'Halaman Testimonials')
@section('navTestimonials', 'active')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow border-0">
                    <div
                        class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-quote-left me-2"></i> Testimonials</h4>
                        <a href="{{ route('backend.testimonials.create') }}" class="btn btn-sm btn-light">
                            <i class="fas fa-plus me-1"></i> Tambah Testimonial
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
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>Profesi</th>
                                        <th>Quote</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($testimonials as $testimonial)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($testimonial->image && file_exists(public_path('uploads/testimonials/' . $testimonial->image)))
                                                    <img src="{{ asset('uploads/testimonials/' . $testimonial->image) }}"
                                                        alt="Foto" width="80" class="rounded shadow-sm">
                                                @else
                                                    <span class="badge bg-secondary">Belum ada foto</span>
                                                @endif
                                            </td>
                                            <td>{{ $testimonial->name }}</td>
                                            <td>{{ $testimonial->profession }}</td>
                                            <td class="text-start">{{ $testimonial->quote }}</td>
                                            <td>
                                                <div class="d-inline-flex align-items-center gap-1">
                                                    <a href="{{ route('backend.testimonials.edit', $testimonial->id) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form
                                                        action="{{ route('backend.testimonials.destroy', $testimonial->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus testimonial ini?');">
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
                                            <td colspan="6" class="text-center text-muted">Belum ada data Testimonials
                                            </td>
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
                Halaman ini digunakan untuk mengelola kata-kata motivasi dan testimonial yang tampil pada website.
                Anda dapat menambah, mengedit, dan menghapus testimonial sesuai kebutuhan.
            </div>
        </div>
    </div>
@endsection
