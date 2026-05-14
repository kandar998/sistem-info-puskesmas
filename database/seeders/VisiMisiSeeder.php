<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VisiMisi;

class VisiMisiSeeder extends Seeder
{
    public function run(): void
    {
        VisiMisi::create([
            'visi' => 'Menjadi Puskesmas Terdepan dalam Pelayanan Kesehatan Masyarakat yang Profesional dan Bermutu',
            'misi' => "1. Meningkatkan mutu pelayanan kesehatan yang paripurna dan terjangkau\n2. Meningkatkan profesionalisme sumber daya manusia\n3. Meningkatkan peran serta masyarakat dalam pembangunan kesehatan\n4. Mengembangkan sistem informasi kesehatan yang terintegrasi"
        ]);
    }
}
