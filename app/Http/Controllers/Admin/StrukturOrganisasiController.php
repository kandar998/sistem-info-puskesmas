<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StrukturOrganisasiController extends Controller
{
    public function index()
    {
        $strukturs = StrukturOrganisasi::orderBy('urutan')->get();
        return view('admin.struktur.index', compact('strukturs'));
    }

    public function create()
    {
        return view('admin.struktur.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'urutan' => 'required|integer'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('struktur', 'public');
        }

        StrukturOrganisasi::create($data);

        return redirect()->route('admin.struktur.index')
            ->with('success', 'Data struktur berhasil ditambahkan');
    }

    public function edit(StrukturOrganisasi $struktur)
    {
        return view('admin.struktur.edit', compact('struktur'));
    }

    public function update(Request $request, StrukturOrganisasi $struktur)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'urutan' => 'required|integer'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($struktur->foto) {
                Storage::disk('public')->delete($struktur->foto);
            }
            $data['foto'] = $request->file('foto')->store('struktur', 'public');
        }

        $struktur->update($data);

        return redirect()->route('admin.struktur.index')
            ->with('success', 'Data struktur berhasil diperbarui');
    }

    public function destroy(StrukturOrganisasi $struktur)
    {
        if ($struktur->foto) {
            Storage::disk('public')->delete($struktur->foto);
        }

        $struktur->delete();

        return redirect()->route('admin.struktur.index')
            ->with('success', 'Data struktur berhasil dihapus');
    }

    public function reorder(Request $request)
{
    $items = $request->items;

    foreach ($items as $item) {
        StrukturOrganisasi::where('id', $item['id'])->update(['urutan' => $item['urutan']]);
    }

    return response()->json(['success' => true]);
}

}
