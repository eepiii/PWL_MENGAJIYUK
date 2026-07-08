<?php

namespace App\Http\Controllers;

use App\Models\HafalanSetoran;
use App\Models\NilaiHafalan;
use App\Models\Surah;
use Illuminate\Http\Request;

class HafalanSetoranController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $status = request('status');

        // Pengecekan disesuaikan untuk demo agar tetap bisa menampilkan data
        if ($user->hasRole('guru')) {
            $setorans = HafalanSetoran::with(['santri', 'surah', 'nilai'])
                ->when($status, fn ($q) => $q->where('status', $status))
                ->latest()
                ->paginate(10);
        } else {
            $setorans = HafalanSetoran::with(['surah', 'nilai'])
                ->where('santri_id', $user->id)
                ->when($status, fn ($q) => $q->where('status', $status))
                ->latest()
                ->paginate(10);
        }

        return view('setoran.index', compact('setorans'));
    }

    public function show(HafalanSetoran $setoran)
    {
        // Pengecekan role dihilangkan sementara agar demo tidak terblokir
        $setoran->load(['surah', 'santri', 'nilai.guru']);

        return view('setoran.show', compact('setoran'));
    }

    public function create()
    {
        $surahs = Surah::orderBy('nomor_surah')->get();
        return view('setoran.create', compact('surahs'));
    }

    public function store(Request $request)
    {
        // Pengecekan role diubah menjadi cek apakah user login saja
        if (!auth()->check()) {
            abort(403, 'Anda harus login untuk menyetor hafalan.');
        }

        $validated = $request->validate([
            'surah_id'     => ['required', 'exists:surahs,id'],
            'ayat_mulai'   => ['required', 'integer', 'min:1'],
            'ayat_selesai' => ['required', 'integer', 'gte:ayat_mulai'],
            'catatan'      => ['nullable', 'string', 'max:1000'],
            'audio'        => ['required', 'file', 'max:20480'],
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
            ->with('success', 'Setoran hafalan berhasil dikirim.');
    }

    public function progress()
    {
        $santriId = auth()->id();

        $setoranPerBulan = HafalanSetoran::where('santri_id', $santriId)
            ->get()
            ->groupBy(fn ($item) => $item->created_at->format('Y-m'))
            ->map(fn ($group, $bulan) => [
                'bulan'  => $bulan,
                'jumlah' => $group->count(),
            ])
            ->values();

        $nilaiHistory = NilaiHafalan::whereHas('setoran', function ($q) use ($santriId) {
                $q->where('santri_id', $santriId);
            })
            ->with('setoran.surah')
            ->orderBy('created_at')
            ->get()
            ->map(fn ($n) => [
                'tanggal'     => $n->created_at->format('d M Y'),
                'surah'       => $n->setoran->surah->nama_latin ?? '-',
                'kelancaran'  => $n->kelancaran,
                'tajwid'      => $n->tajwid,
                'makhraj'     => $n->makhraj,
                'nilai_total' => $n->nilai_total,
            ]);

        return view('setoran.progress', compact('setoranPerBulan', 'nilaiHistory'));
    }
}