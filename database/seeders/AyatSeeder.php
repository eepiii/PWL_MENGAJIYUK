<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class AyatSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Mengambil data ayat... (membutuhkan waktu & koneksi stabil)');

        // Ambil ID dari tabel surahs agar foreign key valid
        $surahs = DB::table('surahs')->pluck('id', 'nomor_surah');

        for ($nomor = 1; $nomor <= 114; $nomor++) {
            $response = Http::timeout(120)->retry(3, 2000)->get("https://equran.id/api/v2/surat/{$nomor}");

            if (!$response->successful()) {
                $this->command->warn("Skip surah {$nomor} - Gagal API");
                continue;
            }

            $data  = $response->json('data');
            $ayats = $data['ayat'];
            $surah_id_db = $surahs[$nomor] ?? $nomor;

            foreach ($ayats as $ayat) {
                DB::table('ayats')->updateOrInsert(
                    [
                        'surah_id'   => $surah_id_db,
                        'nomor_ayat' => $ayat['nomorAyat'],
                    ],
                    [
                        'teks_arab'  => $ayat['teksArab'],
                        'teks_latin' => $ayat['teksLatin'],
                        'terjemahan' => $ayat['teksIndonesia'],
                        'audio_url'  => $ayat['audio']['05'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
            $this->command->info("✓ Surah {$nomor} tersimpan");
            usleep(500000); 
        }
    }
}