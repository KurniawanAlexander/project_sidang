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
        <form action="/inputnilaisita/{{ $sita->id }}" method="POST">
            @csrf
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Bobot</th>
                        <th>Kriteria Penilaian</th>
                        <th>Nilai (1-100)</th>
                        <th>Nilai X Bobot</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" class="text-bold">Makalah (40%)</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>5%</td>
                        <td>Identifikasi Masalah, tujuan dan kontribusi penelitian</td>
                        <td>
                            <input type="hidden" name="jabatan" value="{{ $jabatan }}">
                            <input type="hidden" name="id" value="{{ $penilaiansita->id ?? 0 }}">
                            <input type="number" class="form-control nilai-input" name="nl_identifikasimasalah"
                                min="0" max="100"
                                value="{{ $penilaiansita ? old('nl_identifikasimasalah', $penilaiansita->nl_identifikasimasalah) : old('nl_identifikasimasalah', '') }}"
                                data-bobot="0.05" oninput="hitungNilai(this)">
                            @error('nl_identifikasimasalah')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                        <td class="nilai-x-bobot">
                            {{ $penilaiansita && $penilaiansita->nl_identifikasimasalah ? $penilaiansita->nl_identifikasimasalah * 0.05 : '0' }}
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>5%</td>
                        <td>Relevansi teori/ referensi pustaka dan konsep dengan masalah penelitian</td>
                        <td>
                            <input type="number" class="form-control nilai-input" name="nl_relevansiteori" min="0"
                                max="100"
                                value="{{ old('nl_relevansiteori', $penilaiansita->nl_relevansiteori ?? '') }}"
                                data-bobot="0.05" oninput="hitungNilai(this)">
                            @error('nl_relevansiteori')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                        <td class="nilai-x-bobot">
                            {{ $penilaiansita && $penilaiansita->nl_relevansiteori ? $penilaiansita->nl_relevansiteori * 0.05 : '0' }}
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>10%</td>
                        <td>Metodologi penelitian</td>
                        <td>
                            <input type="number" class="form-control nilai-input" name="nl_metodologipenelitian"
                                min="0" max="100"
                                value="{{ old('nl_metodologipenelitian', $penilaiansita->nl_metodologipenelitian ?? '') }}"
                                data-bobot="0.10" oninput="hitungNilai(this)">
                            @error('nl_metodologipenelitian')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                        <td class="nilai-x-bobot">
                            {{ $penilaiansita && $penilaiansita->nl_metodologipenelitian ? $penilaiansita->nl_metodologipenelitian * 0.1 : '0' }}
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>10%</td>
                        <td>Hasil dan Pembahasan</td>
                        <td>
                            <input type="number" class="form-control nilai-input" name="nl_hasilpembahasan" min="0"
                                max="100"
                                value="{{ old('nl_hasilpembahasan', $penilaiansita->nl_hasilpembahasan ?? '') }}"
                                data-bobot="0.10" oninput="hitungNilai(this)">
                            @error('nl_hasilpembahasan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                        <td class="nilai-x-bobot">
                            {{ $penilaiansita && $penilaiansita->nl_hasilpembahasan ? $penilaiansita->nl_hasilpembahasan * 0.1 : '0' }}
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>5%</td>
                        <td>Kesimpulan dan Sarana</td>
                        <td>
                            <input type="number" class="form-control nilai-input" name="nl_kesimpulansarana" min="0"
                                max="100"
                                value="{{ old('nl_kesimpulansarana', $penilaiansita->nl_kesimpulansarana ?? '') }}"
                                data-bobot="0.05" oninput="hitungNilai(this)">
                            @error('nl_kesimpulansarana')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                        <td class="nilai-x-bobot">
                            {{ $penilaiansita && $penilaiansita->nl_kesimpulansarana ? $penilaiansita->nl_kesimpulansarana * 0.05 : '0' }}
                        </td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>5%</td>
                        <td>Penggunaan Bahasa dan Tata Tulis</td>
                        <td>
                            <input type="number" class="form-control nilai-input" name="nl_bahasatatatulis" min="0"
                                max="100"
                                value="{{ old('nl_bahasatatatulis', $penilaiansita->nl_bahasatatatulis ?? '') }}"
                                data-bobot="0.05" oninput="hitungNilai(this)">
                            @error('nl_bahasatatatulis')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                        <td class="nilai-x-bobot">
                            {{ $penilaiansita && $penilaiansita->nl_bahasatatatulis ? $penilaiansita->nl_bahasatatatulis * 0.05 : '0' }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-bold">Presentasi (30%)</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>5%</td>
                        <td>Sikap dan Penampilan</td>
                        <td>
                            <input type="number" class="form-control nilai-input" name="nl_sikappenampilan" min="0"
                                max="100"
                                value="{{ old('nl_sikappenampilan', $penilaiansita->nl_sikappenampilan ?? '') }}"
                                data-bobot="0.05" oninput="hitungNilai(this)">
                            @error('nl_sikappenampilan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                        <td class="nilai-x-bobot">
                            {{ $penilaiansita && $penilaiansita->nl_sikappenampilan ? $penilaiansita->nl_sikappenampilan * 0.05 : '0' }}
                        </td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>5%</td>
                        <td>Komunikasi dan Sistematika</td>
                        <td>
                            <input type="number" class="form-control nilai-input" name="nl_komunikasisistematika"
                                min="0" max="100"
                                value="{{ old('nl_komunikasisistematika', $penilaiansita->nl_komunikasisistematika ?? '') }}"
                                data-bobot="0.05" oninput="hitungNilai(this)">
                            @error('nl_komunikasisistematika')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                        <td class="nilai-x-bobot">
                            {{ $penilaiansita && $penilaiansita->nl_komunikasisistematika ? $penilaiansita->nl_komunikasisistematika * 0.05 : '0' }}
                        </td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>20%</td>
                        <td>Penguasaan Materi</td>
                        <td>
                            <input type="number" class="form-control nilai-input" name="nl_penguasaanmateri"
                                min="0" max="100"
                                value="{{ old('nl_penguasaanmateri', $penilaiansita->nl_penguasaanmateri ?? '') }}"
                                data-bobot="0.20" oninput="hitungNilai(this)">
                            @error('nl_penguasaanmateri')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                        <td class="nilai-x-bobot">
                            {{ $penilaiansita && $penilaiansita->nl_penguasaanmateri ? $penilaiansita->nl_penguasaanmateri * 0.2 : '0' }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-bold">Wawancara (30%)</td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>30%</td>
                        <td>Kesesuaian Fungsionalitas Sistem</td>
                        <td>
                            <input type="number" class="form-control nilai-input" name="nl_kesesuaianfungsi"
                                min="0" max="100"
                                value="{{ old('nl_kesesuaianfungsi', $penilaiansita->nl_kesesuaianfungsi ?? '') }}"
                                data-bobot="0.30" oninput="hitungNilai(this)">
                            @error('nl_kesesuaianfungsi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                        <td class="nilai-x-bobot">
                            {{ $penilaiansita && $penilaiansita->nl_kesesuaianfungsi ? $penilaiansita->nl_kesesuaianfungsi * 0.3 : '0' }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-bold text-end">Total</td>
                        <td>
                            <input type="text" id="nilai_rata_rata" name="totalnilai" class="form-control" readonly
                                value="{{ $penilaiansita
                                    ? $penilaiansita->nl_identifikasimasalah * 0.05 +
                                        $penilaiansita->nl_relevansiteori * 0.05 +
                                        $penilaiansita->nl_metodologipenelitian * 0.1 +
                                        $penilaiansita->nl_hasilpembahasan * 0.1 +
                                        $penilaiansita->nl_kesimpulansarana * 0.05 +
                                        $penilaiansita->nl_bahasatatatulis * 0.05 +
                                        $penilaiansita->nl_sikappenampilan * 0.05 +
                                        $penilaiansita->nl_komunikasisistematika * 0.05 +
                                        $penilaiansita->nl_penguasaanmateri * 0.2 +
                                        $penilaiansita->nl_kesesuaianfungsi * 0.3
                                    : '' }}">
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Komentar</strong></td>
                        <td colspan="4">
                            <textarea class="form-control" name="komentar">{{ old('komentar', $penilaiansita->komentar ?? '') }}</textarea>
                            @error('komentar')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="text-end">
                <a href="/detailsita/{{ $sita->id }}" class="btn btn-secondary me-2 my-3">Kembali</a>
                <button type="submit" class="btn btn-primary my-3">Simpan Penilaian</button>
            </div>
        </form>
    </div>

    <script>
        function hitungNilai(input) {
            const bobot = parseFloat(input.getAttribute('data-bobot'));
            const nilai = parseFloat(input.value) || 0;
            const hasil = (nilai * bobot).toFixed(2); // Menghitung Nilai X Bobot
            const cell = input.closest('tr').querySelector('.nilai-x-bobot');
            cell.textContent = hasil; // Menampilkan hasil perhitungan pada kolom Nilai X Bobot

            // Menghitung Total Nilai
            let totalNilai = 0;
            const nilaiXBobots = document.querySelectorAll('.nilai-x-bobot');
            nilaiXBobots.forEach(cell => {
                totalNilai += parseFloat(cell.textContent) || 0;
            });

            document.getElementById('nilai_rata_rata').value = totalNilai.toFixed(2); // Menampilkan Total Nilai
        }

        function updateTotalNilai() {
            let total = 0;
            // Ambil semua elemen dengan kelas 'nilai-x-bobot'
            document.querySelectorAll('.nilai-x-bobot').forEach(function(cell) {
                total += parseFloat(cell.textContent) || 0;
            });
            // Tampilkan total nilai pada field 'nilai_rata_rata'
            document.getElementById('nilai_rata_rata').value = total.toFixed(2);
        }
    </script>
@endsection
