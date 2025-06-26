<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenbaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExportReportController;
use App\Http\Controllers\GenbaEventController;

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes that require authentication
Route::middleware(['auth'])->group(function () {
    // Semua user authenticated bisa akses ini
    Route::get('/form', [GenbaController::class, 'index'])->name('form');
    Route::post('/form/post', [GenbaController::class, 'form'])->name('form.submit');

    // Hanya user dengan npk 'ehs' yang bisa akses route berikut
    Route::middleware(['ehs.user'])->group(function () {
        Route::get('/bod', [GenbaController::class, 'bod'])->name('bod');
        Route::get('/bod/repair/data', [GenbaController::class, 'bodRepairData'])->name('bod.repair.data');
        Route::get('/bod/data', [GenbaController::class, 'bodData'])->name('bod.data');
        Route::post('/form-answer', [GenbaController::class, 'update'])->name('form-answer.update');
        Route::get('/form/repair/{id}', [GenbaController::class, 'repair'])->name('form.repair');
        Route::post('/form/repair/{id}', [GenbaController::class, 'repairUpdate'])->name('form.repair.update');
        Route::post('/form/repair/delete/{id}', [GenbaController::class, 'deleteRepair'])->name('bod.repair.delete');
        Route::post('/form-answer/delete/{id}', [GenbaController::class, 'delete'])->name('form-answer.delete');
        Route::post('/export', [ExportReportController::class, 'export'])->name('export');
        Route::get('/genba/add', [GenbaController::class, 'addGenba'])->name('genba.add');
        Route::get('/dashboard', [GenbaController::class, 'dashboard'])->name('dashboard');

        // Genba Event Routes
        Route::prefix('genba-event')->group(function () {
            // Tampilan utama
            Route::get('/', [GenbaEventController::class, 'index'])->name('genba-event.index');
            Route::get('/create', [GenbaEventController::class, 'create'])->name('genba-event.create');

            // API Endpoints untuk AJAX
            Route::post('/', [GenbaEventController::class, 'store'])->name('genba-event.store');
            Route::get('/calendar', [GenbaEventController::class, 'calendarEvents'])->name('genba-event.calendar');
            Route::get('/list', [GenbaEventController::class, 'eventList'])->name('genba-event.list');
            Route::get('/{genbaEvent}/edit', [GenbaEventController::class, 'edit'])->name('genba-event.edit');
            Route::put('/{genbaEvent}', [GenbaEventController::class, 'update'])->name('genba-event.update');
            Route::delete('/{genbaEvent}', [GenbaEventController::class, 'destroy'])->name('genba-event.destroy');
        });
    });
});
