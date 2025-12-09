@extends('backend.layouts.app')

@section('title', 'Edit Detail Hasil Pertandingan')

@section('content')
    <div class="text-center mb-4">
        <h2>Edit Hasil Pertandingan</h2>
        <hr>
    </div>

    {{-- Notifikasi jika ada error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('backend.detail_hasil_pertandingan.update', [
            'hasil_pertandingan_id' => $detail->hasil_pertandingan_id,
            'id' => $detail->id,
        ]) }}"
        method="POST" class="border p-4 rounded shadow-sm bg-light">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-bold">Nama Peserta</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $detail->nama) }}" required
                readonly>
        </div>

        @for ($i = 1; $i <= 5; $i++)
            <div class="mb-3">
                <label class="form-label fw-bold">Lemparan {{ $i }}</label>
                <input type="number" step="0.01" name="lemparan{{ $i }}" class="form-control"
                    value="{{ old("lemparan$i", $detail["lemparan$i"] ?? '') }}">
            </div>
        @endfor

        <div class="mb-3">
            <label class="form-label fw-bold">Skor</label>
            <input type="number" name="skor" class="form-control" value="{{ old('skor', $detail->skor) }}">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Rangking</label>
            <input type="number" name="rangking" class="form-control" value="{{ old('rangking', $detail->rangking) }}">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Catatan Juri</label>
            <textarea name="catatan_juri" class="form-control" rows="3">{{ old('catatan_juri', $detail->catatan_juri) }}</textarea>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('backend.detail_hasil_pertandingan.index', $detail->hasil_pertandingan_id) }}"
                class="btn btn-secondary">← Kembali</a>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Simpan
            </button>
            <button type="reset" class="btn btn-warning">
                <i class="fas fa-rotate-left me-1"></i> Reset
            </button>
        </div>
    </form>
@endsection
