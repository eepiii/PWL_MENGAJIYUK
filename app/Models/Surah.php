<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surah extends Model
{
    protected $fillable = [
        'nomor_surah',
        'nama_arab',
        'nama_latin',
        'arti',
        'jumlah_ayat',
        'jenis',
    ];

    public function ayats()
    {
        return $this->hasMany(Ayat::class);
    }

    public function hafalanSetorans()
    {
        return $this->hasMany(HafalanSetoran::class);
    }
}