<?php

namespace App\Library\Services;

use App\Library\Services\Contracts\SocialServiceInterface;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class SocialService implements SocialServiceInterface
{
    public function redirectToProvider($driver)
    {
        return Socialite::driver($driver);
    }

    public function handleProviderCallback($driver,$redirectPath)
    {
        try {
            $user = Socialite::driver($driver)->user();
        } catch (\Exception $e) {
            return '';
        }

        $existingUser = User::where('email', $user->getEmail())->first();
        if ($existingUser) {
            auth()->login($existingUser, true);
            return '';
        } else {
            $newUser                    = new User;
            $newUser->provider_name     = $driver;
            $newUser->provider_id       = $user->getId();
            $newUser->name              = $user->getName();
            $newUser->email             = $user->getEmail();
            $newUser->email_verified_at = now();
            $newUser->save();

            auth()->login($newUser, true);
        }

        return $redirectPath;
    }
}
