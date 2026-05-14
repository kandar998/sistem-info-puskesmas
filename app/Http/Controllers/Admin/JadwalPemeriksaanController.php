<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPemeriksaan;
use Illuminate\Http\Request;

class JadwalPemeriksaanController extends Controller
{
    public function index()
    {
        // Ambil semua data tanpa pagination untuk ditampilkan dalam bentuk cards
        $jadwals = JadwalPemeriksaan::orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")->get();

        // Hitung statistik
        $totalJadwal = $jadwals->count();
        $totalPoli = $jadwals->pluck('poli')->unique()->count();
        $totalDokter = $jadwals->pluck('dokter')->unique()->count();

        return view('admin.jadwal-pemeriksaan.index', compact(
            'jadwals',
            'totalJadwal',
            'totalPoli',
            'totalDokter'
        ));
    }

    public function create()
    {
        return view('admin.jadwal-pemeriksaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'poli' => 'required|string|max:255',
            'dokter' => 'required|string|max:255',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'kuota' => 'required|integer|min:1'
        ]);

        JadwalPemeriksaan::create($request->all());

        return redirect()->route('admin.jadwal-pemeriksaan.index')
            ->with('success', 'Jadwal pemeriksaan berhasil ditambahkan');
    }

    public function edit(JadwalPemeriksaan $jadwalPemeriksaan)
    {
        return view('admin.jadwal-pemeriksaan.edit', compact('jadwalPemeriksaan'));
    }

    public function update(Request $request, JadwalPemeriksaan $jadwalPemeriksaan)
    {
        $request->validate([
            'poli' => 'required|string|max:255',
            'dokter' => 'required|string|max:255',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'kuota' => 'required|integer|min:1'
        ]);

        $jadwalPemeriksaan->update($request->all());

        return redirect()->route('admin.jadwal-pemeriksaan.index')
            ->with('success', 'Jadwal pemeriksaan berhasil diperbarui');
    }

    public function destroy(JadwalPemeriksaan $jadwalPemeriksaan)
    {
        $jadwalPemeriksaan->delete();

        return redirect()->route('admin.jadwal-pemeriksaan.index')
            ->with('success', 'Jadwal pemeriksaan berhasil dihapus');
    }
}
