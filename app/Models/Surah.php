<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surah extends Model
{
    protected $table = 'surahs';
    protected $primaryKey = 'id';
    public $incrementing = false; 

    protected $fillable = [
        'id',
        'nomor_surah',
        'nama_arab',
        'nama_latin',
        'arti',
        'jumlah_ayat',
        'jenis',
    ];

    protected $casts = [
        'jumlah_ayat' => 'integer',
    ];

    public function ayat()
    {
        return $this->hasMany(Ayat::class, 'surah_id');
    }

    public function setoranHafalan()
    {
        return $this->hasMany(HafalanSetoran::class, 'surah_id');
    }

    public function scopeMakkiyah($query)
    {
        return $query->where('jenis', 'makkiyah');
    }

    public function scopeMadaniyah($query)
    {
        return $query->where('jenis', 'madaniyah');
    }
}

