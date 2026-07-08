<?php

namespace App\Http\Controllers;

use App\Models\HafalanSetoran;
use App\Models\NilaiHafalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiHafalanController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()->role === 'guru', 403);

        $setorans = HafalanSetoran::with('santri')
            ->where('status', 'belum_dinilai')
            ->latest()
            ->paginate(10);

        return view('penilaian.index', compact('setorans'));
    }

    public function create(HafalanSetoran $setoran)
    {
        abort_unless(Auth::user()->role === 'guru', 403);

        if ($setoran->status === 'sudah_dinilai') {
            return redirect()->route('setoran.show', $setoran->id)
                ->with('info', 'Setoran ini sudah dinilai sebelumnya.');
        }

        return view('penilaian.create', compact('setoran'));
    }

    public function store(Request $request, HafalanSetoran $setoran)
    {
        abort_unless(Auth::user()->role === 'guru', 403);

        if ($setoran->status === 'sudah_dinilai') {
            return redirect()->route('setoran.show', $setoran->id)
                ->with('info', 'Setoran ini sudah dinilai sebelumnya.');
        }

        $validated = $request->validate([
            'kelancaran' => ['required', 'integer', 'min:0', 'max:100'],
            'tajwid'     => ['required', 'integer', 'min:0', 'max:100'],
            'makhraj'    => ['required', 'integer', 'min:0', 'max:100'],
            'catatan'    => ['nullable', 'string', 'max:1000'],
        ]);

        $nilaiTotal = (int) round(
            ($validated['kelancaran'] + $validated['tajwid'] + $validated['makhraj']) / 3
        );

        NilaiHafalan::create([
            'hafalan_setoran_id' => $setoran->id,
            'guru_id'            => Auth::id(),
            'kelancaran'         => $validated['kelancaran'],
            'tajwid'             => $validated['tajwid'],
            'makhraj'            => $validated['makhraj'],
            'nilai_total'        => $nilaiTotal,
            'catatan'            => $validated['catatan'] ?? null,
        ]);

        $setoran->update(['status' => 'sudah_dinilai']);

        return redirect()->route('setoran.index')
            ->with('success', 'Penilaian berhasil disimpan.');
    }

    public function progress()
    {
        abort_unless(Auth::user()->role === 'santri', 403);

        $data = HafalanSetoran::where('santri_id', Auth::id())
            ->with('nilaiHafalan')
            ->whereHas('nilaiHafalan')
            ->orderBy('tanggal_setoran')
            ->get()
            ->map(function ($setoran) {
                return [
                    'tanggal' => $setoran->tanggal_setoran
                        ? $setoran->tanggal_setoran->format('d M')
                        : $setoran->created_at->format('d M'),
                    'surah'   => $setoran->surah,
                    'nilai'   => $setoran->nilaiHafalan->nilai_total,
                ];
            });

        return view('setoran.progress', compact('data'));
    }
}