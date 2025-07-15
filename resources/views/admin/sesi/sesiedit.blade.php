@extends('layout.template')

@section('main')
    <div class="card m-1 p-4">
        <h1>Update Data</h1>
        <div class="">
            <a href="/admin/session" class="btn btn-primary my-3 col-1 d-inline-block" style="width:auto">Kembali</a>
        </div>

        <form method="post" action="/admin/session/{{ $sesi->id }}">
            @csrf
            @method('put')
            <div class="width-75">
                <div class="mb-3">
                    <label for="namasesi" class="form-label">Nama sesi</label>
                    <input type="text" class="form-control" id="namasesi" name="namasesi" value="{{ $sesi->namasesi }}">
                    @error('namasesi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="waktumulai" class="form-label">Nama sesi</label>
                    <input type="time" class="form-control" id="waktumulai" name="waktumulai"
                        value="{{ $sesi->waktumulai }}">
                    @error('waktumulai')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="waktuakhir" class="form-label">Nama sesi</label>
                    <input type="time" class="form-control" id="waktuakhir" name="waktuakhir"
                        value="{{ $sesi->waktuakhir }}">
                    @error('waktuakhir')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
