<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPosyandu;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalPosyanduController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalPosyandu::query();

        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        // Filter berdasarkan tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        // Pencarian
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_posyandu', 'like', '%' . $request->search . '%')
                  ->orWhere('lokasi', 'like', '%' . $request->search . '%');
            });
        }

        // Urutkan berdasarkan tanggal terbaru
        $query->orderBy('tanggal', 'desc');

        // Data untuk statistik - hitung di controller bukan di view
        $totalJadwal = JadwalPosyandu::count();
        $jadwalMendatang = JadwalPosyandu::whereDate('tanggal', '>', Carbon::today())->count();
        $jadwalHariIni = JadwalPosyandu::whereDate('tanggal', Carbon::today())->count();

        $jadwals = $query->paginate(10);

        return view('admin.jadwal-posyandu.index', compact(
            'jadwals',
            'totalJadwal',
            'jadwalMendatang',
            'jadwalHariIni'
        ));
    }

    public function create()
    {
        return view('admin.jadwal-posyandu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_posyandu' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'keterangan' => 'nullable|string'
        ]);

        JadwalPosyandu::create($request->all());

        return redirect()->route('admin.jadwal-posyandu.index')
            ->with('success', 'Jadwal posyandu berhasil ditambahkan');
    }

    public function edit(JadwalPosyandu $jadwalPosyandu)
    {
        return view('admin.jadwal-posyandu.edit', compact('jadwalPosyandu'));
    }

    public function update(Request $request, JadwalPosyandu $jadwalPosyandu)
    {
        $request->validate([
            'nama_posyandu' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'keterangan' => 'nullable|string'
        ]);

        $jadwalPosyandu->update($request->all());

        return redirect()->route('admin.jadwal-posyandu.index')
            ->with('success', 'Jadwal posyandu berhasil diperbarui');
    }

    public function destroy(JadwalPosyandu $jadwalPosyandu)
    {
        $jadwalPosyandu->delete();

        return redirect()->route('admin.jadwal-posyandu.index')
            ->with('success', 'Jadwal posyandu berhasil dihapus');
    }
}
