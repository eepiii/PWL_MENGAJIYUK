<?php

namespace App\Http\Controllers;

use App\Models\Ayat;
use App\Models\Surah;
use Illuminate\Http\Request;

class AyatController extends Controller
{
    // Tampilkan ayat-ayat dari surah tertentu
    public function index($surahNomor)
    {
        $surah = Surah::where('nomor', $surahNomor)->firstOrFail();
        $ayats = $surah->ayats()->orderBy('nomor_ayat')->get();

        return view('ayat.index', compact('surah', 'ayats'));
    }

    // Tampilkan detail 1 ayat
    public function show($surahNomor, $nomorAyat)
    {
        $surah = Surah::where('nomor', $surahNomor)->firstOrFail();

        $ayat = Ayat::where('surah_id', $surah->id)
            ->where('nomor_ayat', $nomorAyat)
            ->firstOrFail();

        return view('ayat.show', compact('surah', 'ayat'));
    }
}