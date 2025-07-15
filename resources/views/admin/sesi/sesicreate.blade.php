@extends('layout.template')

@section('main')
    <div class="card m-1 p-4">
        <h2>Tambah Sesi Baru</h2>
        <div class="">
            <a href="/admin/session" class="btn btn-primary my-3 col-1 d-inline-block" style="width:auto">Kembali</a>
        </div>

        <form method="post" action="/admin/session">
            @csrf
            <div class="width-75">
                <div class="mb-3">
                    <label for="namasesi" class="form-label">Nama Sesi</label>
                    <input type="text" class="form-control @error('namasesi') is-invalid @enderror" id="namasesi"
                        name="namasesi" value="{{ old('namasesi') }}">
                    @error('namasesi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="waktumulai" class="form-label">Waktu Mulai</label>
                    <input type="time" class="form-control @error('waktumulai') is-invalid @enderror" id="waktumulai"
                        name="waktumulai" value="{{ old('waktumulai') }}">
                    @error('waktumulai')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="waktuakhir" class="form-label">Waktu Akhir</label>
                    <input type="time" class="form-control @error('waktuakhir') is-invalid @enderror" id="waktuakhir"
                        name="waktuakhir" value="{{ old('waktuakhir') }}">
                    @error('waktuakhir')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
