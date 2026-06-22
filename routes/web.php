<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuranController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/quran', [QuranController::class, 'index']);

Route::get('/quran/{nomor}', [QuranController::class, 'detail']);