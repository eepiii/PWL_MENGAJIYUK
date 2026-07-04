<?php

namespace App\Http\Controllers;

use App\Models\HafalanSetoran;
use App\Models\NilaiHafalan;
use App\Models\Surah;
use Illuminate\Http\Request;

class HafalanSetoranController extends Controller
{
    /**
     * Riwayat setoran.
     * - Guru: melihat riwayat SEMUA santri (untuk keperluan penilaian & pemantauan).
     * - Santri: hanya melihat riwayat miliknya sendiri.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('guru')) {
            $setorans = HafalanSetoran::with(['santri', 'surah', 'nilai'])
                ->latest()
                ->paginate(10);
        } else {
            $setorans = HafalanSetoran::with(['surah', 'nilai'])
                ->where('santri_id', $user->id)
                ->latest()
                ->paginate(10);
        }

        return view('setoran.index', compact('setorans'));
    }

    /**
     * Detail satu setoran.
     * Santri hanya boleh melihat setoran miliknya sendiri.
     */
    public function show(HafalanSetoran $setoran)
    {
        $user = auth()->user();

        if ($user->hasRole('santri') && $setoran->santri_id !== $user->id) {
            abort(403, 'Anda tidak berhak melihat setoran ini.');
        }

        $setoran->load(['surah', 'santri', 'nilai.guru']);

        return view('setoran.show', compact('setoran'));
    }

    /**
     * Form setor hafalan baru. Khusus santri (dijaga middleware role:santri di routes).
     */
    public function create()
    {
        $surahs = Surah::orderBy('nomor_surah')->get();

        return view('setoran.create', compact('surahs'));
    }

    /**
     * Simpan setoran baru. Khusus santri.
     * Guru TIDAK PERNAH bisa mencapai method ini karena:
     * 1. Route ini berada di dalam middleware group role:santri.
     * 2. Sebagai lapis kedua, kita cek ulang role di sini.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasRole('santri')) {
            abort(403, 'Hanya santri yang bisa menyetor hafalan.');
        }

        $validated = $request->validate([
            'surah_id'     => ['required', 'exists:surahs,id'],
            'ayat_mulai'   => ['required', 'integer', 'min:1'],
            'ayat_selesai' => ['required', 'integer', 'gte:ayat_mulai'],
            'catatan'      => ['nullable', 'string', 'max:1000'],
            'audio'        => ['required', 'file', 'max:20480'], // maks 20MB
        ]);

        $path = $request->file('audio')->store('setoran_audio', 'public');

        HafalanSetoran::create([
            'santri_id'    => auth()->id(),
            'surah_id'     => $validated['surah_id'],
            'ayat_mulai'   => $validated['ayat_mulai'],
            'ayat_selesai' => $validated['ayat_selesai'],
            'audio_path'   => $path,
            'catatan'      => $validated['catatan'] ?? null,
            'status'       => 'menunggu',
        ]);

        return redirect()->route('setoran.index')
            ->with('success', 'Setoran hafalan berhasil dikirim. Tunggu penilaian dari guru.');
    }

    /**
     * Halaman progress/chart untuk santri.
     */
    public function progress()
    {
        $santriId = auth()->id();

        // Jumlah setoran per bulan
        $setoranPerBulan = HafalanSetoran::where('santri_id', $santriId)
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as bulan, COUNT(*) as jumlah")
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Riwayat nilai setiap kali dinilai (untuk grafik perkembangan nilai)
        $nilaiHistory = NilaiHafalan::whereHas('setoran', function ($q) use ($santriId) {
                $q->where('santri_id', $santriId);
            })
            ->with('setoran.surah')
            ->orderBy('created_at')
            ->get()
            ->map(function ($n) {
                return [
                    'tanggal'     => $n->created_at->format('d M Y'),
                    'surah'       => $n->setoran->surah->nama_latin ?? '-',
                    'kelancaran'  => $n->kelancaran,
                    'tajwid'      => $n->tajwid,
                    'makhraj'     => $n->makhraj,
                    'nilai_total' => $n->nilai_total,
                ];
            });

        return view('setoran.progress', compact('setoranPerBulan', 'nilaiHistory'));
    }
}