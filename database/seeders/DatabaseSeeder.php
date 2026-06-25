<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleAndUserSeeder::class,    // 1. Buat User & Role Spatie
            SurahSeeder::class,          // 2. Tarik API Surah
            AyatSeeder::class,           // 3. Tarik API Ayat (Relasi ke Surah)
            HafalanSetoranSeeder::class, // 4. Dummy Setoran (Relasi ke User)
            NilaiHafalanSeeder::class,   // 5. Dummy Nilai (Relasi ke Setoran)
            JurnalIbadahSeeder::class,   // 6. Dummy Jurnal (Relasi ke User)
        ]);
    }
}