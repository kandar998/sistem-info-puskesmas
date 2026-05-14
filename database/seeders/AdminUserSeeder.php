<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat atau dapatkan role
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Buat permissions
        $permissions = [
            'manage berita',
            'manage visi misi',
            'manage struktur',
            'manage galeri',
            'manage sejarah',
            'manage profil',
            'manage jadwal posyandu',
            'manage jadwal pemeriksaan',
            'manage pelayanan',
            'manage setting'
        ];

        foreach ($permissions as $permission) {
            $perm = Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
            $adminRole->givePermissionTo($perm);
        }

        // Buat atau update admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@puskesmaskatoi.com'],
            [
                'name' => 'Admin Puskesmas',
                'password' => bcrypt('password'),
                'email_verified_at' => now()
            ]
        );
        $admin->assignRole('admin');

        // Buat atau update user biasa
        $user = User::updateOrCreate(
            ['email' => 'user@puskesmaskatoi.com'],
            [
                'name' => 'User Biasa',
                'password' => bcrypt('password'),
                'email_verified_at' => now()
            ]
        );
        $user->assignRole('user');
    }
}
