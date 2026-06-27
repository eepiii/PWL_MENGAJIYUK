<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuranController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/quran', [QuranController::class, 'index'])->name('quran.index');
    Route::get('/quran/{nomor_surah}', [QuranController::class, 'show'])->name('quran.show');

    Route::middleware(['role:santri'])->group(function () {
        // Rute santri nanti di sini
    });

    Route::middleware(['role:guru'])->group(function () {
        // Rute guru nanti di sini
    });
});

require __DIR__.'/auth.php';