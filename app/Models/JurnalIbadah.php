<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalIbadah extends Model
{
    protected $table = 'jurnal_ibadahs';

    protected $fillable = [
        'santri_id',
        'tanggal',
        'shalat_subuh',
        'shalat_dzuhur',
        'shalat_ashar',
        'shalat_maghrib',
        'shalat_isya',
        'puasa_sunnah',
        'tilawah_halaman',
        'catatan',
    ];

    protected $casts = [
        'tanggal'         => 'date',
        'puasa_sunnah'    => 'boolean',
        'tilawah_halaman' => 'integer',
    ];


    const SHALAT_TIDAK    = 0;
    const SHALAT_TEPAT    = 1;
    const SHALAT_QADHA    = 2;


    public function santri()
    {
        return $this->belongsTo(User::class, 'santri_id');
    }

    public function scopeBySantri($query, $santriId)
    {
        return $query->where('santri_id', $santriId);
    }

    public function scopeBulanIni($query)
    {
        return $query->whereMonth('tanggal', now()->month)
                     ->whereYear('tanggal', now()->year);
    }

    public function scopeTanggal($query, $tanggal)
    {
        return $query->whereDate('tanggal', $tanggal);
    }

    public function totalShalat(): int
    {
        return collect([
            $this->shalat_subuh,
            $this->shalat_dzuhur,
            $this->shalat_ashar,
            $this->shalat_maghrib,
            $this->shalat_isya,
        ])->filter(fn($v) => $v > 0)->count();
    }
    
    public function persentaseShalat(): int
    {
        return (int) ($this->totalShalat() / 5 * 100);
    }

    public function labelShalat($nilai): string
    {
        return match((int) $nilai) {
            1       => 'Tepat Waktu',
            2       => 'Qadha',
            default => 'Tidak Shalat',
        };
    }
}
