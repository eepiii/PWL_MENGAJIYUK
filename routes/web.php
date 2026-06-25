<?php

use App\Http\Controllers\ProfileController; // <-- TAMBAHKAN INI
use App\Http\Controllers\QuranController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuranController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Utama (Landing Page)
Route::get('/', function () {
    return view('welcome');
});

Route::get('/quran', [QuranController::class, 'index']);

Route::get('/quran/{nomor}', [QuranController::class, 'detail']);
