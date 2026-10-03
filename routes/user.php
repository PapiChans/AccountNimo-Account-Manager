<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\VaultController;
use App\Http\Controllers\user\LogsController;

Route::prefix('/user')->middleware('sessionCheck')->controller(VaultController::class)->group( function() {
    Route::get('/dashboard', 'index')->name('vault.index');
    Route::post('/vault/store', 'store')->name('vault.store');
    Route::post('/vault/update', 'update')->name('vault.update');
    Route::delete('/vault/delete/{vault_id}', 'delete')->name('vault.delete');
});

Route::prefix('/user')->middleware('sessionCheck')->controller(LogsController::class)->group( function() {
    Route::get('/logs', 'index')->name('logs.index');
});