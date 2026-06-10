<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Criteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed criterias (5 kriteria awal)
        Criteria::create([
            'kode' => 'C1',
            'nama_kriteria' => 'Engagement Rate',
            'atribut' => 'Benefit',
            'bobot' => 0.25,
        ]);

        Criteria::create([
            'kode' => 'C2',
            'nama_kriteria' => 'Jumlah Followers',
            'atribut' => 'Benefit',
            'bobot' => 0.20,
        ]);

        Criteria::create([
            'kode' => 'C3',
            'nama_kriteria' => 'Kesesuaian Niche',
            'atribut' => 'Benefit',
            'bobot' => 0.20,
        ]);

        Criteria::create([
            'kode' => 'C4',
            'nama_kriteria' => 'Biaya per Post',
            'atribut' => 'Cost',
            'bobot' => 0.20,
        ]);

        Criteria::create([
            'kode' => 'C5',
            'nama_kriteria' => 'Attitude & Profesionalisme',
            'atribut' => 'Benefit',
            'bobot' => 0.15,
        ]);

        // Seed 1 dummy campaign awal
        Campaign::create([
            'nama_umkm' => 'Toko Fashion Online "Elegance"',
            'tipe_umkm' => 'Fashion & Pakaian',
            'nama_proyek' => 'Kampanye Koleksi Summer 2025',
        ]);
    }
}
