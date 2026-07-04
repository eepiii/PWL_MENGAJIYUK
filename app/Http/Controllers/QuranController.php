<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuranController extends Controller
{
    public function index()
    {
        $response = Http::withoutVerifying()->get('https://equran.id/api/v2/surat');

        $surah = [];
        if ($response->successful()) {
            $surah = json_decode(json_encode($response->json('data')));
        }

        return view('quran.index', compact('surah'));
    }

    public function show($nomor)
    {
        $response = Http::withoutVerifying()->get("https://equran.id/api/v2/surat/{$nomor}");

        if (!$response->successful()) {
            abort(404, 'Surah tidak ditemukan');
        }

        $detailSurat = json_decode(json_encode($response->json('data')));

        return view('quran.show', compact('detailSurat'));
    }
}