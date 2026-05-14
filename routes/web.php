<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PelayananController;
use App\Http\Controllers\Frontend\KontakController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\VisiMisiController;
use App\Http\Controllers\Admin\StrukturOrganisasiController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\SejarahController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\JadwalPosyanduController;
use App\Http\Controllers\Admin\JadwalPemeriksaanController;
use App\Http\Controllers\Admin\PelayananController as AdminPelayananController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\KontakController as AdminKontakController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== FRONTEND ROUTES ====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/berita', [HomeController::class, 'allBerita'])->name('berita.all');
Route::get('/berita/{id}', [HomeController::class, 'detailBerita'])->name('berita.detail');
Route::get('/galeri', [HomeController::class, 'allGaleri'])->name('galeri.all');
Route::get('/struktur-organisasi', [HomeController::class, 'strukturOrganisasi'])->name('struktur.organisasi');

// Pelayanan Online Routes
Route::prefix('pelayanan')->name('pelayanan.')->group(function () {
    Route::get('/', [PelayananController::class, 'index'])->name('index');
    Route::post('/', [PelayananController::class, 'store'])->name('store');
    Route::post('/cek-status', [PelayananController::class, 'cekStatus'])->name('cek-status');
    Route::post('/cek-kuota', [PelayananController::class, 'cekKuota'])->name('cek-kuota');
    Route::post('/get-jadwal-poli', [PelayananController::class, 'getJadwalPoli'])->name('get-jadwal');
});

// Kontak Routes
Route::post('/kontak/send', [KontakController::class, 'sendMessage'])->name('kontak.send');

// ==================== ADMIN ROUTES ====================
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pelayanan Management
    Route::prefix('pelayanan')->name('pelayanan.')->group(function () {
        Route::get('/', [AdminPelayananController::class, 'index'])->name('index');
        Route::get('/{pelayanan}', [AdminPelayananController::class, 'show'])->name('show');
        Route::get('/{pelayanan}/edit', [AdminPelayananController::class, 'edit'])->name('edit');
        Route::put('/{pelayanan}', [AdminPelayananController::class, 'update'])->name('update');
        Route::delete('/{pelayanan}', [AdminPelayananController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-update', [AdminPelayananController::class, 'bulkUpdate'])->name('bulk-update');
        Route::get('/export', [AdminPelayananController::class, 'export'])->name('export');
    });

    // Kontak Management
    Route::prefix('kontak')->name('kontak.')->group(function () {
        Route::get('/', [AdminKontakController::class, 'index'])->name('index');
        Route::get('/{kontak}', [AdminKontakController::class, 'show'])->name('show');
        Route::delete('/{kontak}', [AdminKontakController::class, 'destroy'])->name('destroy');
        Route::post('/{kontak}/mark-read', [AdminKontakController::class, 'markAsRead'])->name('mark-read');
        Route::get('/export', [AdminKontakController::class, 'export'])->name('export'); // TAMBAHKAN INI
    });

    // Berita Management
    Route::resource('berita', BeritaController::class);

    // Visi Misi
    Route::get('/visi-misi/edit', [VisiMisiController::class, 'edit'])->name('visi-misi.edit');
    Route::put('/visi-misi', [VisiMisiController::class, 'update'])->name('visi-misi.update');

    // Struktur Organisasi
    Route::resource('struktur', StrukturOrganisasiController::class);
    Route::post('/struktur/reorder', [StrukturOrganisasiController::class, 'reorder'])->name('struktur.reorder');

    // Galeri
    Route::resource('galeri', GaleriController::class);

    // Sejarah
    Route::get('/sejarah/edit', [SejarahController::class, 'edit'])->name('sejarah.edit');
    Route::put('/sejarah', [SejarahController::class, 'update'])->name('sejarah.update');

    // Profil
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');

    // Jadwal Posyandu
    Route::resource('jadwal-posyandu', JadwalPosyanduController::class);

    // Jadwal Pemeriksaan
    Route::resource('jadwal-pemeriksaan', JadwalPemeriksaanController::class);

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/settings/statistic', [SettingController::class, 'updateStatistic'])->name('setting.statistic.update');
    Route::post('/settings/clear-cache', [SettingController::class, 'clearCache'])->name('setting.cache.clear');
});

require __DIR__.'/auth.php';

Route::get('/offline', function () {
    return view('offline');
})->name('offline');