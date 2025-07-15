@extends('layout.template')

@section('main')
    @if (session()->has('Success'))
        <div class="alert alert-success" role="alert">
            {{ session('Success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif
    <form action="{{ route('bimbingan.update', $bimbingan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Gunakan metode PUT untuk update -->
        <div class="width-75">
            <div class="mb-3">
                <label class="form-label" for="pembimbing_id">Pilih Pembimbing</label>
                <select class="form-select @error('pembimbing_id') is-invalid @enderror" name="pembimbing_id" required>
                    <option value="">Pilih Pembimbing</option>
                    <option value="{{ $tugasakhir->pembimbing1 }}"
                        {{ old('pembimbing_id', $bimbingan->pembimbing_id) == $tugasakhir->pembimbing1 ? 'selected' : '' }}>
                        {{ $tugasakhir->pembimbingta1->nama_dosen }}
                    </option>
                    <option value="{{ $tugasakhir->pembimbing2 }}"
                        {{ old('pembimbing_id', $bimbingan->pembimbing_id) == $tugasakhir->pembimbing2 ? 'selected' : '' }}>
                        {{ $tugasakhir->pembimbingta2->nama_dosen }}
                    </option>
                </select>
                @error('pembimbing_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="pembahasan" class="form-label">Pembahasan</label>
                <input type="hidden" name="tugasakhir_id" value="{{ $tugasakhir->id ?? '' }}">
                <textarea id="pembahasan" name="pembahasan" class="form-control @error('pembahasan') is-invalid @enderror"
                    rows="5">{{ old('pembahasan', $bimbingan->pembahasan ?? '') }}</textarea>
                @error('pembahasan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3 d-flex justify-content-start gap-2">
            <input class="btn btn-primary d-inline" type="submit" name="submit" value="Simpan Perubahan">
            <a href="/kartubimbingan/{{ $tugasakhir->id ?? '' }}" class="btn btn-outline-primary d-inline">
                Kembali
            </a>
        </div>
    </form>
@endsection
