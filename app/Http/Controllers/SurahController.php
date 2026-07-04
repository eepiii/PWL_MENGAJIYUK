<?php

namespace App\Http\Controllers;

use App\Models\Surah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SurahController extends Controller
{
    // Tampilkan daftar semua surah
    public function index()
    {
        // Cek dulu apakah database sudah punya data surah
        if (Surah::count() === 0) {
            // Kalau kosong, ambil dari API lalu simpan ke database
            $response = Http::withoutVerifying()
                ->get('https://equran.id/api/v2/surat');

            if ($response->successful()) {
                foreach ($response->json('data') as $item) {
                    Surah::updateOrCreate(
                        ['nomor' => $item['nomor']],
                        [
                            'nama_arab'    => $item['nama'],
                            'nama_latin'   => $item['namaLatin'],
                            'arti'         => $item['arti'],
                            'jumlah_ayat'  => $item['jumlahAyat'],
                            'tempat_turun' => $item['tempatTurun'],
                        ]
                    );
                }
            }
        }

        $surahs = Surah::orderBy('nomor')->get();

        return view('surah.index', compact('surahs'));
    }

    // Tampilkan detail surah + ayat-ayatnya
    public function show($nomor)
    {
        $surah = Surah::where('nomor', $nomor)->first();

        // Kalau surah belum ada di database, ambil dari API
        if (!$surah) {
            $response = Http::withoutVerifying()
                ->get("https://equran.id/api/v2/surat/{$nomor}");

            if (!$response->successful()) {
                abort(404, 'Surah tidak ditemukan.');
            }

            $item = $response->json('data');

            $surah = Surah::updateOrCreate(
                ['nomor' => $item['nomor']],
                [
                    'nama_arab'    => $item['nama'],
                    'nama_latin'   => $item['namaLatin'],
                    'arti'         => $item['arti'],
                    'jumlah_ayat'  => $item['jumlahAyat'],
                    'tempat_turun' => $item['tempatTurun'],
                ]
            );
        }

        // Cek apakah ayat surah ini sudah ada di database
        if ($surah->ayats()->count() === 0) {
            $response = Http::withoutVerifying()
                ->get("https://equran.id/api/v2/surat/{$nomor}");

            if ($response->successful()) {
                foreach ($response->json('data.ayat') as $ayat) {
                    \App\Models\Ayat::updateOrCreate(
                        [
                            'surah_id'   => $surah->id,
                            'nomor_ayat' => $ayat['nomorAyat'],
                        ],
                        [
                            'arab'  => $ayat['teksArab'],
                            'latin' => $ayat['teksLatin'],
                            'arti'  => $ayat['teksIndonesia'],
                        ]
                    );
                }
            }
        }

        $ayats = $surah->ayats()->orderBy('nomor_ayat')->get();

        return view('surah.show', compact('surah', 'ayats'));
    }
}