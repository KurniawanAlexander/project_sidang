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

    <div class="table-responsive">
        <form action="/inputnilaisempro/{{ $sempro->id }}" method="POST">
            @csrf
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kriteria</th>
                        <th>Acuan Penilaian</th>
                        <th>Nilai (1-100)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Pendahuluan</td>
                        <td>Mahasiswa mampu menjelaskan latar belakang, tujuan, dan kontribusi penelitian.</td>
                        <td>
                            <input type="hidden" name="jabatan" value="{{ $jabatan }}">
                            <input type="hidden" name="id" value="{{ $penilaiansempro->id ?? 0 }}">
                            <input type="number" class="form-control nilai-input" name="nl_pendahuluan" min="0"
                                max="100" value="{{ old('nl_pendahuluan', $penilaiansempro->nl_pendahuluan ?? '') }}">
                            @error('nl_pendahuluan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Tinjauan Pustaka</td>
                        <td>Mahasiswa mampu menampilkan teori yang relevan dan dituliskan secara runtun dan lengkap dengan
                            disertai argumentasi ilmiah dari pengusul proposal.</td>
                        <td>
                            <input type="number" class="form-control nilai-input" name="nl_tinjauanpustaka" min="0"
                                max="100"
                                value="{{ old('nl_tinjauanpustaka', $penilaiansempro->nl_tinjauanpustaka ?? '') }}">
                            @error('nl_tinjauanpustaka')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Metodologi Penelitian</td>
                        <td>Mahasiswa mampu menentukan metode yang selaras dengan permasalahan dan konsep teori. Detail
                            rancangan penelitian diuraikan dengan runtun setiap tahapan dan dapat diselesaikan sesuai dengan
                            rencana waktu penelitian.</td>
                        <td>
                            <input type="number" class="form-control nilai-input" name="nl_metodologipenelitian"
                                min="0" max="100"
                                value="{{ old('nl_metodologipenelitian', $penilaiansempro->nl_metodologipenelitian ?? '') }}">
                            @error('nl_metodologipenelitian')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Penggunaan Bahasa dan Tata Tulis</td>
                        <td>Mahasiswa mampu menyusun naskah proposal menggunakan ejaan bahasa Indonesia yang baik dan benar,
                            serta mengikuti aturan dan panduan penulisan.</td>
                        <td>
                            <input type="number" class="form-control nilai-input" name="nl_bahasadantatatulis"
                                min="0" max="100"
                                value="{{ old('nl_bahasadantatatulis', $penilaiansempro->nl_bahasadantatatulis ?? '') }}">
                            @error('nl_bahasadantatatulis')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Presentasi</td>
                        <td>Komunikatif, ketepatan waktu, kejelasan, dan keruntunan dalam penyampaian materi.</td>
                        <td>
                            <input type="number" class="form-control nilai-input" name="nl_presentasi" min="0"
                                max="100" value="{{ old('nl_presentasi', $penilaiansempro->nl_presentasi ?? '') }}">
                            @error('nl_presentasi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Nilai Rata-rata</strong></td>
                        <td>
                            <input type="text" class="form-control" id="nilai_rata_rata" name="ratarata" value="0"
                                readonly>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Komentar</strong></td>
                        <td colspan="3">
                            <textarea class="form-control" name="komentar">{{ old('komentar', $penilaiansempro->komentar ?? '') }}</textarea>
                            @error('komentar')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="d-flex justify-content-end mt-3">
                <a href="/detailsempro/{{ $sempro->id }}" class="btn btn-secondary me-2">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nilaiInputs = document.querySelectorAll('.nilai-input');
            const rataRataInput = document.getElementById('nilai_rata_rata');

            function hitungRataRata() {
                let total = 0;
                let count = 0;

                nilaiInputs.forEach(input => {
                    const nilai = parseFloat(input.value) || 0;
                    total += nilai;
                    count++;
                });

                const rataRata = total / count;
                rataRataInput.value = rataRata.toFixed(2);
            }

            nilaiInputs.forEach(input => {
                input.addEventListener('input', hitungRataRata);
            });

            hitungRataRata();
        });
    </script>
@endsection
