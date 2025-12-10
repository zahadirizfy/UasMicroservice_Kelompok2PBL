@extends('backend.layouts.app')

@section('title', 'Input Hasil Pertandingan')

@section('content')
    <div class="text-center mb-4">
        <h2>Input Hasil Pertandingan</h2>
        <hr>
    </div>

    {{-- Tampilkan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('backend.detail_hasil_pertandingan.store', $hasilPertandingan->id) }}" method="POST"
        class="border p-4 rounded bg-light shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="nama" class="form-label fw-bold">Nama Peserta <span class="text-danger">*</span></label>
            <select name="nama" id="nama" class="form-control" required>
                <option value="">-- Pilih Peserta --</option>
                @foreach ($pesertas as $peserta)
                    <option value="{{ $peserta->atlet->nama }}"
                        {{ old('nama') == $peserta->atlet->nama ? 'selected' : '' }}>
                        {{ $peserta->atlet->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        @for ($i = 1; $i <= 5; $i++)
            <div class="mb-3">
                <label for="lemparan{{ $i }}" class="form-label fw-bold">Lemparan {{ $i }}</label>
                <input type="number" step="0.01" name="lemparan{{ $i }}" id="lemparan{{ $i }}"
                    class="form-control" value="{{ old('lemparan' . $i) }}">
            </div>
        @endfor

        <div class="mb-3">
            <label for="skor" class="form-label fw-bold">Skor</label>
            <input type="number" step="0.01" name="skor" id="skor" class="form-control"
                value="{{ old('skor') }}">
        </div>

        <div class="mb-3">
            <label for="rangking" class="form-label fw-bold">Rangking</label>
            <input type="number" name="rangking" id="rangking" class="form-control" value="{{ old('rangking') }}">
        </div>

        <div class="mb-3">
            <label for="catatan_juri" class="form-label fw-bold">Catatan Juri (Opsional)</label>
            <textarea name="catatan_juri" id="catatan_juri" class="form-control" rows="3">{{ old('catatan_juri') }}</textarea>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <div>
                <a href="{{ route('backend.detail_hasil_pertandingan.index', $hasilPertandingan->id) }}"
                    class="btn btn-secondary">← Kembali</a>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
                <button type="reset" class="btn btn-warning">
                    <i class="fas fa-rotate-left me-1"></i> Reset
                </button>
            </div>
        </div>

    </form>
@endsection
