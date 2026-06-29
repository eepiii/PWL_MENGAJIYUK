<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ayat extends Model
{
       protected $table = 'ayats';

    protected $fillable = [
        'surah_id',
        'nomor_ayat',
        'teks_arab',
        'teks_latin',
        'terjemahan',
        'audio_url',
    ];

    protected $casts = [
        'nomor_ayat' => 'integer',
        'surah_id'   => 'integer',
    ];

    public function surah()
    {
        return $this->belongsTo(Surah::class, 'surah_id');
    }

    public function scopeRangeAyat($query, $surahId, $mulai, $selesai)
    {
        return $query->where('surah_id', $surahId)
                     ->whereBetween('nomor_ayat', [$mulai, $selesai]);
    }
}
