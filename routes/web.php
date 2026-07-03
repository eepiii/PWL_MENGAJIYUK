<?php

use App\Http\Controllers\ProfileController; 
use App\Http\Controllers\HafalanSetoranController;
use App\Http\Controllers\QuranController;
use App\Http\Controllers\NilaiHafalanController;   
use App\Http\Controllers\JurnalIbadahController;
use Illuminate\Support\Facades\Route;

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

    // --- ROUTE BERSAMA (Bisa diakses Guru & Santri) ---
    Route::get('/setoran', [HafalanSetoranController::class, 'index'])->name('setoran.index');
    Route::get('/setoran/{setoran}', [HafalanSetoranController::class, 'show'])->name('setoran.show');

    // --- FITUR KHUSUS SANTRI ---
    // Menggunakan check kondisi biasa agar tidak bergantung pada package Spatie yang belum di-migrate
    Route::middleware(function ($request, $next) {
        if (auth()->user()->role !== 'santri') {
            abort(403, 'Unauthorized action.');
        }
        return $next($request);
    })->group(function () {
        Route::get('/setoran/create', [HafalanSetoranController::class, 'create'])->name('setoran.create');
        Route::post('/setoran', [HafalanSetoranController::class, 'store'])->name('setoran.store');
        Route::get('/setoran/progress', [HafalanSetoranController::class, 'progress'])->name('setoran.progress');
    });

    // --- FITUR KHUSUS GURU ---
    Route::middleware(function ($request, $next) {
        if (auth()->user()->role !== 'guru') {
            abort(403, 'Unauthorized action.');
        }
        return $next($request);
    })->group(function () {
        Route::get('/penilaian', [NilaiHafalanController::class, 'index'])->name('penilaian.index');
        Route::post('/penilaian/{id}', [NilaiHafalanController::class, 'store'])->name('penilaian.store');
        
        Route::get('/setoran/{setoran}/nilai/create', [NilaiHafalanController::class, 'create'])->name('nilai.create');
        Route::post('/setoran/{setoran}/nilai', [NilaiHafalanController::class, 'store'])->name('nilai.store');
    });

}); 

require __DIR__.'/auth.php';