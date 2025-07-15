<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\clustering;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\clustering as ModelsClustering;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $statuses = ['diterima', 'ditolak', 'pending'];
        $tahun = 2025;

        for ($i = 1; $i <= 200; $i++) {

            clustering::create([
                'judul_proposal' => "Analisis Sistem Informasi Ke-" . $i,
                'abstrak' => "Penelitian ini bertujuan untuk menganalisis dan mengembangkan sistem informasi berbasis teknologi terkini dengan studi kasus ke-" . $i,
                'kata_kunci' => "sistem informasi, teknologi, analisis, proposal $i",
                'mahasiswa' => "Mahasiswa " . Str::random(5),
                'nim' => '21' . str_pad((string)$i, 6, '0', STR_PAD_LEFT),
                'dosen' => null,
                'keahlian_dosen' => null,
                'tahun' => $tahun,
                'status_proposal' => $statuses[array_rand($statuses)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
