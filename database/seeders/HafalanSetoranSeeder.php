<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HafalanSetoran;
use App\Models\Surah;
use App\Models\User;

class HafalanSetoranSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::role('santri')->first();
        $surahAlMulk = Surah::where('nomor_surah', 67)->first();
        $surahAlWaqiah = Surah::where('nomor_surah', 56)->first();

        if (!$user || !$surahAlMulk || !$surahAlWaqiah) {
            $this->command->warn('User santri / data surah belum lengkap, seeder dilewati.');
            return;
        }

        HafalanSetoran::create([
            'santri_id'    => $user->id,
            'surah_id'     => $surahAlMulk->id,
            'ayat_mulai'   => 1,
            'ayat_selesai' => 10,
            'audio_path'   => 'setoran_audio/dummy_rekaman_1.webm',
            'catatan'      => "Sudah muroja'ah sebelum setor.",
            'status'       => 'dinilai',
        ]);

        HafalanSetoran::create([
            'santri_id'    => $user->id,
            'surah_id'     => $surahAlWaqiah->id,
            'ayat_mulai'   => 1,
            'ayat_selesai' => 5,
            'audio_path'   => 'setoran_audio/dummy_rekaman_2.webm',
            'catatan'      => null,
            'status'       => 'menunggu',
        ]);
    }
}