<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuranController extends Controller
{
    // Halaman Utama Daftar Surah
    public function index()
    {
        $response = Http::get('https://equran.id/api/v2/surat');

        $surah = $response->json()['data'];

        return view('quran.index', compact('surah'));
    }

    // Mengganti nama fungsi jadi 'show' agar pas dengan route dan view show.blade.php kita
    public function show($nomor)
    {
        $response = Http::get("https://equran.id/api/v2/surat/$nomor");

        // Variabel diganti jadi $detailSurat agar pas dengan file show.blade.php
        $detailSurat = $response->json()['data'];

        return view('quran.show', compact('detailSurat'));
    }
}