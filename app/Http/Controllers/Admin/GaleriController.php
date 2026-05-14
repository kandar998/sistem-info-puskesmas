<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        $galeris = Galeri::latest()->paginate(12);
        return view('admin.galeri.index', compact('galeris'));
    }

    public function create()
    {
        return view('admin.galeri.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'tipe' => 'required|in:foto,video',
            'file' => $request->tipe == 'foto' ? 'required|image|mimes:jpeg,png,jpg|max:5120' : 'required|url',
            'deskripsi' => 'nullable'
        ]);

        $data = $request->all();

        if ($request->tipe == 'foto' && $request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('galeri/foto', 'public');

            // Buat thumbnail
            $data['thumbnail'] = $data['file'];
        }

        Galeri::create($data);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Galeri berhasil ditambahkan');
    }

    public function edit(Galeri $galeri)
    {
        return view('admin.galeri.edit', compact('galeri'));
    }

    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'judul' => 'required',
            'tipe' => 'required|in:foto,video',
            'file' => $galeri->tipe == 'foto' && $request->hasFile('file') ? 'image|mimes:jpeg,png,jpg|max:5120' : 'nullable',
            'deskripsi' => 'nullable'
        ]);

        $data = $request->all();

        if ($request->tipe == 'foto' && $request->hasFile('file')) {
            if ($galeri->file) {
                Storage::disk('public')->delete($galeri->file);
            }
            $data['file'] = $request->file('file')->store('galeri/foto', 'public');
            $data['thumbnail'] = $data['file'];
        }

        $galeri->update($data);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Galeri berhasil diperbarui');
    }

    public function destroy(Galeri $galeri)
    {
        if ($galeri->tipe == 'foto' && $galeri->file) {
            Storage::disk('public')->delete($galeri->file);
        }

        $galeri->delete();

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Galeri berhasil dihapus');
    }
}
