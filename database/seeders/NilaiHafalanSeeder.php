<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\HafalanSetoran;
use App\Models\NilaiHafalan;

class NilaiHafalanSeeder extends Seeder
{
    public function run(): void
    {
        $guru = User::role('guru')->first();

        if (!$guru) {
            $this->command->warn('Tidak ada user dengan role guru, seeder dilewati.');
            return;
        }

        $setoranDinilai = HafalanSetoran::where('status', 'dinilai')->get();

        if ($setoranDinilai->isEmpty()) {
            $this->command->warn('Tidak ada setoran berstatus "dinilai", seeder dilewati.');
            return;
        }

        foreach ($setoranDinilai as $setoran) {
            $kelancaran = rand(65, 100);
            $tajwid     = rand(65, 100);
            $makhraj    = rand(65, 100);
            $nilaiTotal = (int) round(($kelancaran + $tajwid + $makhraj) / 3);

            NilaiHafalan::updateOrCreate(
                ['hafalan_setoran_id' => $setoran->id],
                [
                    'guru_id'     => $guru->id,
                    'kelancaran'  => $kelancaran,
                    'tajwid'      => $tajwid,
                    'makhraj'     => $makhraj,
                    'nilai_total' => $nilaiTotal,
                    'catatan'     => 'Tingkatkan tajwid.',
                ]
            );
        }
    }
}