<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiHafalan extends Model
{
    protected $table = 'nilai_hafalans';

    protected $fillable = [
        'setoran_id',
        'guru_id',
        'santri_id',
        'nilai',
        'kategori',
        'catatan_guru',
        'dinilai_at',
    ];

    protected $casts = [
        'nilai'      => 'integer',
        'dinilai_at' => 'datetime',
    ];

    // =====================
    // Relasi
    // =====================

    // Nilai dimiliki oleh satu setoran
    public function setoran()
    {
        return $this->belongsTo(HafalanSetoran::class, 'setoran_id');
    }

    // Nilai diberikan oleh satu guru
    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    // Nilai diterima oleh satu santri
    public function santri()
    {
        return $this->belongsTo(User::class, 'santri_id');
    }

    // =====================
    // Scope
    // =====================

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeBySantri($query, $santriId)
    {
        return $query->where('santri_id', $santriId);
    }

    // =====================
    // Helper
    // =====================

    public function labelKategori(): string
    {
        return match($this->kategori) {
            'lancar'      => '✓ Lancar',
            'cukup'       => '~ Cukup',
            'perlu_ulang' => '✗ Perlu Ulang',
            default       => '-',
        };
    }

    public function warnaNilai(): string
    {
        if ($this->nilai >= 85) return 'green';
        if ($this->nilai >= 70) return 'yellow';
        return 'red';
    }
}
