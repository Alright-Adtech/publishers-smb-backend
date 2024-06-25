<?php

use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['cors', 'auth:api'])->group(function () {
  Route::get('/user', [UserController::class, 'get'])->name('user.get');
  Route::put('/user', [UserController::class, 'set'])->name('user.set');
});

Route::get('/auth/decrypt/{token}', [SocialLoginController::class , 'decryptToken'])->name('auth.provider.decryptToken');