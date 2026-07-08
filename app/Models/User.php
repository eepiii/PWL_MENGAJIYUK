<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // =====================
    // Helper Role
    // =====================

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    public function isSantri(): bool
    {
        return $this->role === 'santri';
    }

    // =====================
    // Relasi
    // =====================

    public function setoranHafalan()
    {
        return $this->hasMany(HafalanSetoran::class, 'santri_id');
    }

    public function nilaiYangDiberikan()
    {
        return $this->hasMany(NilaiHafalan::class, 'guru_id');
    }

    public function nilaiHafalan()
    {
        return $this->hasMany(NilaiHafalan::class, 'santri_id');
    }

    public function jurnalIbadah()
    {
        return $this->hasMany(JurnalIbadah::class, 'santri_id');
    }
}