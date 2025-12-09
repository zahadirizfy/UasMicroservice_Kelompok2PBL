@extends('backend.layouts.app')

@section('title', 'Rekap Latihan')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Rekap Latihan: {{ $anggota->nama }}</h2>

    {{-- Alerts --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Error Validation --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Tambah Rekap --}}
    <div class="card mb-4">
        <div class="card-header bg-light">Tambah Rekap Latihan</div>
        <div class="card-body">
            <form action="{{ route('backend.rekap_latihan.store', $anggota->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                            value="{{ old('tanggal') }}" required>
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="jarak" class="form-label">Jarak (m)</label>
                        <select name="jarak" class="form-select @error('jarak') is-invalid @enderror" required>
                            <option value="" disabled {{ old('jarak') ? '' : 'selected' }}>Pilih jarak</option>
                            @for ($i = 3; $i <= 9; $i++)
                                <option value="{{ $i }}" {{ old('jarak') == $i ? 'selected' : '' }}>{{ $i }} meter</option>
                            @endfor
                        </select>
                        @error('jarak')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @for ($i = 1; $i <= 3; $i++)
                        <div class="col-md-2 mb-2">
                            <label for="lemparan{{ $i }}" class="form-label">Lemparan {{ $i }}</label>
                            <input type="number" name="lemparan{{ $i }}" step="0.01"
                                class="form-control @error('lemparan'.$i) is-invalid @enderror"
                                value="{{ old('lemparan'.$i) }}">
                            @error('lemparan'.$i)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endfor
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Daftar Rekap --}}
    <div class="card mb-4">
        <div class="card-header bg-light">Daftar Rekap Latihan</div>
        <div class="card-body">
            @if ($rekap->count())
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Tanggal</th>
                                <th>Jarak (m)</th>
                                <th>L1</th>
                                <th>L2</th>
                                <th>L3</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekap as $item)
                                @php
                                    $canDelete = Auth::user()->role === 'admin' || Auth::id() === $item->user_id;
                                @endphp
                                <tr>
                                    <td>{{ $item->tanggal }}</td>
                                    <td>{{ $item->jarak }}</td>
                                    <td>{{ $item->lemparan1 }}</td>
                                    <td>{{ $item->lemparan2 }}</td>
                                    <td>{{ $item->lemparan3 }}</td>
                                    <td>
                                        <form action="{{ route('backend.rekap_latihan.destroy', $item->id) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return {{ $canDelete ? 'confirmDelete()' : 'false' }};">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-danger btn-sm {{ !$canDelete ? 'disabled' : '' }}"
                                                    title="{{ !$canDelete ? 'Hanya admin atau pemilik data yang dapat menghapus' : 'Hapus data' }}">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning mb-0">Belum ada data rekap latihan.</div>
            @endif
        </div>
    </div>

    <div class="d-flex justify-content-start">
        <a href="{{ route('backend.anggota.index') }}" class="btn btn-secondary">
            ← Kembali ke Daftar Anggota
        </a>
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm('Yakin ingin menghapus rekap ini?');
    }
</script>
@endsection
