<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\VaultController;
use App\Http\Controllers\user\LogsController;

Route::prefix('/user')->middleware('sessionCheck')->controller(VaultController::class)->group( function() {
    Route::get('/dashboard', 'index')->name('vault.index');
});

Route::prefix('/user')->middleware('sessionCheck')->controller(LogsController::class)->group( function() {
    Route::get('/logs', 'index')->name('logs.index');
});