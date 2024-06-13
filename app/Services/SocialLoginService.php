<?php

namespace App\Services;

use App\Models\User;
use App\Models\LinkedSocialAccount;
use Illuminate\Support\Facades\Hash;
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
    $socialAccountAlreadyLinked = $linkedSocialAccount !== null;
    if ($socialAccountAlreadyLinked) {
      return $linkedSocialAccount->user;
    }

    $user = null;
    $email = $providerUser->getEmail();
    if ($email) {
      $user = User::query()->where('email', $email)->first();
    }
    
    $userWasNotFound = !$user;
    if ($userWasNotFound) {
      $user = User::query()->create([
        'name' => $providerUser->getName(),
        'email' => $providerUser->getEmail(),
        'password' => Hash::make(Str::random(16)),
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
