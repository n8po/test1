<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\UkmController;
use App\Http\Controllers\PendaftaranController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Mahasiswa Routes
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::post('/mahasiswa/search', [MahasiswaController::class, 'search'])->name('mahasiswa.search');
    Route::get('/mahasiswa/export', [MahasiswaController::class, 'exportExcel'])->name('mahasiswa.export');
    Route::get('/mahasiswa/cetak', [MahasiswaController::class, 'cetak'])->name('mahasiswa.cetak');

    // UKM Routes
    Route::resource('ukm', UkmController::class);
    Route::post('/ukm/search', [UkmController::class, 'search'])->name('ukm.search');
    Route::get('/ukm/export', [UkmController::class, 'exportExcel'])->name('ukm.export');
    Route::get('/ukm/cetak', [UkmController::class, 'cetak'])->name('ukm.cetak');

    // Pendaftaran Routes
    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::post('/pendaftaran/{id}/setujui', [PendaftaranController::class, 'setujui'])->name('pendaftaran.setujui');
    Route::post('/pendaftaran/{id}/tolak', [PendaftaranController::class, 'tolak'])->name('pendaftaran.tolak');
    Route::post('/pendaftaran/search', [PendaftaranController::class, 'search'])->name('pendaftaran.search');
    Route::get('/pendaftaran/export', [PendaftaranController::class, 'exportExcel'])->name('pendaftaran.export');
    Route::get('/pendaftaran/cetak', [PendaftaranController::class, 'cetak'])->name('pendaftaran.cetak');

    // Anggota UKM Routes
    Route::get('/admin/anggota', [AdminController::class, 'indexAnggota'])->name('admin.anggota.index');
    Route::get('/admin/anggota/create', [AdminController::class, 'createAnggota'])->name('admin.anggota.create');
    Route::post('/admin/anggota', [AdminController::class, 'storeAnggota'])->name('admin.anggota.store');
    Route::get('/admin/anggota/{id}/edit', [AdminController::class, 'editAnggota'])->name('admin.anggota.edit');
    Route::put('/admin/anggota/{id}', [AdminController::class, 'updateAnggota'])->name('admin.anggota.update');
    Route::delete('/admin/anggota/{id}', [AdminController::class, 'destroyAnggota'])->name('admin.anggota.destroy');
    Route::get('/admin/anggota/export/{ukm_id?}', [AdminController::class, 'exportAnggota'])->name('admin.anggota.export');
    Route::get('/admin/anggota/cetak/{ukm_id?}', [AdminController::class, 'cetakAnggota'])->name('admin.anggota.cetak');
});
