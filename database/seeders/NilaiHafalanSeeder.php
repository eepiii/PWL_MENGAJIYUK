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
        if (!$guru) return;

        $setoranDinilai = HafalanSetoran::where('status', 'dinilai')->get();

        foreach ($setoranDinilai as $setoran) {
            NilaiHafalan::create([
                'setoran_id'   => $setoran->id,
                'guru_id'      => $guru->id,
                'santri_id'    => $setoran->santri_id,
                'nilai'        => rand(65, 100),
                'kategori'     => collect(['lancar', 'cukup', 'perlu_ulang'])->random(),
                'catatan_guru' => 'Tingkatkan tajwid.',
                'dinilai_at'   => now()->subDays(rand(1, 14)),
            ]);
        }
    }
}