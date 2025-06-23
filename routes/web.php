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


    // AJAX PAGINATION
    Route::get('/bod/repair/data',[GenbaController::class, 'bodRepairData'])->name('bod.repair.data');
    Route::get('/bod/data', [GenbaController::class, 'bodData'])->name('bod.data');

    // FORM SUBMIT DELETE
    Route::post('/form-answer', [GenbaController::class, 'update'])->name('form-answer.update');
    Route::get('/form/repair/{id}', [GenbaController::class, 'repair'])->name('form.repair');
    Route::post('/form/repair/{id}', [GenbaController::class, 'repairUpdate'])->name('form.repair.update');
    Route::post('/form/repair/delete/{id}', [GenbaController::class, 'deleteRepair'])->name('bod.repair.delete');
    Route::post('/form-answer/delete/{id}', [GenbaController::class, 'delete'])->name('form-answer.delete');

    Route::post('/export', [ExportReportController::class, 'export'])->name('export');
});

Route::get('/dashboard',[GenbaController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');