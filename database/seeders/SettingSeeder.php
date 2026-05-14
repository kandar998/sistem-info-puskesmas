<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'footer_statistic', 'value' => json_encode([
                'total_pasien' => 15234,
                'total_dokter' => 12,
                'total_kunjungan_hari' => 45,
                'total_posyandu' => 8
            ])],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
