<?php

namespace App\Services;

use App\Models\User;
use App\Models\LinkedSocialAccount;
use Illuminate\Support\Str;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialLoginService extends Service
{
  public function generateTokenByProvider($provider): String
  {
    $providerUser = Socialite::driver($provider)->user();
    $user = $this->findOrCreateUser($providerUser, $provider);

    auth()->login($user);
    if (auth()->check()) {
      return $user->createToken('API Token')->accessToken;
    }

    throw new UnauthorizedException('Não autorizado');
  }

  protected function findOrCreateUser(ProviderUser $providerUser, string $provider): User
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

      return $user;
    }
  }
}
