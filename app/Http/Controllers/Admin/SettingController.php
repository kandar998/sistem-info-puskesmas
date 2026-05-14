<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan; // Tambahkan ini!

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.setting.index');
    }

    public function updateStatistic(Request $request)
    {
        $request->validate([
            'total_pasien' => 'required|numeric',
            'total_dokter' => 'required|numeric',
            'total_kunjungan_hari' => 'required|numeric',
            'total_posyandu' => 'required|numeric'
        ]);

        Setting::updateOrCreate(
            ['key' => 'footer_statistic'],
            ['value' => json_encode($request->only([
                'total_pasien',
                'total_dokter',
                'total_kunjungan_hari',
                'total_posyandu'
            ]))]
        );

        return redirect()->route('admin.setting.index')
            ->with('success', 'Statistik berhasil diperbarui');
    }

    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');

            return response()->json([
                'success' => true,
                'message' => 'Cache berhasil dibersihkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membersihkan cache: ' . $e->getMessage()
            ], 500);
        }
    }
}
