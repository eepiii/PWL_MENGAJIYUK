<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class QuranController extends Controller
{
    public function index()
    {
        $response = Http::get('https://equran.id/api/v2/surat');

        $surah = [];
        if ($response->successful()) {
            $surah = $response->json('data'); // tetap array, tidak perlu di-decode ulang
        }

        return view('quran.index', compact('surah'));
    }

    // 2. Menampilkan Detail Surah
    public function show($nomor)
    {
        $response = Http::get("https://equran.id/api/v2/surat/{$nomor}");

        if (!$response->successful()) {
            abort(404, 'Surah tidak ditemukan');
        }

        $detailSurat = $response->json('data'); // nama variabel disamakan dengan view

        return view('quran.show', compact('detailSurat'));
    }
}