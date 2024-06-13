<?php
use App\Http\Controllers\SocialLoginController;
use Illuminate\Support\Facades\Route;


Route::get('auth/{provider}/redirect', [SocialLoginController::class , 'redirect'])->name('redirect');
Route::get('auth/{provider}/callback', [SocialLoginController::class , 'callback'])->name('callback');
