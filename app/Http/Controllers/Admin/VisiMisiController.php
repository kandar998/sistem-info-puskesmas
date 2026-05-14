<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisiMisi;
use Illuminate\Http\Request;

class VisiMisiController extends Controller
{
    public function edit()
    {
        $visiMisi = VisiMisi::first();
        return view('admin.visi-misi.edit', compact('visiMisi'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'visi' => 'required',
            'misi' => 'required'
        ]);

        $visiMisi = VisiMisi::first();

        if ($visiMisi) {
            // Jika data sudah ada, update
            $visiMisi->update($request->all());
        } else {
            // Jika data belum ada, buat baru
            VisiMisi::create($request->all());
        }

        return redirect()->route('admin.visi-misi.edit')
            ->with('success', 'Visi dan Misi berhasil diperbarui');
    }
}
