<?php

use App\Http\Controllers\SocialLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['cors', 'auth:api'])->group(function () {
  Route::get('/user', function (Request $request) {
    return response()->json([
      'user' => $request->user(),
      // 'user' => $request->header('Authorization'),
    ]);
  });
});

Route::get('/auth/decrypt/{token}', [SocialLoginController::class , 'decryptToken'])->name('auth.provider.decryptToken');