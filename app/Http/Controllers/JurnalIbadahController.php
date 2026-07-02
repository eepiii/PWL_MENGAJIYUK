<?php

namespace App\Http\Controllers;

use App\Models\JurnalIbadah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class JurnalIbadahController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->tanggal ?? now()->toDateString();
        
        $jurnal = JurnalIbadah::where('santri_id', Auth::id())
            ->whereDate('tanggal', $tanggal)
            ->first();

        if (!$jurnal) {
            $jurnal = JurnalIbadah::create([
                'santri_id' => Auth::id(),
                'tanggal' => $tanggal,
                'shalat_subuh' => 0,
                'shalat_dzuhur' => 0,
                'shalat_ashar' => 0,
                'shalat_maghrib' => 0,
                'shalat_isya' => 0,
                'puasa_sunnah' => false,
                'tilawah_halaman' => 0,
                'catatan' => null
            ]);
        }

        $idKota = '1222'; 
        $parsedDate = Carbon::parse($tanggal);
        $tahun = $parsedDate->year;
        $bulan = str_pad($parsedDate->month, 2, '0', STR_PAD_LEFT);
        $hari = $parsedDate->format('Y-m-d');

        $jadwalShalat = null;
        
        try {
<<<<<<< Updated upstream
            $response = Http::withoutVerifying()->get("https://equran.id/api/v2/shalat/jadwal/{$idKota}/{$tahun}/{$bulan}");
            
            if ($response->successful()) {
                $data = $response->json('data.jadwal');
=======
            $response = Http::get("https://equran.id/api/v2/shalat/jadwal/{$idKota}/{$tahun}/{$bulan}");
            
            if ($response->successful()) {
                $data = $response->json('data');
>>>>>>> Stashed changes
                $jadwalShalat = collect($data)->firstWhere('date', $hari);
            }
        } catch (\Exception $e) {
            $jadwalShalat = null;
        }

        return view('jurnal.index', compact('jurnal', 'tanggal', 'jadwalShalat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'         => 'required|date',
            'shalat_subuh'    => 'required|in:0,1,2',
            'shalat_dzuhur'   => 'required|in:0,1,2',
            'shalat_ashar'    => 'required|in:0,1,2',
            'shalat_maghrib'  => 'required|in:0,1,2',
            'shalat_isya'     => 'required|in:0,1,2',
            'puasa_sunnah'    => 'boolean',
            'tilawah_halaman' => 'integer|min:0',
            'catatan'         => 'nullable|string'
        ]);

        $data = $request->except('_token', 'tanggal');
        $data['puasa_sunnah'] = $request->has('puasa_sunnah') && $request->puasa_sunnah == 1;

        $jurnal = JurnalIbadah::where('santri_id', Auth::id())
            ->whereDate('tanggal', $request->tanggal)
            ->first();

        if ($jurnal) {
            $jurnal->update($data);
        } else {
            $data['santri_id'] = Auth::id();
            $data['tanggal'] = $request->tanggal;
            JurnalIbadah::create($data);
        }

        return back()->with('success', 'Data jurnal ibadah berhasil disimpan.');
    }
}