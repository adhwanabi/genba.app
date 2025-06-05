<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenbaController;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/form', [GenbaController::class, 'index'])->name('form');
Route::post('/form/post', [GenbaController::class, 'form'])->name('form.submit');
Route::get('/bod', [GenbaController::class, 'bod'])->name('bod');
