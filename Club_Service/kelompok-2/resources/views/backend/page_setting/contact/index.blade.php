@extends('backend.layouts.main')
@section('title', 'Halaman Contact')
@section('navContact', 'active')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-address-book me-2"></i> Contact</h4>
                    <a href="{{ route('backend.contact.create') }}" class="btn btn-sm btn-light">
                        <i class="fas fa-plus me-1"></i> Tambah Kontak
                    </a>
                </div>

                <div class="card-body">
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
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Email</th>
                                    <th>Twitter</th>
                                    <th>Facebook</th>
                                    <th>Instagram</th>
                                    <th>Linkedln</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($contact)
                                    <tr>
                                        <td class="text-start">{{ $contact->address }}</td>
                                        <td>{{ $contact->phone }}</td>
                                        <td>{{ $contact->email }}</td>
                                        <td>{{ $contact->x }}</td>
                                        <td>{{ $contact->fb }}</td>
                                        <td>{{ $contact->ig }}</td>
                                        <td>{{ $contact->ln }}</td>
                                        <td>{{ $contact->latitude }}</td>
                                        <td>{{ $contact->longitude }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('backend.contact.edit', $contact->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('backend.contact.destroy', $contact->id) }}"
                                                    method="POST" onsubmit="return confirm('Yakin ingin menghapus data kontak ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="10">Belum ada data Contact</td>
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
            Halaman ini digunakan untuk mengelola informasi kontak seperti alamat, telepon, email, dan koordinat lokasi
            yang ditampilkan pada website.
        </div>
    </div>
</div>
@endsection
