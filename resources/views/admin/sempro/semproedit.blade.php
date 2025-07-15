@extends('layout.template')

@section('main')
    @if (session()->has('Success'))
        <div class="alert alert-Success" role="alert">
            {{ session('Success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif
    <form method="post" action="/sempro/{{ $sempro->id }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="width-75">
            <div class="mb-3">
                <label for="dokumen" class="form-label">Upload Proposal Baru</label>
                <p>Silahkan upload proposal anda</p>
                <input class="form-control @error('dokumen') is-invalid @enderror" type="file" id="dokumen"
                    name="dokumen" accept=".pdf" onchange="previewImage(event)" required>
                <div id="fileHelp" class="form-text">Pastikan file adalah PDF</div>
                @error('dokumen')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary float-end mx-1">Submit</button>
        <a href="/sempro" class="btn btn-primary float-end">Kembali</a>
    </form>
@endsection
