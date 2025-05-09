<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\scanController;
use App\Http\Controllers\baseController;

Route::get('/', [baseController::class, 'home'])->name('home');

Route::post('submit', [scanController::class, 'submit'])->name('submit');