<?php

namespace App\Http\Controllers;

use App\Models\HafalanSetoran;
use App\Models\NilaiHafalan;
use Illuminate\Http\Request;

class NilaiHafalanController extends Controller
{
    public function index()
    {
        $setorans = HafalanSetoran::with(['santri', 'surah'])
            ->menunggu()
            ->latest()
            ->paginate(10);

        return view('penilaian.index', compact('setorans'));
    }

    public function create(HafalanSetoran $setoran)
    {
        if ($setoran->status === 'dinilai') {
            return redirect()->route('setoran.show', $setoran->id)
                ->with('info', 'Setoran ini sudah dinilai sebelumnya.');
        }

        return view('penilaian.create', compact('setoran'));
    }

    public function store(Request $request, HafalanSetoran $setoran)
    {
        if (!auth()->user()->hasRole('guru')) {
            abort(403, 'Hanya guru yang bisa menilai setoran.');
        }

        if ($setoran->status === 'dinilai') {
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
            'guru_id'            => auth()->id(),
            'kelancaran'         => $validated['kelancaran'],
            'tajwid'             => $validated['tajwid'],
            'makhraj'            => $validated['makhraj'],
            'nilai_total'        => $nilaiTotal,
            'catatan'            => $validated['catatan'] ?? null,
        ]);

        $setoran->update(['status' => 'dinilai']);

        return redirect()->route('setoran.show', $setoran->id)
            ->with('success', 'Penilaian berhasil disimpan.');
    }
}