<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuranController;
use App\Http\Controllers\HafalanSetoranController; 
use App\Http\Controllers\NilaiHafalanController;   
use App\Http\Controllers\JurnalIbadahController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/quran', [QuranController::class, 'index']);
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/quran', [QuranController::class, 'index'])->name('quran.index');
    Route::get('/quran/{nomor_surah}', [QuranController::class, 'show'])->name('quran.show');

    // 2. FITUR KHUSUS SANTRI (Spatie Role: santri)
    Route::middleware(['role:santri'])->group(function () {
        Route::get('/setoran', [HafalanSetoranController::class, 'index'])->name('setoran.index');
        Route::get('/setoran/create', [HafalanSetoranController::class, 'create'])->name('setoran.create');
        Route::post('/setoran', [HafalanSetoranController::class, 'store'])->name('setoran.store');
    });

    // 3. FITUR KHUSUS GURU (Spatie Role: guru)
    Route::middleware(['role:guru'])->group(function () {
        Route::get('/penilaian', [NilaiHafalanController::class, 'index'])->name('penilaian.index');
        Route::post('/penilaian/{id}', [NilaiHafalanController::class, 'store'])->name('penilaian.store');

    Route::middleware(['auth'])->group(function () {
    Route::get('/jurnal', [JurnalIbadahController::class, 'index'])->name('jurnal.index');
    Route::post('/jurnal', [JurnalIbadahController::class, 'store'])->name('jurnal.store');
    });
    });
});

require __DIR__.'/auth.php';