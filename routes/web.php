<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

Route::get('dashboard', [DashboardController::class, 'index'])
    ->name('admin.dashboard')
    ->prefix('admin')
    ->middleware(['auth']);

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('histories', HistoryController::class)->except(['show']);
});

require __DIR__.'/auth.php';
