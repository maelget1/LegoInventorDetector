<?php
/*
ETML
Auteur: Maël Gétain
Date: 21.05.2025
Description: Routes de l'application
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\scanController;
use App\Http\Controllers\baseController;
use App\Http\Controllers\listController;

Route::get('/', [baseController::class, 'home'])->name('home');

Route::post('submit', [scanController::class, 'submit'])->name('submit');

Route::get('inventaire', [listController::class, 'showInventory'])->name('inventaire');

Route::post('/update-piece-count', [scanController::class, 'updatePieceCount'])->name('update-piece-count');

Route::post('/search-description', [scanController::class, 'searchDescription'])->name('search-description');

Route::post('remove-item', [scanController::class, 'removeItem'])->name('remove-item');

Route::post('add-item', [scanController::class, 'addItem'])->name('add-item');

Route::post('inventory', [listController::class, 'inventory'])->name('inventory');

Route::get('verify/{id}', [listController::class, 'verify']);

Route::post('verify-submit', [scanController::class, 'verifySubmit'])->name('verify-submit');

Route::post('check', [listController::class, 'check'])->name('check');

Route::get('delete/{id}', [listController::class, 'delete']);