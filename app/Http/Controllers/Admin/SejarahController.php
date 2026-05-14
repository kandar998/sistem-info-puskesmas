<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sejarah;
use Illuminate\Http\Request;

class SejarahController extends Controller
{
    public function edit()
    {
        $sejarah = Sejarah::first();
        return view('admin.sejarah.edit', compact('sejarah'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'konten' => 'required|min:10'
        ]);

        $sejarah = Sejarah::first();

        if ($sejarah) {
            // Jika data sudah ada, update
            $sejarah->update([
                'konten' => $request->konten
            ]);
        } else {
            // Jika data belum ada, buat baru
            Sejarah::create([
                'konten' => $request->konten
            ]);
        }

        return redirect()->route('admin.sejarah.edit')
            ->with('success', 'Sejarah berhasil diperbarui');
    }
}
