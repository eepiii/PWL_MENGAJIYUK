<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        Permission::firstOrCreate(['name' => 'view dashboard']);
        Permission::firstOrCreate(['name' => 'read quran']);
        Permission::firstOrCreate(['name' => 'create setoran']);
        Permission::firstOrCreate(['name' => 'view setoran']);
        Permission::firstOrCreate(['name' => 'grade setoran']);

        $guruRole = Role::firstOrCreate(['name' => 'guru']);
        $guruRole->givePermissionTo(['view dashboard', 'read quran', 'view setoran', 'grade setoran']);

        $santriRole = Role::firstOrCreate(['name' => 'santri']);
        $santriRole->givePermissionTo(['view dashboard', 'read quran', 'view setoran', 'create setoran']);

        $guru = User::firstOrCreate(
            ['email' => 'guru@mengajiyuk.com'],
            ['name' => 'Ustadz Ahmad', 'password' => Hash::make('password123')]
        );
        $guru->assignRole($guruRole);

        $santri = User::firstOrCreate(
            ['email' => 'santri@mengajiyuk.com'],
            ['name' => 'Santri Ali', 'password' => Hash::make('password123')]
        );
        $santri->assignRole($santriRole);
    }
}