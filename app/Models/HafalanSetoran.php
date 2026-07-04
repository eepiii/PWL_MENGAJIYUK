<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HafalanSetoran extends Model
{
    protected $fillable = [
        'santri_id',
        'surah',
        'audio_path',
        'catatan'
    ];

    public function santri()
    {
        return $this->belongsTo(User::class, 'santri_id');
    }
}