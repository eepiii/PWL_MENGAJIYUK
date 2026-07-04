<?php

namespace App\Http\Controllers;

use App\Models\HafalanSetoran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HafalanSetoranController extends Controller
{
    public function create()
    {
        if (Auth::user()->role !== 'santri') {
            abort(403, 'Maaf, hanya santri yang bisa menyetor hafalan.');
        }

        return view('setoran.create');
    }

    public function index()
    {
        if (Auth::user()->role === 'guru') {
            $setorans = HafalanSetoran::with('santri')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $setorans = HafalanSetoran::where('santri_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('setoran.index', compact('setorans'));
    }

    public function store(Request $request)
    {
        abort_unless(Auth::user()->role === 'santri', 403);

        $validated = $request->validate([
            'surah'        => 'required|string|max:255',
            'ayat_mulai'   => 'nullable|integer|min:1',
            'ayat_selesai' => 'nullable|integer|gte:ayat_mulai',
            'audio'        => [
                'nullable',
                'file',
                'max:20480',
                'mimetypes:audio/webm,audio/mpeg,audio/mp3,audio/wav,audio/x-wav,audio/ogg',
            ],
            'catatan' => 'nullable|string',
        ]);

        $path = null;
        if ($request->hasFile('audio')) {
            $path = $request->file('audio')->store('rekaman_hafalan', 'public');
        }

        $setoran = HafalanSetoran::create([
            'santri_id'       => Auth::id(),
            'surah'           => $validated['surah'],
            'ayat_mulai'      => $validated['ayat_mulai'] ?? null,
            'ayat_selesai'    => $validated['ayat_selesai'] ?? null,
            'audio_path'      => $path,
            'catatan'         => $validated['catatan'] ?? null,
            'tanggal_setoran' => now(),
            'status'          => 'belum_dinilai', // ✅ konsisten
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Setoran berhasil dikirim.',
                'data'    => $setoran,
            ]);
        }

        return redirect()->route('setoran.index')
            ->with('success', 'Setoran berhasil dikirim.');
    }

    public function show(HafalanSetoran $setoran)
    {
        $user = Auth::user();

        if ($user->role === 'santri' && $setoran->santri_id !== $user->id) {
            abort(403);
        }

        $setoran->load('nilaiHafalan');

        return view('setoran.show', compact('setoran'));
    }
}