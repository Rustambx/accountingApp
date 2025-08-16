<?php

use App\Http\Controllers\Api\HistoryController;
use Illuminate\Support\Facades\Route;

Route::get('histories', [HistoryController::class, 'index']);
