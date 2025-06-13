<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenbaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExportReportController;

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Routes that require authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/form', [GenbaController::class, 'index'])->name('form');
    Route::post('/form/post', [GenbaController::class, 'form'])->name('form.submit');

    // Only allow users with npk 'ehs' to access /bod
    Route::get('/bod', function () {
        if (auth()->user()->npk === 'ehs') {
            return app(\App\Http\Controllers\GenbaController::class)->bod();
        }
        abort(403, 'Unauthorized');
    })->name('bod');

    Route::post('/export', [ExportReportController::class, 'export'])->name('export');
});
