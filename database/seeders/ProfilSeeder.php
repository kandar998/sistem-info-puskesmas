<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profil;

class ProfilSeeder extends Seeder
{
    public function run(): void
    {
        Profil::create([
            'nama_puskesmas' => 'PUSKESMAS KATOI',
            'alamat' => 'Jl. Kesehatan No. 123, Kec. Katoi, Kab. Kolaka Utara',
            'telepon' => '(0405) 123456',
            'email' => 'info@puskesmaskatoi.com',
            'deskripsi' => 'Puskesmas Katoi adalah unit pelaksana teknis dinas kesehatan kabupaten yang bertanggung jawab menyelenggarakan pembangunan kesehatan di wilayah Kecamatan Katoi.'
        ]);
    }
}
