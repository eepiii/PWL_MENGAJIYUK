<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HafalanSetoran extends Model
{
    use HasFactory;

    protected $fillable = [
        'santri_id',
        'surah_id',
        'ayat_mulai',
        'ayat_selesai',
        'audio_path',
        'catatan',
        'status',
    ];

    // "santri" adalah role dari User, BUKAN model terpisah.
    // Jangan pernah belongsTo(Santri::class) - model itu tidak ada.
    public function santri()
    {
        return $this->belongsTo(User::class, 'santri_id');
    }

    public function surah()
    {
        return $this->belongsTo(Surah::class);
    }

    public function nilai()
    {
        return $this->hasOne(NilaiHafalan::class, 'hafalan_setoran_id');
    }

    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }
}