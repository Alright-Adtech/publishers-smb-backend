<?php

namespace App\Http\Controllers;

use App\Services\SocialLoginService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
    $cookie = cookie("token", $token, 60 * 24 * 3, null, null, null, false);

    return redirect(env('GOOGLE_FRONT_REDIRECT') . "?token=" . $token)->withCookie($cookie);
  }

  public function decryptToken(Request $request, string $token) {
    $tokenDecrypted = $this->service->decryptToken($token);
  
    return $this->success([
      'token' => $tokenDecrypted,
    ]);
  }
}
