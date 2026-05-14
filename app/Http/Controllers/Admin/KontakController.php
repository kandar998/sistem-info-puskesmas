<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class KontakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kontak::query();

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

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('pesan', 'like', "%{$search}%");
            });
        }

        // Urutkan dari yang terbaru
        $query->latest();

        $kontaks = $query->paginate(15);

        // Data untuk statistik
        $totalPesan = Kontak::count();
        $belumDibaca = Kontak::where('status', 'belum_dibaca')->count();
        $sudahDibaca = Kontak::where('status', 'sudah_dibaca')->count();
        $mingguIni = Kontak::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();

        return view('admin.kontak.index', compact(
            'kontaks',
            'totalPesan',
            'belumDibaca',
            'sudahDibaca',
            'mingguIni'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Kontak $kontak)
    {
        // Tandai otomatis sebagai sudah dibaca jika belum
        if ($kontak->status == 'belum_dibaca') {
            $kontak->update(['status' => 'sudah_dibaca']);
        }

        return view('admin.kontak.show', compact('kontak'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kontak $kontak)
    {
        $kontak->delete();

        return redirect()->route('admin.kontak.index')
            ->with('success', 'Pesan berhasil dihapus');
    }

    /**
     * Mark message as read.
     */
    public function markAsRead(Kontak $kontak)
    {
        $kontak->update(['status' => 'sudah_dibaca']);

        return response()->json(['success' => true]);
    }

    /**
     * Export data kontak ke CSV/Excel.
     */
    public function export(Request $request)
    {
        $query = Kontak::query();

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

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('pesan', 'like', "%{$search}%");
            });
        }

        $kontaks = $query->latest()->get();

        // Nama file
        $filename = 'pesan-masuk-' . date('Y-m-d-His') . '.csv';

        // Header CSV
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        // Buat callback untuk menulis CSV
        $callback = function() use ($kontaks) {
            $file = fopen('php://output', 'w');

            // Header kolom
            fputcsv($file, [
                'ID',
                'Nama',
                'Email',
                'Telepon',
                'Pesan',
                'Status',
                'Tanggal Kirim'
            ]);

            // Data
            foreach ($kontaks as $kontak) {
                fputcsv($file, [
                    $kontak->id,
                    $kontak->nama,
                    $kontak->email,
                    $kontak->telepon ?? '-',
                    $kontak->pesan,
                    $kontak->status == 'belum_dibaca' ? 'Belum Dibaca' : 'Sudah Dibaca',
                    $kontak->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
