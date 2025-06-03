<?php

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'registerForm']);
Route::post('/', [AuthController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('/home/{token}', [AppController::class, 'home'])->name('home');
    Route::post('/new-token', [AppController::class, 'createNewToken'])->name('new-token');
    Route::post('/deactivate-token', [AppController::class, 'deactivateToken'])->name('deactivate-token');
    Route::post('/imfeelinglucky', [AppController::class, 'imfeelinglucky'])->name('imfeelinglucky');
    Route::get('/history/{token}', [AppController::class, 'history'])->name('history');
});
