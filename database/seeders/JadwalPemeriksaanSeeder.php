<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalPemeriksaan;
use Carbon\Carbon;

class JadwalPemeriksaanSeeder extends Seeder
{
    public function run(): void
    {
        $jadwals = [
            // Poli Umum
            [
                'poli' => 'Poli Umum',
                'dokter' => 'dr. Ahmad Sulaiman',
                'hari' => 'Senin',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '12:00:00',
                'kuota' => 25,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'poli' => 'Poli Umum',
                'dokter' => 'dr. Ahmad Sulaiman',
                'hari' => 'Rabu',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '12:00:00',
                'kuota' => 25,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'poli' => 'Poli Umum',
                'dokter' => 'dr. Budi Santoso',
                'hari' => 'Jumat',
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '17:00:00',
                'kuota' => 20,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Poli Gigi
            [
                'poli' => 'Poli Gigi',
                'dokter' => 'drg. Siti Nurhaliza',
                'hari' => 'Selasa',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '14:00:00',
                'kuota' => 15,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'poli' => 'Poli Gigi',
                'dokter' => 'drg. Dewi Sartika',
                'hari' => 'Kamis',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '14:00:00',
                'kuota' => 15,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Poli KIA
            [
                'poli' => 'Poli KIA',
                'dokter' => 'dr. Maria Ulfah',
                'hari' => 'Senin',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '15:00:00',
                'kuota' => 30,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'poli' => 'Poli KIA',
                'dokter' => 'dr. Fitriani',
                'hari' => 'Rabu',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '15:00:00',
                'kuota' => 30,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'poli' => 'Poli KIA',
                'dokter' => 'dr. Maria Ulfah',
                'hari' => 'Jumat',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '12:00:00',
                'kuota' => 25,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Poli Lansia
            [
                'poli' => 'Poli Lansia',
                'dokter' => 'dr. Hadi Wijaya',
                'hari' => 'Selasa',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '12:00:00',
                'kuota' => 20,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'poli' => 'Poli Lansia',
                'dokter' => 'dr. Rini Susanti',
                'hari' => 'Kamis',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '12:00:00',
                'kuota' => 20,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Poli MTBS
            [
                'poli' => 'Poli MTBS',
                'dokter' => 'dr. Indah Permata',
                'hari' => 'Senin',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '14:00:00',
                'kuota' => 25,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'poli' => 'Poli MTBS',
                'dokter' => 'dr. Sari Dewi',
                'hari' => 'Rabu',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '14:00:00',
                'kuota' => 25,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Poli Gizi
            [
                'poli' => 'Poli Gizi',
                'dokter' => 'dr. Anita Wijaya',
                'hari' => 'Selasa',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '13:00:00',
                'kuota' => 20,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'poli' => 'Poli Gizi',
                'dokter' => 'dr. Ratna Sari',
                'hari' => 'Kamis',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '13:00:00',
                'kuota' => 20,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        foreach ($jadwals as $jadwal) {
            JadwalPemeriksaan::create($jadwal);
        }

        $this->command->info('✅ Berhasil menambahkan ' . count($jadwals) . ' jadwal pemeriksaan');
    }
}
