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

    return new RedirectResponse(env('GOOGLE_FRONT_REDIRECT'))->withCookie($cookie);
  }

  /**
   * @OA\Post(
   *  path="/api/auth/decrypt",
   *  summary="Descriptografa token de autenticação.",
   *  tags={"Auth"},
   *  @OA\RequestBody(
   *   required=true,
   *   @OA\MediaType(
   *    mediaType="application/json",
   *    @OA\Schema(
   *     @OA\Property(property="token", type="string", description="Token criptografado.")
   *    )
   *   )
   *  ),
   *  @OA\Response(
   *   response="200", description="Sucesso", @OA\JsonContent()
   *  ),
   * )
   */
  public function decryptToken(Request $request)
  {
    $request->validate([
      'token' => 'required|string',
    ]);
    $token = $request->input('token');
    $tokenDecrypted = $this->service->decryptToken($token);

    return $this->success([
      'token' => $tokenDecrypted,
    ]);
  }
}
