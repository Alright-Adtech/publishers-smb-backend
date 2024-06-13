<?php

namespace App\Http\Controllers;

use App\Services\SocialLoginService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;
use Laravel\Socialite\Facades\Socialite;


class SocialLoginController extends Controller
{
  protected SocialLoginService $service;

  public function __construct(SocialLoginService $service)
  {
    $this->service = $service;
  }

  public function redirect(String $provider): RedirectResponse
  {
    return Socialite::driver($provider)->redirect();
  }

  public function callback(String $provider): RedirectResponse
  {
    $token = $this->service->generateTokenByProvider($provider);
    $cookie = Cookie::make("laravel_token", $token);
    return redirect(env('GOOGLE_FRONT_REDIRECT'))->withCookie($cookie);
  }
}
