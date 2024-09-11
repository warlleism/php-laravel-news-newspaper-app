<?php

use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NewsController::class, 'index'])->name('news.search');
Route::get('/news/{data}', [NewsController::class, 'show'])->name('news.details');
