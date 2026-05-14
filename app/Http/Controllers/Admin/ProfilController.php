<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function edit()
    {
        $profil = Profil::first();
        return view('admin.profil.edit', compact('profil'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_puskesmas' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            'deskripsi' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_background' => 'nullable|image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $profil = Profil::first();

        // Prepare data (exclude file uploads)
        $data = $request->except(['logo', 'foto_background']);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($profil && $profil->logo) {
                Storage::disk('public')->delete($profil->logo);
            }
            // Store new logo
            $data['logo'] = $request->file('logo')->store('profil/logo', 'public');
        } elseif ($profil && $profil->logo) {
            // Keep existing logo if no new file uploaded
            $data['logo'] = $profil->logo;
        }

        // Handle background upload
        if ($request->hasFile('foto_background')) {
            // Delete old background if exists
            if ($profil && $profil->foto_background) {
                Storage::disk('public')->delete($profil->foto_background);
            }
            // Store new background
            $data['foto_background'] = $request->file('foto_background')->store('profil/background', 'public');
        } elseif ($profil && $profil->foto_background) {
            // Keep existing background if no new file uploaded
            $data['foto_background'] = $profil->foto_background;
        }

        if ($profil) {
            // Update existing record
            $profil->update($data);
        } else {
            // Create new record
            Profil::create($data);
        }

        return redirect()->route('admin.profil.edit')
            ->with('success', 'Profil berhasil diperbarui');
    }
}
