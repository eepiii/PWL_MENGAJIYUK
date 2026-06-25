<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuranController extends Controller
{
    public function index()
    {
        $response = Http::get('https://equran.id/api/v2/surat');

        $surah = $response->json()['data'];

        return view('quran.index', compact('surah'));
    }

    public function detail($nomor)
    {
        $response = Http::get("https://equran.id/api/v2/surat/$nomor");

        $surah = $response->json()['data'];

        return view('quran.detail', compact('surah'));
    }
}