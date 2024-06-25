<?php

use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSegmentController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\WebsiteSegmentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['cors', 'auth:api'])->group(function () {
  Route::get('/user', [UserController::class, 'get'])->name('user.get');
  Route::put('/user', [UserController::class, 'set'])->name('user.set');

  Route::post('/websites', [WebsiteController::class, 'new'])->name('website.new');
  Route::put('/websites/{id}', [WebsiteController::class, 'set'])->name('website.set');

  Route::get('/user-segments/', [UserSegmentController::class, 'index'])->name('user-segments.index');

  Route::get('/website-segments/', [WebsiteSegmentController::class, 'index'])->name('website-segments.index');
});

Route::get('/auth/decrypt/{token}', [SocialLoginController::class , 'decryptToken'])->name('auth.provider.decryptToken');