<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\VisiMisi;
use App\Models\StrukturOrganisasi;
use App\Models\Galeri;
use App\Models\Sejarah;
use App\Models\Profil;
use App\Models\JadwalPosyandu;
use App\Models\JadwalPemeriksaan;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $profil = Profil::first();
        $visiMisi = VisiMisi::first();
        $beritas = Berita::where('status', 'publish')->latest()->take(3)->get();
        $strukturs = StrukturOrganisasi::orderBy('urutan')->take(4)->get();
        $galeris = Galeri::latest()->take(6)->get();
        $jadwalPosyandus = JadwalPosyandu::whereDate('tanggal', '>=', now())->orderBy('tanggal')->take(5)->get();
        $jadwalPemeriksaans = JadwalPemeriksaan::orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")->get();
        $sejarah = Sejarah::first();

        $statistic = Setting::where('key', 'footer_statistic')->first();
        $statistic = $statistic ? json_decode($statistic->value, true) : [
            'total_pasien' => 0,
            'total_dokter' => 0,
            'total_kunjungan_hari' => 0,
            'total_posyandu' => 0
        ];

        return view('frontend.home', compact(
            'profil',
            'visiMisi',
            'beritas',
            'strukturs',
            'galeris',
            'jadwalPosyandus',
            'jadwalPemeriksaans',
            'sejarah',
            'statistic' // PERBAIKAN: Pastikan statistic dikirim
        ));
    }

    public function allBerita(Request $request)
    {
        $profil = Profil::first();

        // PERBAIKAN: Ambil statistic untuk footer
        $statistic = Setting::where('key', 'footer_statistic')->first();
        $statistic = $statistic ? json_decode($statistic->value, true) : [
            'total_pasien' => 0,
            'total_dokter' => 0,
            'total_kunjungan_hari' => 0,
            'total_posyandu' => 0
        ];

        $query = Berita::where('status', 'publish');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('konten', 'like', "%{$search}%");
            });
        }

        $beritas = $query->latest()->paginate(9)->withQueryString();

        return view('frontend.berita', compact('beritas', 'profil', 'statistic'));
    }

    public function detailBerita($id)
    {
        $profil = Profil::first();

        // PERBAIKAN: Ambil statistic untuk footer
        $statistic = Setting::where('key', 'footer_statistic')->first();
        $statistic = $statistic ? json_decode($statistic->value, true) : [
            'total_pasien' => 0,
            'total_dokter' => 0,
            'total_kunjungan_hari' => 0,
            'total_posyandu' => 0
        ];

        try {
            $berita = Berita::where('status', 'publish')->findOrFail($id);

            $beritaLainnya = Berita::where('id', '!=', $id)
                ->where('status', 'publish')
                ->latest()
                ->take(3)
                ->get();

            return view('frontend.berita-detail', compact('berita', 'beritaLainnya', 'profil', 'statistic'));

        } catch (\Exception $e) {
            abort(404, 'Berita tidak ditemukan');
        }
    }

    public function allGaleri(Request $request)
    {
        $profil = Profil::first();

        // PERBAIKAN: Ambil statistic untuk footer
        $statistic = Setting::where('key', 'footer_statistic')->first();
        $statistic = $statistic ? json_decode($statistic->value, true) : [
            'total_pasien' => 0,
            'total_dokter' => 0,
            'total_kunjungan_hari' => 0,
            'total_posyandu' => 0
        ];

        $query = Galeri::latest();

        if ($request->has('tipe') && in_array($request->tipe, ['foto', 'video'])) {
            $query->where('tipe', $request->tipe);
        }

        $galeris = $query->paginate(12)->withQueryString();

        return view('frontend.galeri', compact('galeris', 'profil', 'statistic'));
    }

    public function strukturOrganisasi()
    {
        $profil = Profil::first();

        // PERBAIKAN: Ambil statistic untuk footer
        $statistic = Setting::where('key', 'footer_statistic')->first();
        $statistic = $statistic ? json_decode($statistic->value, true) : [
            'total_pasien' => 0,
            'total_dokter' => 0,
            'total_kunjungan_hari' => 0,
            'total_posyandu' => 0
        ];

        $strukturs = StrukturOrganisasi::orderBy('urutan')->get();

        $kepala = $strukturs->filter(function($item) {
            return strpos(strtolower($item->jabatan), 'kepala') !== false;
        })->first();

        $other = $strukturs->filter(function($item) use ($kepala) {
            return $kepala ? $item->id != $kepala->id : true;
        });

        return view('frontend.struktur', compact('strukturs', 'profil', 'statistic', 'kepala', 'other'));
    }
}
