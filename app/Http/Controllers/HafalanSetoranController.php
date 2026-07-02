<?php

namespace App\Http\Controllers;

use App\Models\HafalanSetoran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
}