<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            VisiMisiSeeder::class,
            ProfilSeeder::class,
            SettingSeeder::class,
            JadwalPemeriksaanSeeder::class, // Tambahkan ini
        ]);
    }
}
