<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::prefix('/')->middleware('guestCheck')->controller(AuthController::class)->group(function() {
    Route::get('/', [AuthController::class, 'index'])->name('index');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login/submit', [AuthController::class, 'loginSubmit'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register/checkEmail', [AuthController::class, 'registerCheckEmail'])->name('register.checkEmail');
    Route::post('/register/store', [AuthController::class, 'registerStore'])->name('register.store');
});
    
Route::prefix('/')->middleware('sessionCheck')->controller(AuthController::class)->group( function() {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});