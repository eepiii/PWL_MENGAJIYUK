<?php

use App\Http\Controllers\ProfileController; 
use App\Http\Controllers\HafalanSetoranController;
use App\Http\Controllers\QuranController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/quran', [QuranController::class, 'index']);
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    // ROUTES PROFIL BAWAAN BREEZE (Wajib ada agar tidak error)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 1. FITUR BACA QURAN (Bisa diakses Guru & Santri)
    Route::get('/quran', [QuranController::class, 'index'])->name('quran.index');
    Route::get('/quran/{nomor_surah}', [QuranController::class, 'show'])->name('quran.show');

    // 2. FITUR KHUSUS SANTRI (Spatie Role: santri)
    Route::middleware(['role:santri'])->group(function () {
        // Route::get('/setoran', [SetoranController::class, 'index'])->name('setoran.index');
        // Route::post('/setoran', [SetoranController::class, 'store'])->name('setoran.store');
    });

    // 3. FITUR KHUSUS GURU (Spatie Role: guru)
    Route::middleware(['role:guru'])->group(function () {
        // Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
        // Route::post('/penilaian/{id}', [PenilaianController::class, 'store'])->name('penilaian.store');
    });

    Route::middleware(['auth'])->group(function () {

    // SANTRI: hanya bisa menyetor + lihat riwayat + chart progress
    Route::middleware(['role:santri'])->group(function () {
        Route::get('/setoran/create', [HafalanSetoranController::class, 'create'])->name('setoran.create');
        Route::post('/setoran', [HafalanSetoranController::class, 'store'])->name('setoran.store');
        Route::get('/setoran/progress', [HafalanSetoranController::class, 'progress'])->name('setoran.progress');
    });

    // GURU: hanya lihat riwayat semua santri + menilai
    Route::middleware(['role:guru'])->group(function () {
        Route::get('/setoran/{setoran}/nilai/create', [NilaiHafalanController::class, 'create'])->name('nilai.create');
        Route::post('/setoran/{setoran}/nilai', [NilaiHafalanController::class, 'store'])->name('nilai.store');
    });

    // INDEX riwayat bisa diakses guru & santri (logic filter di controller, seperti kode existing)
    Route::get('/setoran', [HafalanSetoranController::class, 'index'])->name('setoran.index');
    Route::get('/setoran/{setoran}', [HafalanSetoranController::class, 'show'])->name('setoran.show');
});

});

require __DIR__.'/auth.php';
