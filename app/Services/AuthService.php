<?php

namespace App\Services;

use App\DTO\UserProfileDTO;
use App\Models\User;
use Google\Client;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

readonly class AuthService
{
    public function __construct(
        private Client $googleClient
    )
    {
        $this->googleClient->setClientId(config('services.google.client_id'));
        $this->googleClient->setClientSecret(config('services.google.client_secret'));
        $this->googleClient->setRedirectUri(route('auth.google.redirect'));
    }

    public function login(UserProfileDTO $dto): bool
    {
        return Auth::attempt([
            'email' => $dto->email,
            'password' => $dto->password,
        ], (boolean) $dto->remember_me);
    }

    public function register(UserProfileDTO $dto): User
    {
        $user = new User([
            'first_name'=>$dto->first_name,
            'email'=>$dto->email,
            'password'=>$dto->password,
            'avatar'=>$dto->avatar,
            'user_hash'=>substr(strtoupper(hash('sha256', time())), -8),
            'trial_expiration_time'=>now()->addDays((int)config('app.trial_duration')),
            'is_subscribed'=>true
        ]);

        $user->save();

        Auth::login($user, (boolean) $dto->remember_me);
        event(new Registered($user));

        return $user;
    }

    public function googleAuth(UserProfileDTO $dto)
    {
        $user = User::where('email', $dto->email)->first();

        if (!$user){
            $user = User::create([
                'first_name' => $dto->first_name,
                'email' => $dto->email,
                'password' => '',
                'avatar' => $dto->avatar,
                'google_id' => $dto->google_id,
                'google_token' => $dto->google_token,
                'google_refresh_token' => $dto->google_refresh_token,
                'user_hash'=>substr(strtoupper(hash('sha256', time())), -8),
                'trial_expiration_time'=>now()->addDays((int)config('app.trial_duration')),
                'is_subscribed'=>true,
                'email_verified_at'=>now()
            ]);

            Auth::login($user);
            return $user;
        }

        $user->update([
            'google_id' => $dto->google_id,
            'google_token' => $dto->google_token,
            'google_refresh_token' => $dto->google_refresh_token,
        ]);

        Auth::login($user);
        return $user;
    }
}
