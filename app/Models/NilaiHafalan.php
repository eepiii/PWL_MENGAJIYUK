<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiHafalan extends Model
{
    protected $table = 'nilai_hafalans';

    // Kolom ini WAJIB sama persis dengan migration create_nilai_hafalans_table:
    // hafalan_setoran_id, guru_id, kelancaran, tajwid, makhraj, nilai_total, catatan
    protected $fillable = [
        'hafalan_setoran_id',
        'guru_id',
        'kelancaran',
        'tajwid',
        'makhraj',
        'nilai_total',
        'catatan',
    ];

    protected $casts = [
        'kelancaran'  => 'integer',
        'tajwid'      => 'integer',
        'makhraj'     => 'integer',
        'nilai_total' => 'integer',
    ];

    public function setoran()
    {
        return $this->belongsTo(HafalanSetoran::class, 'hafalan_setoran_id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}