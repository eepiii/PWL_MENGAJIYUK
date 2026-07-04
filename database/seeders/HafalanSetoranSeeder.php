<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HafalanSetoran;
use App\Models\User;

class HafalanSetoranSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada user (santri) terlebih dahulu
        $user = User::first(); 

        if ($user) {
            HafalanSetoran::create([
                'santri_id' => $user->id,
                'surah' => 'Al-Mulk ayat 1-10',
                'audio_path' => 'setoran_audio/dummy_rekaman_1.webm',
                'catatan' => 'Bacaan tajwid sudah baik.'
            ]);

            HafalanSetoran::create([
                'santri_id' => $user->id,
                'surah' => 'Al-Waqiah ayat 1-5',
                'audio_path' => 'setoran_audio/dummy_rekaman_2.webm',
                'catatan' => 'Perhatikan makharijul huruf.'
            ]);
        }
    }
}