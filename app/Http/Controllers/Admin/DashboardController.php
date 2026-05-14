<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelayanan;
use App\Models\Berita;
use App\Models\JadwalPemeriksaan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPelayanan = Pelayanan::count();
        $pelayananHariIni = Pelayanan::whereDate('created_at', Carbon::today())->count();
        $pelayananPending = Pelayanan::where('status', 'pending')->count();
        $totalBerita = Berita::count();

        $pelayananPerBulan = Pelayanan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('bulan')
            ->get();

        return view('admin.dashboard', compact(
            'totalPelayanan',
            'pelayananHariIni',
            'pelayananPending',
            'totalBerita',
            'pelayananPerBulan'
        ));
    }
}