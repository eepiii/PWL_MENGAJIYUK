<?php

namespace App\Http\Controllers;

use App\Models\HafalanSetoran;
use App\Models\Surah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HafalanSetoranController extends Controller
{
    // Menampilkan riwayat setoran milik santri yang sedang login
    public function index()
    {
        $setorans = HafalanSetoran::with('surah', 'nilai')
            ->where('santri_id', Auth::id())
            ->latest()
            ->get();

        return view('setoran.index', compact('setorans'));
    }

    // Menampilkan halaman form tambah setoran hafalan
    public function create()
    {
        $surahs = Surah::orderBy('nomor_surah', 'asc')->get();
        return view('setoran.create', compact('surahs'));
    }

    // Menyimpan data setoran baru dari form ke database
    public function store(Request $request)
    {
        $request->validate([
            'surah_id' => 'required|exists:surahs,id',
            'ayat_mulai' => 'required|integer|min:1',
            'ayat_selesai' => 'required|integer|gte:ayat_mulai',
            'catatan_santri' => 'nullable|string',
        ]);

        HafalanSetoran::create([
            'santri_id' => Auth::id(),
            'surah_id' => $request->surah_id,
            'ayat_mulai' => $request->ayat_mulai,
            'ayat_selesai' => $request->ayat_selesai,
            'status' => 'pending', // Otomatis berstatus pending sebelum dinilai guru
            'catatan_santri' => $request->catatan_santri,
            'disetor_at' => now(),
        ]);

        return redirect()->route('setoran.index')->with('success', 'Hafalan berhasil disetorkan! Menunggu penilaian guru.');
    }
}