<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class SurahSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Mengambil data surah dari EQuran.id...');

        $response = Http::timeout(120)->retry(3, 1000)->get('https://equran.id/api/v2/surat');

        if (!$response->successful()) {
            $this->command->error('Gagal ambil data API!');
            return;
        }

        $listSurah = $response->json('data');

        foreach ($listSurah as $surah) {
            DB::table('surahs')->updateOrInsert(
                ['nomor_surah' => $surah['nomor']],
                [
                    'nama_arab'   => $surah['nama'],
                    'nama_latin'  => $surah['namaLatin'],
                    'arti'        => $surah['arti'],
                    'jumlah_ayat' => $surah['jumlahAyat'],
                    'jenis'       => strtolower($surah['tempatTurun']),
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]
            );
            $this->command->info("✓ {$surah['nomor']}. {$surah['namaLatin']}");
        }
    }
}