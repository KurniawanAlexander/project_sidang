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

    @can('isMahasiswa')
        <table class="table table-bordered table-striped table-hover">
            <thead class="text-center">
                <tr>
                    <th colspan="2" class="bg-light">Detail Sidang Tugas Akhir</th>
                </tr>
            </thead>
            <tbody>
                {{-- Judul Proposal --}}
                <tr>
                    <th scope="row" style="width: 200px;">Judul Proposal</th>
                    <td>{{ $sita->sitatugasakhir->pilihjudul ?? 'Data tidak tersedia' }}</td>
                </tr>

                {{-- Verifikasi Pembimbing --}}
                <tr>
                    <th scope="row">Verifikasi Pembimbing 1</th>
                    <td>
                        {{ $sita->pembimbing1_acc === 0 ? 'Belum Diverifikasi' : 'Sudah Diverifikasi' }}
                    </td>
                </tr>
                <tr>
                    <th scope="row">Verifikasi Pembimbing 2</th>
                    <td>
                        {{ $sita->pembimbing2_acc === 0 ? 'Belum Diverifikasi' : 'Sudah Diverifikasi' }}
                    </td>
                </tr>

                {{-- Penguji dan Tanggal Sidang --}}
                @if ($sita->penguji1_id != 0)
                    <tr>
                        <th scope="row">Penguji Satu</th>
                        <td>{{ $sita->penguji1sita->nama_dosen ?? 'Data tidak tersedia' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Penguji Dua</th>
                        <td>{{ $sita->penguji2sita->nama_dosen ?? 'Data tidak tersedia' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Tanggal Sidang</th>
                        <td>
                            {{ $sita->tgl_sita? \Carbon\Carbon::parse($sita->tgl_sita)->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm'): 'Belum dijadwalkan' }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Ruangan Sidang</th>
                        <td>
                            {{ $sita->ruangansita->kode_ruangan ?? 'Kode tidak tersedia' }} -
                            {{ $sita->ruangansita->ruangan ?? 'Data tidak tersedia' }}
                        </td>
                    </tr>
                @endif

                {{-- Dokumen Proposal --}}
                <tr>
                    <th scope="row" class="bg-light">Dokumen Proposal</th>
                    <td>
                        @if ($sita->tugasakhir_id)
                            <a href="{{ Storage::url($sita->sitatugasakhir->dokumen) }}" class="btn btn-secondary btn-sm"
                                target="_blank">Lihat Dokumen</a>
                        @else
                            <span>Tidak ada dokumen</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="bg-light"></th>
                    <td colspan="2"><a href="/downloadproposal/{{ $sita->tugasakhir_id }}"
                            class="btn btn-secondary btn-sm">Unduh Dokumen</a></td>
                </tr>

                {{-- Nilai --}}
                @if ($sita->status == 6)
                    <tr>
                        <th scope="row">Nilai Sidang Akhir</th>
                        <td>{{ $sita->nilaiakhir ?? 'Belum Dinilai' }}</td>
                    </tr>
                @endif

                {{-- Status --}}
                <tr>
                    <th scope="row">Status</th>
                    <td>
                        @switch($sita->status)
                            @case(1)
                                Sedang Diajukan
                            @break

                            @case(2)
                                Sudah Divalidasi
                            @break

                            @case(3)
                                Sudah Dijadwalkan
                            @break

                            @case(4)
                                Sedang Sidang
                            @break

                            @case(5)
                                Sedang Dinilai
                            @break

                            @case(6)
                                Lulus
                            @break

                            @case(7)
                                Tidak Lulus, <a href="/sita/create">Daftar Lagi?</a>
                            @break

                            @default
                                Status Tidak Diketahui
                        @endswitch
                    </td>
                </tr>
            </tbody>
        </table>


        @if ($sita->status == 6 || $sita->status == 7)
            <h5 class="text-center mt-4">DETAIL PENILAIAN</h5>
            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="text-center">
                        <tr>
                            <th colspan="2" class="bg-light" scope="row">Pembimbing Satu</th>
                            <th class="bg-light">Bobot</th>
                            <th class="bg-light">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Makalah Section -->
                        <tr class="text-center bg-white text-white">
                            <th colspan="4">Makalah (40%)</th>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Identifikasi Masalah</th>
                            <td>Tujuan dan kontribusi penelitian.</td>
                            <td>5%</td>
                            <td>{{ $pembimbing1->nl_identifikasimasalah ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Relevansi Teori</th>
                            <td>Referensi pustaka dan konsep dengan masalah penelitian.</td>
                            <td>5%</td>
                            <td>{{ $pembimbing1->nl_relevansiteori ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Metodologi Penelitian</th>
                            <td>Keselarasan metode dengan masalah penelitian.</td>
                            <td>10%</td>
                            <td>{{ $pembimbing1->nl_metodologipenelitian ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Hasil dan Pembahasan</th>
                            <td>Uraian hasil penelitian secara terperinci.</td>
                            <td>10%</td>
                            <td>{{ $pembimbing1->nl_hasilpembahasan ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Kesimpulan dan Sarana</th>
                            <td>Kesimpulan logis dan relevan dengan tujuan penelitian.</td>
                            <td>5%</td>
                            <td>{{ $pembimbing1->nl_kesimpulansarana ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Penggunaan Bahasa</th>
                            <td>Kesesuaian tata tulis dan bahasa.</td>
                            <td>5%</td>
                            <td>{{ $pembimbing1->nl_bahasatatatulis ?? 'Belum Dinilai' }}</td>
                        </tr>

                        <!-- Presentasi Section -->
                        <tr class="text-center bg-white text-white">
                            <th colspan="4">Presentasi (30%)</th>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Sikap dan Penampilan</th>
                            <td>Keberanian, sikap, dan kesopanan saat presentasi.</td>
                            <td>5%</td>
                            <td>{{ $pembimbing1->nl_sikappenampilan ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Komunikasi</th>
                            <td>Kejelasan dan runtutan sistematika.</td>
                            <td>5%</td>
                            <td>{{ $pembimbing1->nl_komunikasisistematika ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Penguasaan Materi</th>
                            <td>Kemampuan memahami dan menjawab pertanyaan.</td>
                            <td>20%</td>
                            <td>{{ $pembimbing1->nl_penguasaanmateri ?? 'Belum Dinilai' }}</td>
                        </tr>

                        <!-- Produk Section -->
                        <tr class="text-center bg-white text-white">
                            <th colspan="4">Produk (30%)</th>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Fungsionalitas Sistem</th>
                            <td>Keselarasan fungsi dengan tujuan yang direncanakan.</td>
                            <td>30%</td>
                            <td>{{ $pembimbing1->nl_kesesuaianfungsi ?? 'Belum Dinilai' }}</td>
                        </tr>

                        <!-- Total and Comments -->
                        <tr class="text-end">
                            <td colspan="3"><strong>Total Nilai</strong></td>
                            <td><strong>{{ $pembimbing1->totalnilai ?? 'Belum Dinilai' }}</strong></td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Komentar Pembimbing</th>
                            <td colspan="3">{{ $pembimbing1->komentar ?? 'Tidak Ada Komentar' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-5"></div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="text-center">
                        <tr>
                            <th colspan="2" class="bg-light" scope="row">Pembimbing Dua</th>
                            <th class="bg-light">Bobot</th>
                            <th class="bg-light">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Makalah Section -->
                        <tr class="text-center bg-white text-white">
                            <th colspan="4">Makalah (40%)</th>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Identifikasi Masalah</th>
                            <td>Tujuan dan kontribusi penelitian.</td>
                            <td>5%</td>
                            <td>{{ $pembimbing2->nl_identifikasimasalah ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Relevansi Teori</th>
                            <td>Referensi pustaka dan konsep dengan masalah penelitian.</td>
                            <td>5%</td>
                            <td>{{ $pembimbing2->nl_relevansiteori ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Metodologi Penelitian</th>
                            <td>Keselarasan metode dengan masalah penelitian.</td>
                            <td>10%</td>
                            <td>{{ $pembimbing2->nl_metodologipenelitian ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Hasil dan Pembahasan</th>
                            <td>Uraian hasil penelitian secara terperinci.</td>
                            <td>10%</td>
                            <td>{{ $pembimbing2->nl_hasilpembahasan ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Kesimpulan dan Sarana</th>
                            <td>Kesimpulan logis dan relevan dengan tujuan penelitian.</td>
                            <td>5%</td>
                            <td>{{ $pembimbing2->nl_kesimpulansarana ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Penggunaan Bahasa</th>
                            <td>Kesesuaian tata tulis dan bahasa.</td>
                            <td>5%</td>
                            <td>{{ $pembimbing2->nl_bahasatatatulis ?? 'Belum Dinilai' }}</td>
                        </tr>

                        <!-- Presentasi Section -->
                        <tr class="text-center bg-white text-white">
                            <th colspan="4">Presentasi (30%)</th>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Sikap dan Penampilan</th>
                            <td>Keberanian, sikap, dan kesopanan saat presentasi.</td>
                            <td>5%</td>
                            <td>{{ $pembimbing2->nl_sikappenampilan ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Komunikasi</th>
                            <td>Kejelasan dan runtutan sistematika.</td>
                            <td>5%</td>
                            <td>{{ $pembimbing2->nl_komunikasisistematika ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Penguasaan Materi</th>
                            <td>Kemampuan memahami dan menjawab pertanyaan.</td>
                            <td>20%</td>
                            <td>{{ $pembimbing2->nl_penguasaanmateri ?? 'Belum Dinilai' }}</td>
                        </tr>

                        <!-- Produk Section -->
                        <tr class="text-center bg-white text-white">
                            <th colspan="4">Produk (30%)</th>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Fungsionalitas Sistem</th>
                            <td>Keselarasan fungsi dengan tujuan yang direncanakan.</td>
                            <td>30%</td>
                            <td>{{ $pembimbing2->nl_kesesuaianfungsi ?? 'Belum Dinilai' }}</td>
                        </tr>

                        <!-- Total and Comments -->
                        <tr class="text-end">
                            <td colspan="3"><strong>Total Nilai</strong></td>
                            <td><strong>{{ $pembimbing2->totalnilai ?? 'Belum Dinilai' }}</strong></td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Komentar Pembimbing</th>
                            <td colspan="3">{{ $pembimbing2->komentar ?? 'Tidak Ada Komentar' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-5"></div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="text-center">
                        <tr>
                            <th colspan="2" class="bg-light" scope="row">Penguji Satu</th>
                            <th class="bg-light">Bobot</th>
                            <th class="bg-light">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Makalah Section -->
                        <tr class="text-center bg-white text-white">
                            <th colspan="4">Makalah (40%)</th>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Identifikasi Masalah</th>
                            <td>Tujuan dan kontribusi penelitian.</td>
                            <td>5%</td>
                            <td>{{ $penguji1->nl_identifikasimasalah ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Relevansi Teori</th>
                            <td>Referensi pustaka dan konsep dengan masalah penelitian.</td>
                            <td>5%</td>
                            <td>{{ $penguji1->nl_relevansiteori ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Metodologi Penelitian</th>
                            <td>Keselarasan metode dengan masalah penelitian.</td>
                            <td>10%</td>
                            <td>{{ $penguji1->nl_metodologipenelitian ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Hasil dan Pembahasan</th>
                            <td>Uraian hasil penelitian secara terperinci.</td>
                            <td>10%</td>
                            <td>{{ $penguji1->nl_hasilpembahasan ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Kesimpulan dan Sarana</th>
                            <td>Kesimpulan logis dan relevan dengan tujuan penelitian.</td>
                            <td>5%</td>
                            <td>{{ $penguji1->nl_kesimpulansarana ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Penggunaan Bahasa</th>
                            <td>Kesesuaian tata tulis dan bahasa.</td>
                            <td>5%</td>
                            <td>{{ $penguji1->nl_bahasatatatulis ?? 'Belum Dinilai' }}</td>
                        </tr>

                        <!-- Presentasi Section -->
                        <tr class="text-center bg-white text-white">
                            <th colspan="4">Presentasi (30%)</th>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Sikap dan Penampilan</th>
                            <td>Keberanian, sikap, dan kesopanan saat presentasi.</td>
                            <td>5%</td>
                            <td>{{ $penguji1->nl_sikappenampilan ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Komunikasi</th>
                            <td>Kejelasan dan runtutan sistematika.</td>
                            <td>5%</td>
                            <td>{{ $penguji1->nl_komunikasisistematika ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Penguasaan Materi</th>
                            <td>Kemampuan memahami dan menjawab pertanyaan.</td>
                            <td>20%</td>
                            <td>{{ $penguji1->nl_penguasaanmateri ?? 'Belum Dinilai' }}</td>
                        </tr>

                        <!-- Produk Section -->
                        <tr class="text-center bg-white text-white">
                            <th colspan="4">Produk (30%)</th>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Fungsionalitas Sistem</th>
                            <td>Keselarasan fungsi dengan tujuan yang direncanakan.</td>
                            <td>30%</td>
                            <td>{{ $penguji1->nl_kesesuaianfungsi ?? 'Belum Dinilai' }}</td>
                        </tr>

                        <!-- Total and Comments -->
                        <tr class="text-end">
                            <td colspan="3"><strong>Total Nilai</strong></td>
                            <td><strong>{{ $penguji1->totalnilai ?? 'Belum Dinilai' }}</strong></td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Komentar Penguji</th>
                            <td colspan="3">{{ $penguji1->komentar ?? 'Tidak Ada Komentar' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <div class="mt-5"></div>

            <div class="table-responsive my-3">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="text-center">
                        <tr>
                            <th colspan="2" class="bg-light" scope="row">Penguji Dua</th>
                            <th class="bg-light">Bobot</th>
                            <th class="bg-light">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Makalah Section -->
                        <tr class="text-center bg-white text-white">
                            <th colspan="4">Makalah (40%)</th>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Identifikasi Masalah</th>
                            <td>Tujuan dan kontribusi penelitian.</td>
                            <td>5%</td>
                            <td>{{ $penguji2->nl_identifikasimasalah ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Relevansi Teori</th>
                            <td>Referensi pustaka dan konsep dengan masalah penelitian.</td>
                            <td>5%</td>
                            <td>{{ $penguji2->nl_relevansiteori ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Metodologi Penelitian</th>
                            <td>Keselarasan metode dengan masalah penelitian.</td>
                            <td>10%</td>
                            <td>{{ $penguji2->nl_metodologipenelitian ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Hasil dan Pembahasan</th>
                            <td>Uraian hasil penelitian secara terperinci.</td>
                            <td>10%</td>
                            <td>{{ $penguji2->nl_hasilpembahasan ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Kesimpulan dan Sarana</th>
                            <td>Kesimpulan logis dan relevan dengan tujuan penelitian.</td>
                            <td>5%</td>
                            <td>{{ $penguji2->nl_kesimpulansarana ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Penggunaan Bahasa</th>
                            <td>Kesesuaian tata tulis dan bahasa.</td>
                            <td>5%</td>
                            <td>{{ $penguji2->nl_bahasatatatulis ?? 'Belum Dinilai' }}</td>
                        </tr>

                        <!-- Presentasi Section -->
                        <tr class="text-center bg-white text-white">
                            <th colspan="4">Presentasi (30%)</th>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Sikap dan Penampilan</th>
                            <td>Keberanian, sikap, dan kesopanan saat presentasi.</td>
                            <td>5%</td>
                            <td>{{ $penguji2->nl_sikappenampilan ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Komunikasi</th>
                            <td>Kejelasan dan runtutan sistematika.</td>
                            <td>5%</td>
                            <td>{{ $penguji2->nl_komunikasisistematika ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Penguasaan Materi</th>
                            <td>Kemampuan memahami dan menjawab pertanyaan.</td>
                            <td>20%</td>
                            <td>{{ $penguji2->nl_penguasaanmateri ?? 'Belum Dinilai' }}</td>
                        </tr>

                        <!-- Produk Section -->
                        <tr class="text-center bg-white text-white">
                            <th colspan="4">Produk (30%)</th>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Fungsionalitas Sistem</th>
                            <td>Keselarasan fungsi dengan tujuan yang direncanakan.</td>
                            <td>30%</td>
                            <td>{{ $penguji2->nl_kesesuaianfungsi ?? 'Belum Dinilai' }}</td>
                        </tr>

                        <!-- Total and Comments -->
                        <tr class="text-end">
                            <td colspan="3"><strong>Total Nilai</strong></td>
                            <td><strong>{{ $penguji2->totalnilai ?? 'Belum Dinilai' }}</strong></td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-light">Komentar Penguji</th>
                            <td colspan="3">{{ $penguji2->komentar ?? 'Tidak Ada Komentar' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif
    @endcan

    @can('isSuperAdmin')
        <h2>Data Sidang Tugas Akhir</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Mahasiswa</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->sitatugasakhir->tugasakhirmahasiswa->nama }}</td>
                            <td>
                                <a href="/detailsita/{{ $item->id }}" class="btn btn-info">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endcan

    @can('isDosen')
        <h2>Data Sidang Tugas Akhir</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Mahasiswa</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sita as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->sitatugasakhir->tugasakhirmahasiswa->nama }}</td>
                            <td>
                                <a href="/detailsita/{{ $item->id }}" class="btn btn-info">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endcan

    @can('isKaprodi')
        <h2>Data Sidang Tugas Akhir</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Mahasiswa</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sita as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->sitatugasakhir->tugasakhirmahasiswa->nama }}</td>
                            <td>
                                <a href="/detailsita/{{ $item->id }}" class="btn btn-info">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endcan

@endsection
