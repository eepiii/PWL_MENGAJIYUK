<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HafalanSetoranController;
use App\Http\Controllers\QuranController;
use App\Http\Controllers\NilaiHafalanController;
use App\Http\Controllers\JurnalIbadahController;
use App\Http\Controllers\SurahController;
use App\Http\Controllers\AyatController;
use Illuminate\Support\Facades\Route;

// Halaman welcome
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Semua route di dalam sini wajib login (Auth)
Route::middleware('auth')->group(function () {

    // --- PROFILE ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- QURAN ---
    Route::get('/quran', [QuranController::class, 'index'])->name('quran.index');
    Route::get('/quran/{nomor_surah}', [QuranController::class, 'show'])->name('quran.show');

    // --- SURAH & AYAT ---
    Route::get('/surah', [SurahController::class, 'index'])->name('surah.index');
    Route::get('/surah/{nomor}', [SurahController::class, 'show'])->name('surah.show');
    Route::get('/surah/{surahNomor}/ayat', [AyatController::class, 'index'])->name('ayat.index');
    Route::get('/surah/{surahNomor}/ayat/{nomorAyat}', [AyatController::class, 'show'])->name('ayat.show');

    // --- JURNAL IBADAH ---
    Route::get('/jurnal', [JurnalIbadahController::class, 'index'])->name('jurnal.index');
    Route::post('/jurnal', [JurnalIbadahController::class, 'store'])->name('jurnal.store');

    // --- SETORAN (guru & santri) ---
    // pengecekan role sudah ada di dalam controller masing-masing
    Route::get('/setoran', [HafalanSetoranController::class, 'index'])->name('setoran.index');
    Route::get('/setoran/create', [HafalanSetoranController::class, 'create'])->name('setoran.create');
    Route::post('/setoran', [HafalanSetoranController::class, 'store'])->name('setoran.store');
    Route::get('/setoran/progress', [NilaiHafalanController::class, 'progress'])->name('setoran.progress');
    Route::get('/setoran/{setoran}', [HafalanSetoranController::class, 'show'])->name('setoran.show');

    // --- FITUR KHUSUS SANTRI ---
    Route::middleware(['role:santri'])->group(function () {
        Route::get('/setoran/create', [HafalanSetoranController::class, 'create'])->name('setoran.create');
        Route::post('/setoran', [HafalanSetoranController::class, 'store'])->name('setoran.store');
        Route::get('/setoran/progress', [HafalanSetoranController::class, 'progress'])->name('setoran.progress');
    });

    // --- FITUR KHUSUS GURU ---
    Route::middleware(['role:guru'])->group(function () {
        Route::get('/penilaian', [NilaiHafalanController::class, 'index'])->name('penilaian.index');
        Route::post('/penilaian/{id}', [NilaiHafalanController::class, 'store'])->name('penilaian.store');

        Route::get('/setoran/{setoran}/nilai/create', [NilaiHafalanController::class, 'create'])->name('nilai.create');
        Route::post('/setoran/{setoran}/nilai', [NilaiHafalanController::class, 'store'])->name('nilai.store');
    });
});

require __DIR__.'/auth.php';