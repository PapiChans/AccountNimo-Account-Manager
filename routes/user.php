<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\VaultController;
use App\Http\Controllers\user\CategoriesController;
use App\Http\Controllers\user\LogsController;
use App\Http\Controllers\user\AccountController;
use App\Http\Controllers\user\TrashController;
use App\Http\Controllers\user\AccountLinkController;

Route::prefix('/user')->middleware('sessionCheck')->controller(VaultController::class)->group( function() {
    Route::get('/dashboard', 'index')->name('vault.index');
    Route::post('/vault/store', 'store')->name('vault.store');
    Route::post('/vault/update', 'update')->middleware('ownerCheck:vault,edit_id')->name('vault.update');
    Route::delete('/vault/delete/{vault_id}', 'delete')->middleware('ownerCheck:vault,vault_id')->name('vault.delete');
});

Route::prefix('/user/vault')->middleware('sessionCheck')->controller(CategoriesController::class)->group( function () {
    Route::get('{vault_id}', 'index')->middleware('ownerCheck:vault,vault_id')->name('categories.index');
    Route::post('/category/store', 'store')->middleware('ownerCheck:vault,vault_id')->name('categories.store');
    Route::post('/category/update', 'update')->middleware('ownerCheck:category,edit_id')->name('categories.update');
    Route::delete('/category/delete/{category_id}', 'delete')->middleware('ownerCheck:category,category_id')->name('category.delete');
});

Route::prefix('/user/category')->middleware('sessionCheck')->controller(AccountController::class)->group( function() {
    Route::get('/view/{category_id}', 'index')->middleware('ownerCheck:category,category_id')->name('account.index');
    Route::post('/account/store', 'store')->middleware('ownerCheck:category,category_id')->name('account.store');
    Route::post('/account/update', 'update')->middleware('ownerCheck:account,edit_id')->name('account.update');
    Route::delete('/account/delete/{account_id}', 'delete')->middleware('ownerCheck:account,account_id')->name('account.delete');
    Route::post('/account/verify', 'verifyPassword')->middleware('ownerCheck:account,verify_account_id')->name('account.verify.password');
});

Route::prefix('/user/trash')->middleware('sessionCheck')->controller(TrashController::class)->group( function() {
    Route::get('index', 'index')->name('trash.index');
    Route::delete('bulkDelete', 'bulkDelete')->name('trash.bulkDelete');
    Route::get('restore/{account_id}', 'restore')->name('trash.restore');
    Route::delete('delete/{account_id}', 'delete')->name('trash.delete');
});

Route::prefix('/user/account')->middleware('sessionCheck')->controller(AccountLinkController::class)->group( function() {
    Route::get('/view/{account_id}', 'index')->middleware('ownerCheck:account,account_id')->name('account.link.index');
    Route::post('/store', 'store')->middleware('ownerCheck:account,account_id')->name('account.link.store');
    Route::delete('/delete/{account_id}/{link_id}', 'delete')->middleware('ownerCheck:account,account_id')->name('account.link.delete');
});

Route::prefix('/user')->middleware('sessionCheck')->controller(LogsController::class)->group( function() {
    Route::get('/logs', 'index')->name('logs.index');
});