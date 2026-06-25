<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HafalanSetoran extends Model
{
    protected $table = 'hafalan_setorans';

    protected $fillable = [
        'santri_id',
        'surah_id',
        'ayat_mulai',
        'ayat_selesai',
        'status',
        'catatan_santri',
        'disetor_at',
    ];

    protected $casts = [
        'disetor_at'   => 'datetime',
        'ayat_mulai'   => 'integer',
        'ayat_selesai' => 'integer',
    ];


    public function santri()
    {
        return $this->belongsTo(User::class, 'santri_id');
    }

    public function surah()
    {
        return $this->belongsTo(Surah::class, 'surah_id');
    }

    public function nilai()
    {
        return $this->hasOne(NilaiHafalan::class, 'setoran_id');
    }


    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDinilai($query)
    {
        return $query->where('status', 'dinilai');
    }

    public function scopeMilikSantri($query, $santriId)
    {
        return $query->where('santri_id', $santriId);
    }

    public function jumlahAyat(): int
    {
        return ($this->ayat_selesai - $this->ayat_mulai) + 1;
    }

    public function sudahDinilai(): bool
    {
        return $this->status === 'dinilai';
    }
}
