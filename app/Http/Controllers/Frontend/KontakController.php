<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Kontak; // Perhatikan: Models dengan huruf 'M' besar
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KontakController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'pesan' => 'required|string|min:10'
        ]);

        try {
            // Simpan ke database
            $kontak = Kontak::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'pesan' => $request->pesan,
                'status' => 'belum_dibaca'
            ]);

            // Log untuk debugging
            Log::info('Pesan kontak baru berhasil disimpan', [
                'id' => $kontak->id,
                'nama' => $kontak->nama,
                'email' => $kontak->email
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pesan Anda berhasil dikirim. Terima kasih telah menghubungi kami.'
            ]);

        } catch (\Exception $e) {
            // Log error detail
            Log::error('Error menyimpan pesan kontak: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Maaf, terjadi kesalahan. Silakan coba lagi nanti.'
            ], 500);
        }
    }
}
