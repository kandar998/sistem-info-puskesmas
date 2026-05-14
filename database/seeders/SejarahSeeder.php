<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sejarah;

class SejarahSeeder extends Seeder
{
    public function run(): void
    {
        Sejarah::create([
            'konten' => 'Puskesmas Katoi didirikan pada tahun 1985 sebagai salah satu upaya pemerintah dalam meningkatkan pelayanan kesehatan masyarakat di wilayah Kecamatan Katoi. Berawal dari sebuah puskesmas pembantu, seiring dengan perkembangan waktu dan kebutuhan masyarakat, pada tahun 1995 ditingkatkan menjadi Puskesmas Rawat Inap. Hingga saat ini, Puskesmas Katoi terus berkomitmen untuk memberikan pelayanan kesehatan yang terbaik bagi masyarakat.'
        ]);
    }
}
