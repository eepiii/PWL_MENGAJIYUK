<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JurnalIbadah;
use App\Models\User;
use Carbon\Carbon;

class JurnalIbadahSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now();

        foreach ($users as $user) {
            $currentDate = $startDate->copy();

            while ($currentDate <= $endDate) {
                JurnalIbadah::updateOrCreate(
                    [
                        'santri_id' => $user->id,
                        'tanggal'   => $currentDate->format('Y-m-d'),
                    ],
                    [
                        'shalat_subuh'    => rand(0, 2),
                        'shalat_dzuhur'   => rand(0, 2),
                        'shalat_ashar'    => rand(0, 2),
                        'shalat_maghrib'  => rand(0, 2),
                        'shalat_isya'     => rand(0, 2),
                        'puasa_sunnah'    => (bool) rand(0, 1),
                        'tilawah_halaman' => rand(0, 20),
                        'catatan'         => 'Seeder otomatis tanggal ' . $currentDate->format('d-m-Y'),
                    ]
                );

                $currentDate->addDay();
            }
        }
    }
}