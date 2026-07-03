<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuranController extends Controller
{
    // 1. Menampilkan Daftar Surah
    public function index()
    {
        $response = Http::get('https://equran.id/api/v2/surat');
        
        // Pastikan response sukses
        $surah = [];
        if ($response->successful()) {
            // Gunakan json_decode(json_encode) untuk memaksa data jadi Object
            $surah = json_decode(json_encode($response->json()['data']));
        }

        return view('quran.index', compact('surah'));
    }
    
    // 2. Menampilkan Detail Surah
    public function show($nomor)
    {
        $response = Http::get("https://equran.id/api/v2/surat/$nomor");
        
        $surah = null;
        if ($response->successful()) {
            // Memaksa data jadi Object
            $surah = json_decode(json_encode($response->json()['data']));
        } else {
            abort(404, 'Surah tidak ditemukan');
        }

        return view('quran.show', compact('surah'));
    }
}