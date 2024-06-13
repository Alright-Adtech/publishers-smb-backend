<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
// use App\Http\Requests\api\auth\SocialLoginRequest;
use Illuminate\Http\Request;
use App\Models\LinkedSocialAccount;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Cookie;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as ProviderUser;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class SocialLoginController extends Controller
{
  public function redirect($provider)
  {
    return Socialite::driver($provider)->redirect();
  }

  public function callback($provider)
  {
    try {
      $providerUser = Socialite::driver($provider)->user();
      $user = $this->findOrCreate($providerUser, $provider);

      auth()->login($user);
      if (auth()->check()) {
        $token = auth()->user()->createToken('API Token')->accessToken;
      } else {
        return $this->error(
          message: 'Failed to Login try again',
          code: 401
        );
      }
  
      $cookie = Cookie::make("laravel_token", $token);
      return redirect(env('GOOGLE_FRONT_REDIRECT'))->withCookie($cookie);
    } catch (Exception $exception) {
      return response()->json([
        'message' => $exception->getMessage(),
      ]);
    }
  }

  public function login(Request $request)
  {
    try {
      $accessToken = $request->get('access_token');
      $provider = $request->get('provider');
      $providerUser = Socialite::driver($provider)->userFromToken($accessToken);
    } catch (Exception $exception) {
      return response()->json([
        'message' => $exception->getMessage(),
      ]);
    }

    if (filled($providerUser)) {
      $user = $this->findOrCreate($providerUser, $provider);
    } else {
      $user = $providerUser;
    }

    auth()->login($user);
    if (auth()->check()) {
      return response()->json([
        'token' => auth()->user()->createToken('API Token')->accessToken
      ]);
    } else {
      return $this->error(
        message: 'Failed to Login try again',
        code: 401
      );
    }
  }


  protected function findOrCreate(ProviderUser $providerUser, string $provider)
  {
    $linkedSocialAccount = LinkedSocialAccount::query()->where('provider_name', $provider)
      ->where('provider_id', $providerUser->getId())
      ->first();

    if ($linkedSocialAccount) {
      return $linkedSocialAccount->user;
    } else {
      $user = null;

      if ($email = $providerUser->getEmail()) {
        $user = User::query()->where('email', $email)->first();
      }

      if (!$user) {
        $user = User::query()->create([
          'name' => $providerUser->getName(),
          'email' => $providerUser->getEmail(),
          'password' => Str::random(8),
        ]);
        $user->markEmailAsVerified();
      }

      $user->linkedSocialAccounts()->create([
        'provider_id' => $providerUser->getId(),
        'provider_name' => $provider,
      ]);

      // return $user;
      return $providerUser;
    }
  }
}
