<?php

namespace App\Http\Controllers;

use App\Models\HafalanSetoran;
use App\Models\NilaiHafalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiHafalanController extends Controller
{
    // Menampilkan semua setoran santri yang masuk dan butuh nilai
    public function index()
    {
        $setorans = HafalanSetoran::with('santri', 'surah')
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('penilaian.index', compact('setorans'));
    }

    // Menyimpan penilaian yang diberikan oleh guru
    public function store(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|integer|between:0,100',
            'kategori' => 'required|in:lancar,cukup,perlu_ulang',
            'catatan_guru' => 'nullable|string',
        ]);

        $setoran = HafalanSetoran::findOrFail($id);

        // 1. Simpan data ke tabel nilai_hafalans
        NilaiHafalan::create([
            'setoran_id' => $setoran->id,
            'guru_id' => Auth::id(),
            'santri_id' => $setoran->santri_id,
            'nilai' => $request->nilai,
            'kategori' => $request->kategori,
            'catatan_guru' => $request->catatan_guru,
            'dinilai_at' => now(),
        ]);

        // 2. Ubah status di tabel hafalan_setorans menjadi 'dinilai'
        $setoran->update([
            'status' => 'dinilai'
        ]);

        return redirect()->route('penilaian.index')->with('success', 'Penilaian hafalan berhasil disimpan!');
    }
}