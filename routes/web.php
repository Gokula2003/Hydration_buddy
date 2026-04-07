<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HydrationController;

// Loading screen
Route::get('/', [HydrationController::class, 'welcome'])->name('welcome');

// Dashboard
Route::get('/dashboard', [HydrationController::class, 'dashboard'])->name('dashboard');

// API endpoints
Route::post('/api/add-glass', [HydrationController::class, 'addGlass'])->name('api.add-glass');
Route::get('/api/today', [HydrationController::class, 'getTodayData'])->name('api.today');
Route::get('/api/yesterday', [HydrationController::class, 'getYesterdayData'])->name('api.yesterday');
