<?php

namespace App\Http\Controllers;

use App\Models\HafalanSetoran;
use App\Models\NilaiHafalan;
use App\Models\Surah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HafalanSetoranController extends Controller
{
    public function create()
    {
        // Cegah guru masuk ke halaman form setoran
        if (Auth::user()->role !== 'santri') {
            abort(403, 'Maaf, hanya santri yang bisa menyetor hafalan.');
        }

        return view('setoran.create');
    }

    public function index()
    {
        // Jika yang login adalah GURU, tampilkan SEMUA setoran dari semua santri
        if (Auth::user()->role === 'guru') {
            $setorans = HafalanSetoran::with('santri') // 'santri' adalah relasi ke tabel User
                ->orderBy('created_at', 'desc')
                ->get();
        } 
        // Jika yang login adalah SANTRI, tampilkan hanya riwayat setorannya sendiri
        else {
            $setorans = HafalanSetoran::where('santri_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('setoran.index', compact('setorans'));
    }

    public function store(Request $request)
    {
        // Double safety, walau sudah dibatasi middleware role
        abort_unless(Auth::user()->role === 'santri', 403);

        // Menggabungkan validasi untuk input teks dan file audio
        $validated = $request->validate([
            'surah'        => 'required|string|max:255',
            'ayat_mulai'   => 'nullable|integer|min:1',
            'ayat_selesai' => 'nullable|integer|gte:ayat_mulai',
            'audio'        => [
                'nullable', // Dibuat nullable agar form tanpa audio tetap bisa jalan, ubah ke 'required' jika wajib
                'file',
                'max:20480', // 20MB
                'mimetypes:audio/webm,audio/mpeg,audio/mp3,audio/wav,audio/x-wav,audio/ogg',
            ],
            'catatan'      => 'nullable|string',
        ]);

        // Cek dan simpan file audio jika ada
        $path = null;
        if ($request->hasFile('audio')) {
            $path = $request->file('audio')->store('rekaman_hafalan', 'public');
        }

        // Simpan data setoran ke database
        $setoran = HafalanSetoran::create([
            'santri_id'       => Auth::id(),
            'surah'           => $validated['surah'],
            'ayat_mulai'      => $validated['ayat_mulai'] ?? null,
            'ayat_selesai'    => $validated['ayat_selesai'] ?? null,
            'audio_path'      => $path,
            'catatan'         => $validated['catatan'] ?? null,
            'tanggal_setoran' => now(),
            'status'          => 'belum_dinilai',
        ]);

        // Jika request dikirim via API / AJAX (mengharapkan JSON)
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Setoran berhasil dikirim.',
                'data'    => $setoran,
            ]);
        }

        // Jika request dikirim via Form HTML biasa
        return redirect()->route('setoran.index')->with('success', 'Setoran berhasil dikirim.');
    }

    public function show(HafalanSetoran $setoran)
    {
        $user = Auth::user();

        // Santri hanya boleh lihat setorannya sendiri
        if ($user->role === 'santri' && $setoran->santri_id !== $user->id) {
            abort(403);
        }

        $setoran->load('nilaiHafalan'); // relasi ke nilai

        return view('setoran.show', compact('setoran'));
    }
}