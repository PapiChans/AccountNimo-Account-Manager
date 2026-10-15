<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\VaultController;
use App\Http\Controllers\user\CategoriesController;
use App\Http\Controllers\user\LogsController;
use App\Http\Controllers\user\AccountController;

Route::prefix('/user')->middleware('sessionCheck')->controller(VaultController::class)->group( function() {
    Route::get('/dashboard', 'index')->name('vault.index');
    Route::post('/vault/store', 'store')->name('vault.store');
    Route::post('/vault/update', 'update')->middleware('ownerCheck:vault,vault_id')->name('vault.update');
    Route::delete('/vault/delete/{vault_id}', 'delete')->middleware('ownerCheck:vault,vault_id')->name('vault.delete');
});

Route::prefix('/user/vault')->middleware('sessionCheck')->controller(CategoriesController::class)->group( function () {
    Route::get('{vault_id}', 'index')->middleware('ownerCheck:vault,vault_id')->name('categories.index');
    Route::post('/category/store', 'store')->middleware('ownerCheck:vault,vault_id')->name('categories.store');
    Route::post('/category/update', 'update')->middleware('ownerCheck:category,category_id')->name('categories.update');
    Route::delete('/category/delete/{category_id}', 'delete')->middleware('ownerCheck:category,category_id')->name('category.delete');
});

Route::prefix('/user/category')->middleware('sessionCheck')->controller(AccountController::class)->group( function() {
    Route::get('view/{category_id}', 'index')->middleware('ownerCheck:category,category_id')->name('account.index');
});

Route::prefix('/user')->middleware('sessionCheck')->controller(LogsController::class)->group( function() {
    Route::get('/logs', 'index')->name('logs.index');
});