<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\HafalanSetoran; // ← gunakan model yang benar
use Spatie\Permission\Models\Role;

class HafalanSetoranSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan role 'santri' ada (untuk Spatie)
        Role::firstOrCreate(['name' => 'santri']);

        // Ambil semua user dengan role santri
        $santriList = User::role('santri')->get();

        // Jika belum ada user santri, buat dummy (opsional)
        if ($santriList->isEmpty()) {
            $santri = User::create([
                'name' => 'Santri Contoh',
                'email' => 'santri@example.com',
                'password' => bcrypt('password'),
            ]);
            $santri->assignRole('santri');
            $santriList = collect([$santri]);
        }

        $contohSetoran = [
            ['surah_id' => 1,  'ayat_mulai' => 1, 'ayat_selesai' => 7],
            ['surah_id' => 2,  'ayat_mulai' => 1, 'ayat_selesai' => 5],
        ];

        foreach ($santriList as $santri) {
            foreach ($contohSetoran as $setoran) {
                HafalanSetoran::create([ // ← perhatikan nama kelas
                    'santri_id'      => $santri->id,
                    'surah_id'       => $setoran['surah_id'],
                    'ayat_mulai'     => $setoran['ayat_mulai'],
                    'ayat_selesai'   => $setoran['ayat_selesai'],
                    'status'         => collect(['pending', 'dinilai'])->random(),
                    'catatan_santri' => 'Setoran rutin.',
                    'disetor_at'     => now()->subDays(rand(1, 30)),
                ]);
            }
        }
    }
}