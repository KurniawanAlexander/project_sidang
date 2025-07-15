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
    <form method="post" action="/semprojadwal/{{ $id }}" enctype="multipart/form-data">
        @csrf
        <div class="width-75">
            <div class="mb-3">
                <label for="penguji_id" class="form-label">Dosen Penguji</label>
                <br>
                <select name="penguji_id" class="form-select @error('penguji_id') is-invalid @enderror" required>
                    <option value="-" class="form-control">Pilih</option>
                    @foreach ($dosen as $item)
                        <option value="{{ $item->id }}" @if (old('penguji_id') == $item->id) selected @endif>
                            {{ $item->nama_dosen }}</option>
                    @endforeach
                </select>
                @error('penguji_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="tgl_sempro" class="form-label">Tanggal dan Waktu Seminar Proposal</label>
                <input type="datetime-local" class="form-control @error('tgl_sempro') is-invalid @enderror" id="tgl_sempro"
                    name="tgl_sempro"
                    value="{{ old('tgl_sempro', isset($sempro) ? $sempro->tgl_sempro->format('Y-m-d\TH:i') : '') }}"
                    required>
                @error('tgl_sempro')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="ruangan_id" class="form-label">Ruangan</label>
                <br>
                <select name="ruangan_id" class="form-select @error('ruangan_id') is-invalid @enderror" required>
                    <option value="-" class="form-control">Pilih</option>
                    @foreach ($ruangan as $item)
                        <option value="{{ $item->id }}" @if (old('ruangan_id') == $item->id) selected @endif>
                            {{ $item->ruangan }} {{ $item->kode_ruangan }}</option>
                    @endforeach
                </select>
                @error('ruangan_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>
        <div class="mb-3 d-flex justify-content-start gap-2">
            <input class="btn btn-primary d-inline" type="submit" name="submit" value="Simpan">
            <a href="/detailsempro/5" class="btn btn-outline-primary d-inline">
                Kembali
            </a>
        </div>
    </form>
@endsection
