<?php

use App\Http\Controllers\ProfileController; 
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

});

require __DIR__.'/auth.php';
