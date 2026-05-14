<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PelayananController extends Controller
{
    /**
     * Constructor untuk memastikan hanya admin yang bisa mengakses
     * LARAVEL 11: Tidak perlu memanggil middleware di constructor
     * Middleware didefinisikan di route
     */

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query builder
        $query = Pelayanan::query();

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        // Filter berdasarkan tanggal periksa
        if ($request->filled('tanggal_periksa')) {
            $query->whereDate('tanggal_periksa', $request->tanggal_periksa);
        }

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_rm', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan poli
        if ($request->filled('poli')) {
            $query->where('poli_tujuan', $request->poli);
        }

        // Urutkan berdasarkan yang terbaru
        $query->latest();

        // Statistik untuk ditampilkan di header
        $statistics = [
            'total' => Pelayanan::count(),
            'pending' => Pelayanan::where('status', 'pending')->count(),
            'diproses' => Pelayanan::where('status', 'diproses')->count(),
            'selesai' => Pelayanan::where('status', 'selesai')->count(),
            'ditolak' => Pelayanan::where('status', 'ditolak')->count(),
            'hari_ini' => Pelayanan::whereDate('created_at', Carbon::today())->count(),
            'minggu_ini' => Pelayanan::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
            'bulan_ini' => Pelayanan::whereMonth('created_at', Carbon::now()->month)->count(),
        ];

        // Data untuk dropdown filter poli
        $daftarPoli = Pelayanan::select('poli_tujuan')->distinct()->pluck('poli_tujuan');

        // Pagination
        $pelayanans = $query->paginate(15)->withQueryString();

        return view('admin.pelayanan.index', compact(
            'pelayanans',
            'statistics',
            'daftarPoli'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelayanan $pelayanan)
    {
        // Ambil riwayat perubahan status (jika ada tabel logs)
        $riwayat = $this->getRiwayatPelayanan($pelayanan->id);

        // Rekomendasi jadwal berdasarkan poli
        $rekomendasiJadwal = $this->getRekomendasiJadwal($pelayanan->poli_tujuan);

        return view('admin.pelayanan.show', compact('pelayanan', 'riwayat', 'rekomendasiJadwal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pelayanan $pelayanan)
    {
        // Cek apakah sudah ada perubahan sebelumnya
        $lastUpdate = $pelayanan->updated_at;

        return view('admin.pelayanan.edit', compact('pelayanan', 'lastUpdate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pelayanan $pelayanan)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,ditolak',
            'catatan_admin' => 'nullable|string|max:500',
        ], [
            'status.required' => 'Status harus dipilih',
            'status.in' => 'Status tidak valid',
            'catatan_admin.max' => 'Catatan maksimal 500 karakter',
        ]);

        // Simpan status lama untuk log
        $oldStatus = $pelayanan->status;

        // Update data
        $pelayanan->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        // Log aktivitas
        $this->logAktivitas($pelayanan, $oldStatus, $request->status);

        // Kirim notifikasi jika status berubah (opsional)
        if ($oldStatus != $request->status) {
            $this->kirimNotifikasiStatus($pelayanan, $oldStatus, $request->status);
        }

        // Redirect dengan pesan sukses
        $message = "Status pelayanan <strong>{$pelayanan->no_rm}</strong> atas nama <strong>{$pelayanan->nama}</strong> berhasil diperbarui dari <span class='badge bg-secondary'>{$oldStatus}</span> menjadi <span class='badge bg-success'>{$request->status}</span>";

        return redirect()->route('admin.pelayanan.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelayanan $pelayanan)
    {
        // Cek apakah bisa dihapus (misalnya hanya status tertentu)
        if (!in_array($pelayanan->status, ['pending', 'ditolak'])) {
            return redirect()->route('admin.pelayanan.index')
                ->with('error', 'Data dengan status ' . $pelayanan->status . ' tidak dapat dihapus');
        }

        // Simpan data untuk log
        $data = [
            'no_rm' => $pelayanan->no_rm,
            'nama' => $pelayanan->nama
        ];

        // Hapus data
        $pelayanan->delete();

        // Log aktivitas
        Log::info("User " . (Auth::user()->email ?? 'unknown') . " menghapus data pelayanan {$data['no_rm']} atas nama {$data['nama']}");

        return redirect()->route('admin.pelayanan.index')
            ->with('success', "Data pelayanan <strong>{$data['no_rm']}</strong> atas nama <strong>{$data['nama']}</strong> berhasil dihapus");
    }

    /**
     * Bulk update status
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:pelayanans,id',
            'status' => 'required|in:pending,diproses,selesai,ditolak',
        ]);

        $count = Pelayanan::whereIn('id', $request->ids)
            ->update(['status' => $request->status]);

        // Log aktivitas bulk update
        Log::info("User " . (Auth::user()->email ?? 'unknown') . " melakukan bulk update {$count} data menjadi status {$request->status}");

        return redirect()->route('admin.pelayanan.index')
            ->with('success', "{$count} data berhasil diperbarui status menjadi {$request->status}");
    }

    /**
     * Export data ke Excel/PDF
     */
    public function export(Request $request)
    {
        $query = Pelayanan::query();

        // Apply filters sama seperti di index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        $data = $query->get();

        // Generate Excel/PDF (implementasi sesuai kebutuhan)
        // return Excel::download(new PelayananExport($data), 'pelayanan.xlsx');

        return redirect()->back()->with('info', 'Fitur export sedang dalam pengembangan');
    }

    /**
     * Get riwayat pelayanan
     */
    private function getRiwayatPelayanan($id)
    {
        // Jika ada tabel logs, ambil dari sana
        // return PelayananLog::where('pelayanan_id', $id)->get();

        // Sementara return array kosong
        return [];
    }

    /**
     * Get rekomendasi jadwal berdasarkan poli
     */
    private function getRekomendasiJadwal($poli)
    {
        // Implementasi rekomendasi jadwal
        return null;
    }

    /**
     * Log aktivitas
     */
    private function logAktivitas($pelayanan, $oldStatus, $newStatus)
    {
        // Simpan ke tabel logs jika ada
        Log::info("User " . (Auth::user()->email ?? 'unknown') . " mengubah status pelayanan {$pelayanan->no_rm} dari {$oldStatus} menjadi {$newStatus}");
    }

    /**
     * Kirim notifikasi status ke pasien (opsional)
     */
    private function kirimNotifikasiStatus($pelayanan, $oldStatus, $newStatus)
    {
        // Implementasi notifikasi WhatsApp/Email
        // Bisa menggunakan library seperti Twilio, WhatsApp API, dll

        // Contoh sederhana: Log notifikasi
        Log::info("Notifikasi akan dikirim ke pasien {$pelayanan->nama} untuk perubahan status dari {$oldStatus} ke {$newStatus}");
    }
}
