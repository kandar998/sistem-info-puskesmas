<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Pelayanan;
use App\Models\JadwalPemeriksaan;
use App\Models\Profil;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class PelayananController extends Controller
{
    /**
     * Menampilkan form pendaftaran online
     */
    public function index()
{
    try {
        $profil = Profil::first();
        $statistic = $this->getFooterStatistics();

        // Ambil semua jadwal
        $jadwals = JadwalPemeriksaan::orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('jam_mulai')
            ->get();

        // Kelompokkan jadwal berdasarkan poli
        $jadwalPerPoli = $this->groupJadwalByPoli($jadwals);

        // DEBUG: Tulis ke log
        Log::info('========== DEBUG PELAYANAN CONTROLLER ==========');
        Log::info('Total jadwal: ' . $jadwals->count());
        Log::info('Total kelompok poli: ' . count($jadwalPerPoli));
        Log::info('Data jadwalPerPoli: ' . json_encode($jadwalPerPoli));

        return view('frontend.pelayanan', compact(
            'jadwals',
            'jadwalPerPoli',
            'profil',
            'statistic'
        ));

    } catch (Exception $e) {
        Log::error('Error di index PelayananController: ' . $e->getMessage());
        return view('frontend.pelayanan', [
            'jadwals' => collect([]),
            'jadwalPerPoli' => [],
            'profil' => Profil::first(),
            'statistic' => $this->getFooterStatistics(),
        ]);
    }
}

    /**
     * Menyimpan data pendaftaran online
     */
    public function store(Request $request)
    {
        // PERBAIKAN: Validasi yang lebih komprehensif
        $validatedData = $request->validate([
            'nama' => 'required|string|max:100|regex:/^[a-zA-Z\s]+$/',
            'nik' => [
                'required',
                'string',
                'size:16',
                'unique:pelayanans,nik',
                'regex:/^[0-9]+$/'
            ],
            'tempat_lahir' => 'required|string|max:50|regex:/^[a-zA-Z\s]+$/',
            'tanggal_lahir' => [
                'required',
                'date',
                'before:' . now()->subYears(5)->format('Y-m-d'), // Minimal 5 tahun
                'after:1900-01-01'
            ],
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string|min:10|max:500',
            'no_hp' => [
                'required',
                'string',
                'regex:/^08[0-9]{8,11}$/',
                'min:10',
                'max:13'
            ],
            'poli_tujuan' => 'required|string|max:50|exists:jadwal_pemeriksaans,poli',
            'tanggal_periksa' => [
                'required',
                'date',
                'after_or_equal:' . now()->format('Y-m-d'),
                'before_or_equal:' . now()->addDays(30)->format('Y-m-d')
            ],
            'keluhan' => 'required|string|min:10|max:1000'
        ], [
            'nama.regex' => 'Nama hanya boleh mengandung huruf dan spasi',
            'nik.size' => 'NIK harus 16 digit',
            'nik.regex' => 'NIK hanya boleh berisi angka',
            'nik.unique' => 'NIK sudah terdaftar',
            'tempat_lahir.regex' => 'Tempat lahir hanya boleh mengandung huruf dan spasi',
            'tanggal_lahir.before' => 'Pasien minimal berusia 5 tahun',
            'no_hp.regex' => 'Nomor HP harus diawali 08 dan berisi 10-13 digit',
            'no_hp.min' => 'Nomor HP minimal 10 digit',
            'poli_tujuan.exists' => 'Poli tujuan tidak valid',
            'keluhan.min' => 'Keluhan minimal 10 karakter',
            'tanggal_periksa.after_or_equal' => 'Tanggal periksa tidak boleh sebelum hari ini',
            'tanggal_periksa.before_or_equal' => 'Tanggal periksa maksimal H+30'
        ]);

        // PERBAIKAN: Gunakan DB transaction untuk keamanan data
        return DB::transaction(function () use ($validatedData, $request) {
            try {
                // PERBAIKAN: Konversi hari dengan validasi
                $tanggalPeriksa = Carbon::parse($request->tanggal_periksa);
                $hariPeriksa = $this->getHariIndonesia($tanggalPeriksa);

                // Log untuk debugging
                Log::info('Pendaftaran - Data: ' . json_encode([
                    'poli' => $request->poli_tujuan,
                    'tanggal' => $request->tanggal_periksa,
                    'hari' => $hariPeriksa,
                    'nik' => substr($request->nik, 0, 6) . '*****' // Log sebagian NIK untuk privasi
                ]));

                // PERBAIKAN: Cek jadwal dengan query yang lebih robust
                $jadwal = JadwalPemeriksaan::where('poli', $request->poli_tujuan)
                    ->where(function($query) use ($hariPeriksa) {
                        $query->where('hari', $hariPeriksa)
                              ->orWhereRaw('LOWER(hari) = ?', [strtolower($hariPeriksa)]);
                    })
                    ->first();

                if (!$jadwal) {
                    $jadwalTersedia = $this->getJadwalTersedia($request->poli_tujuan);
                    throw new Exception('Poli ' . $request->poli_tujuan . ' tidak beroperasi pada hari ' . $hariPeriksa .
                        ($jadwalTersedia ? '. Jadwal tersedia: ' . $jadwalTersedia : ''));
                }

                // PERBAIKAN: Lock table untuk mencegah race condition
                $terdaftar = Pelayanan::where('poli_tujuan', $request->poli_tujuan)
                    ->whereDate('tanggal_periksa', $request->tanggal_periksa)
                    ->whereIn('status', ['pending', 'diproses'])
                    ->lockForUpdate()
                    ->count();

                if ($terdaftar >= $jadwal->kuota) {
                    throw new Exception('Kuota untuk poli ' . $request->poli_tujuan .
                        ' pada tanggal ' . $tanggalPeriksa->format('d/m/Y') .
                        ' sudah penuh (Kuota: ' . $jadwal->kuota . ')');
                }

                // PERBAIKAN: Cek duplikasi dengan ketat
                $existing = Pelayanan::where('nik', $request->nik)
                    ->whereDate('tanggal_periksa', $request->tanggal_periksa)
                    ->whereIn('status', ['pending', 'diproses', 'selesai'])
                    ->exists();

                if ($existing) {
                    throw new Exception('Anda sudah memiliki pendaftaran aktif untuk tanggal ini. Silakan cek status pendaftaran Anda.');
                }

                // Generate No RM dengan anti-collision
                $no_rm = $this->generateUniqueNoRM();

                // Buat data pendaftaran
                $pelayanan = Pelayanan::create([
                    'no_rm' => $no_rm,
                    'nama' => $request->nama,
                    'nik' => $request->nik,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'alamat' => $request->alamat,
                    'no_hp' => $request->no_hp,
                    'poli_tujuan' => $request->poli_tujuan,
                    'tanggal_periksa' => $request->tanggal_periksa,
                    'keluhan' => $request->keluhan,
                    'status' => 'pending'
                ]);

                Log::info('Pendaftaran berhasil - No RM: ' . $no_rm . ', NIK: ' . substr($request->nik, 0, 6) . '*****');

                return redirect()->route('pelayanan.index')
                    ->with('success', 'Pendaftaran berhasil! Nomor Rekam Medis Anda: <strong>' . $no_rm . '</strong>. Silakan simpan nomor ini untuk cek status.');

            } catch (Exception $e) {
                Log::error('Gagal menyimpan pendaftaran: ' . $e->getMessage());
                DB::rollBack();
                throw $e;
            }
        }, 3); // Retry 3 kali jika deadlock
    }

    /**
     * Cek status pendaftaran
     */
    public function cekStatus(Request $request)
    {
        try {
            $profil = Profil::first();
            $statistic = $this->getFooterStatistics();

            $request->validate([
                'no_rm' => [
                    'required',
                    'string',
                    'regex:/^RM-[0-9]{6}-[0-9]{4}$/',
                    'exists:pelayanans,no_rm'
                ]
            ], [
                'no_rm.regex' => 'Format Nomor Rekam Medis tidak valid. Contoh: RM-202312-0001',
                'no_rm.exists' => 'Nomor Rekam Medis tidak ditemukan'
            ]);

            // PERBAIKAN: Ambil data dengan relasi jika ada
            $pelayanan = Pelayanan::where('no_rm', $request->no_rm)->first();

            // PERBAIKAN: Tambahkan informasi jadwal
            if ($pelayanan) {
                $tanggalPeriksa = Carbon::parse($pelayanan->tanggal_periksa);
                $hariPeriksa = $this->getHariIndonesia($tanggalPeriksa);

                $jadwal = JadwalPemeriksaan::where('poli', $pelayanan->poli_tujuan)
                    ->where('hari', $hariPeriksa)
                    ->first();

                $pelayanan->jadwal_info = $jadwal;
            }

            return view('frontend.cek-status', compact('pelayanan', 'profil', 'statistic'));

        } catch (Exception $e) {
            Log::error('Error di cekStatus: ' . $e->getMessage());

            return redirect()->route('pelayanan.index')
                ->with('error', 'Terjadi kesalahan saat memeriksa status. Silakan coba lagi.');
        }
    }

    /**
     * API endpoint untuk cek ketersediaan kuota (AJAX)
     */
    public function cekKuota(Request $request)
    {
        try {
            $request->validate([
                'poli' => 'required|string|exists:jadwal_pemeriksaans,poli',
                'tanggal' => 'required|date|after_or_equal:today|before_or_equal:' . now()->addDays(30)->format('Y-m-d')
            ]);

            $tanggal = Carbon::parse($request->tanggal);
            $hariPeriksa = $this->getHariIndonesia($tanggal);

            // Cek jadwal
            $jadwal = JadwalPemeriksaan::where('poli', $request->poli)
                ->where(function($query) use ($hariPeriksa) {
                    $query->where('hari', $hariPeriksa)
                          ->orWhereRaw('LOWER(hari) = ?', [strtolower($hariPeriksa)]);
                })
                ->first();

            if (!$jadwal) {
                $jadwalTersedia = $this->getJadwalTersedia($request->poli);
                return response()->json([
                    'success' => false,
                    'available' => false,
                    'message' => 'Poli tidak beroperasi pada hari ' . $hariPeriksa,
                    'jadwal_tersedia' => $jadwalTersedia ?: 'Tidak ada jadwal',
                    'hari_operasional' => $jadwalTersedia
                ]);
            }

            // Hitung kuota dengan lock untuk akurasi
            $terdaftar = Pelayanan::where('poli_tujuan', $request->poli)
                ->whereDate('tanggal_periksa', $request->tanggal)
                ->whereIn('status', ['pending', 'diproses'])
                ->count();

            $sisa = $jadwal->kuota - $terdaftar;

            return response()->json([
                'success' => true,
                'available' => $sisa > 0,
                'sisa_kuota' => max(0, $sisa),
                'total_kuota' => $jadwal->kuota,
                'terdaftar' => $terdaftar,
                'hari_operasional' => $jadwal->hari,
                'jam_operasional' => substr($jadwal->jam_mulai, 0, 5) . ' - ' . substr($jadwal->jam_selesai, 0, 5),
                'dokter' => $jadwal->dokter,
                'message' => $sisa > 0
                    ? "Tersedia $sisa dari {$jadwal->kuota} kuota"
                    : "Maaf, kuota untuk hari ini sudah penuh"
            ]);

        } catch (Exception $e) {
            Log::error('Error di cekKuota: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'available' => false,
                'message' => 'Gagal mengecek kuota. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * API endpoint untuk mendapatkan jadwal poli (AJAX)
     */
    public function getJadwalPoli(Request $request)
    {
        try {
            $request->validate([
                'poli' => 'required|string|exists:jadwal_pemeriksaans,poli'
            ]);

            $jadwals = JadwalPemeriksaan::where('poli', $request->poli)
                ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
                ->orderBy('jam_mulai')
                ->get([
                    'hari',
                    'jam_mulai',
                    'jam_selesai',
                    'dokter',
                    'kuota'
                ]);

            return response()->json([
                'success' => true,
                'data' => $jadwals,
                'message' => $jadwals->isEmpty() ? 'Tidak ada jadwal untuk poli ini' : null
            ]);

        } catch (Exception $e) {
            Log::error('Error di getJadwalPoli: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil jadwal'
            ], 500);
        }
    }

    /**
     * Generate Nomor Rekam Medis yang unik
     */
    private function generateUniqueNoRM(): string
    {
        $maxAttempts = 10;
        $attempt = 0;

        do {
            $no_rm = Pelayanan::generateNoRM();
            $exists = Pelayanan::where('no_rm', $no_rm)->exists();
            $attempt++;

            if ($attempt >= $maxAttempts) {
                // Fallback: tambahkan random number dan timestamp
                $no_rm = $no_rm . rand(100, 999) . substr(time(), -2);
                Log::warning('No RM fallback digunakan: ' . $no_rm);
                break;
            }
        } while ($exists);

        return $no_rm;
    }

    /**
     * Helper: Mendapatkan statistik footer
     */
    private function getFooterStatistics(): array
    {
        $statistic = Setting::where('key', 'footer_statistic')->first();

        if ($statistic) {
            return json_decode($statistic->value, true) ?: $this->getDefaultStatistics();
        }

        return $this->getDefaultStatistics();
    }

    /**
     * Helper: Default statistics
     */
    private function getDefaultStatistics(): array
    {
        return [
            'total_pasien' => Pelayanan::count() ?: 0,
            'total_dokter' => JadwalPemeriksaan::distinct('dokter')->count('dokter') ?: 0,
            'total_kunjungan_hari' => Pelayanan::whereDate('created_at', today())->count() ?: 0,
            'total_posyandu' => 0
        ];
    }

    /**
     * Helper: Mengelompokkan jadwal berdasarkan poli
     */
    private function groupJadwalByPoli($jadwals): array
    {
        $jadwalPerPoli = [];

        foreach ($jadwals as $jadwal) {
            $poli = $jadwal->poli;

            if (!isset($jadwalPerPoli[$poli])) {
                $jadwalPerPoli[$poli] = [
                    'poli' => $poli,
                    'jadwal' => []
                ];
            }

            // Hitung sisa kuota untuk hari ini
            $terdaftarHariIni = Pelayanan::where('poli_tujuan', $poli)
                ->whereDate('tanggal_periksa', today())
                ->whereIn('status', ['pending', 'diproses'])
                ->count();

            $jadwalPerPoli[$poli]['jadwal'][] = [
                'id' => $jadwal->id,
                'hari' => $jadwal->hari,
                'jam_mulai' => $jadwal->jam_mulai,
                'jam_selesai' => $jadwal->jam_selesai,
                'jam' => substr($jadwal->jam_mulai, 0, 5) . ' - ' . substr($jadwal->jam_selesai, 0, 5),
                'dokter' => $jadwal->dokter,
                'kuota' => $jadwal->kuota,
                'sisa_kuota_hari_ini' => max(0, $jadwal->kuota - $terdaftarHariIni)
            ];
        }

        // Urutkan berdasarkan nama poli
        ksort($jadwalPerPoli);

        return array_values($jadwalPerPoli);
    }

    /**
     * Helper: Mendapatkan nama hari dalam Bahasa Indonesia dengan format yang benar
     */
    private function getHariIndonesia(Carbon $tanggal): string
    {
        $hari = $tanggal->locale('id')->dayName;
        // Pastikan huruf pertama kapital
        return ucfirst($hari);
    }

    /**
     * Helper: Mendapatkan jadwal tersedia untuk suatu poli
     */
    private function getJadwalTersedia(string $poli): string
    {
        return JadwalPemeriksaan::where('poli', $poli)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->pluck('hari')
            ->implode(', ');
    }

    /**
     * Helper: Cek apakah tanggal adalah hari kerja
     */
    private function isHariKerja(Carbon $tanggal): bool
    {
        $hari = $tanggal->locale('id')->dayName;
        return !in_array($hari, ['Minggu']);
    }

    /**
     * Helper: Format nomor telepon
     */
    private function formatNoHP(string $no_hp): string
    {
        // Hapus semua karakter non-digit
        $no_hp = preg_replace('/[^0-9]/', '', $no_hp);

        // Jika diawali 0, ganti dengan 62
        if (substr($no_hp, 0, 1) == '0') {
            $no_hp = '62' . substr($no_hp, 1);
        }

        return $no_hp;
    }
}