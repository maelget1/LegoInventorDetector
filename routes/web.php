<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\scanController;
use App\Http\Controllers\baseController;

Route::get('/', [baseController::class, 'home'])->name('home');

Route::post('submit', [scanController::class, 'submit'])->name('submit');

Route::get('inventaire', [baseController::class, 'inventaire'])->name('inventaire');

Route::post('/update-piece-count', [baseController::class, 'updatePieceCount'])->name('update-piece-count');

Route::post('/search-description', [scanController::class, 'searchDescription'])->name('search-description');

Route::post('remove-item', [scanController::class, 'removeItem'])->name('remove-item');

Route::post('add-item', [scanController::class, 'addItem'])->name('add-item');