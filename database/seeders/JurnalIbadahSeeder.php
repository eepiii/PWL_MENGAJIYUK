<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\JurnalIbadah;

class JurnalIbadahSeeder extends Seeder
{
    public function run(): void
    {
        $santriList = User::role('santri')->get();

        foreach ($santriList as $santri) {
            for ($i = 6; $i >= 0; $i--) {
                JurnalIbadah::create([
                    'santri_id'       => $santri->id,
                    'tanggal'         => now()->subDays($i)->toDateString(),
                    'shalat_subuh'    => rand(0, 2),
                    'shalat_dzuhur'   => rand(0, 2),
                    'shalat_ashar'    => rand(0, 2),
                    'shalat_maghrib'  => rand(0, 2),
                    'shalat_isya'     => rand(0, 2),
                    'puasa_sunnah'    => (bool) rand(0, 1),
                    'tilawah_halaman' => rand(0, 5),
                    'catatan'         => 'Alhamdulillah.',
                ]);
            }
        } 
    }
}