@extends('layout.template')

@section('main')
    <div class="container mt-4">
        <div class="card m-1 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0">Review Proposal Tugas Akhir Mahasiswa</h2>
                {{-- <a href="/tugasakhir/reviewta/1" class="btn btn-primary">Cluster</a> --}}
            </div>
            <form method="post" action={{ route('tugasakhir.reviewpost', $tugasakhir->id) }} enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="width-75">
                    <div class="mb-3">
                        <label for="mahasiswa_id" class="form-label">Nama Mahasiswa</label>
                        <input type="text" class="form-control" id="mahasiswa_id" name="mahasiswa_id"
                            value="{{ $tugasakhir->tugasakhirmahasiswa->nama }}" readonly>
                        @error('mahasiswa_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    @if ($tugasakhir->status_usulan == '0')
                        <div class="mb-3">
                            <label for="pilihjudul" class="form-label">Pilih Judul</label>
                            <select class="form-select" id="pilihjudul" name="pilihjudul" required>
                                <option value="">-- Pilih Judul Proposal Mahasiswa --</option>
                                <option value="{{ $tugasakhir->judulproposal1 }}">Judul 1: {{ $tugasakhir->judulproposal1 }}
                                    | Tema : {{ $tugasakhir->label }}
                                </option>
                                <option value="{{ $tugasakhir->judulproposal2 }}">Judul 2: {{ $tugasakhir->judulproposal2 }}
                                    | Tema : {{ $tugasakhir->label2 }}
                                </option>
                            </select>
                            @error('pilihjudul')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pembimbing1" class="form-label">Pembimbing 1</label>
                            <select class="form-select" id="pembimbing1" name="pembimbing1">
                                <option value="">-- Pilih Dosen Pembimbing 1 --</option>
                                @foreach ($dosen as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('pembimbing1') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_dosen }} | Bidang Keahlian :
                                        {{ $item->bidangkeahliandosen->bidangkeahlian }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pembimbing1')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pembimbing2" class="form-label">Pembimbing 2</label>
                            <select class="form-select" id="pembimbing2" name="pembimbing2">
                                <option value="">-- Pilih Dosen Pembimbing 2 --</option>
                                @foreach ($dosen as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('pembimbing2') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_dosen }} | Bidang Keahlian :
                                        {{ $item->bidangkeahliandosen->bidangkeahlian }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pembimbing2')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="reviewta" class="form-label">Komentar</label>
                            <textarea class="form-control" id="reviewta" rows="3" name="reviewta">{{ old('reviewta') }}</textarea>
                            @error('reviewta')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    @else
                        <div class="mb-3">
                            <label for="pilihjudul" class="form-label">Pilih Judul</label>
                            <select class="form-select" id="pilihjudul" name="pilihjudul" required>
                                <option value="">-- Pilih Judul Proposal Mahasiswa --</option>
                                <option value="{{ $tugasakhir->judulproposal1 }}"
                                    {{ $tugasakhir->pilihjudul == $tugasakhir->judulproposal1 ? 'selected' : '' }}>
                                    Judul 1: {{ $tugasakhir->judulproposal1 }} | Tema : {{ $tugasakhir->label }}
                                </option>
                                <option value="{{ $tugasakhir->judulproposal2 }}"
                                    {{ $tugasakhir->pilihjudul == $tugasakhir->judulproposal2 ? 'selected' : '' }}>
                                    Judul 2: {{ $tugasakhir->judulproposal2 }} | Tema : {{ $tugasakhir->label2 }}
                                </option>
                            </select>
                            @error('pilihjudul')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pembimbing1" class="form-label">Pembimbing 1</label>
                            <select class="form-select" id="pembimbing1" name="pembimbing1" required>
                                <option value="">-- Pilih Dosen Pembimbing 1 --</option>
                                @foreach ($dosen as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $item->id == $tugasakhir->pembimbing1 ? 'selected' : '' }}>
                                        {{ $item->nama_dosen }} | Bidang Keahlian : {{ $item->bidangkeahliandosen->bidangkeahlian}}
                                    </option>
                                @endforeach
                            </select>
                            @error('pembimbing1')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pembimbing2" class="form-label">Pembimbing 2</label>
                            <select class="form-select" id="pembimbing2" name="pembimbing2" required>
                                <option value="">-- Pilih Dosen Pembimbing 2 --</option>
                                @foreach ($dosen as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $item->id == $tugasakhir->pembimbing2 ? 'selected' : '' }}>
                                        {{ $item->nama_dosen }} | Bidang Keahlian : {{ $item->bidangkeahliandosen->bidangkeahlian}}
                                    </option>
                                @endforeach
                            </select>
                            @error('pembimbing2')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="reviewta" class="form-label">Komentar</label>
                            <textarea class="form-control" id="reviewta" rows="3" name="reviewta">{{ old('reviewta', $tugasakhir->reviewta) }}</textarea>
                            @error('reviewta')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    @endif

                    <button type="submit" class="btn btn-success" name="hasil" value="1">Diterima</button>
                    <button type="submit" class="btn btn-primary" name="hasil" value="2">Revisi</button>
                    <button type="submit" class="btn btn-danger" name="hasil" value="3">Ditolak</button>

            </form>
        </div>
    @endsection
