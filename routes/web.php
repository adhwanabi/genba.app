<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenbaController;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/form', [GenbaController::class, 'index'])->name('form');
Route::get('/bod', [GenbaController::class, 'bod'])->name('bod');
