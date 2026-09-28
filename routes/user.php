<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\VaultController;

Route::prefix('/user')->middleware('sessionCheck')->controller(VaultController::class)->group( function() {
    Route::get('/dashboard', [VaultController::class, 'index'])->name('vault.index');
});