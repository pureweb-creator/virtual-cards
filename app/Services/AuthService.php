<?php

namespace App\Services;

use App\DTO\UserGoogleAuthDTO;
use App\DTO\UserLoginDTO;
use App\DTO\UserRegisterDTO;
use App\Models\User;
use Google\Client;
use Google\Service\Exception;
use Google\Service\Oauth2;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

readonly class AuthService
{
    public function __construct(
        private Client $googleClient
    )
    {
        $this->googleClient->setClientId(config('services.google.client_id'));
        $this->googleClient->setClientSecret(config('services.google.client_secret'));
        $this->googleClient->setRedirectUri(config('services.google.redirect'));
        $this->googleClient->addScope(['email', 'profile']);
    }

    public function createAuthUrl(): string
    {
        return $this->googleClient->createAuthUrl();
    }

    /**
     * @throws Exception
     */
    public function retrieveUserDetails($code): Oauth2\Userinfo
    {
        $token = $this->googleClient->fetchAccessTokenWithAuthCode($code);
        $this->googleClient->setAccessToken($token);
        $user = new Oauth2($this->googleClient);
        return $user->userinfo->get();
    }

    public function login(UserLoginDTO $dto): bool
    {
        return Auth::attempt([
            'email' => $dto->email,
            'password' => $dto->password,
        ], (boolean) $dto->remember_me);
    }

    public function register(UserRegisterDTO $dto): User
    {
        $user = new User([
            'first_name'=>$dto->first_name,
            'email'=>$dto->email,
            'password'=>$dto->password,
            'user_hash'=>strtoupper(Str::random(10)),
            'trial_expiration_time'=>now()->addDays((int)config('app.trial_duration')),
            'is_subscribed'=>true
        ]);

        $user->save();

        Auth::login($user, (boolean) $dto->remember_me);
        event(new Registered($user));

        return $user;
    }

    public function googleAuth(UserGoogleAuthDTO $dto)
    {
        $user = User::where('email', $dto->email)->first();

        if (!$user){
            $user = User::create([
                'first_name' => $dto->first_name,
                'email' => $dto->email,
                'password' => '',
                'avatar' => $dto->avatar,
                'google_id' => $dto->id,
                'google_token' => $dto->token,
                'google_refresh_token' => $dto->refresh_token,
                'user_hash'=>strtoupper(Str::random(10)),
                'trial_expiration_time'=>now()->addDays((int)config('app.trial_duration')),
                'is_subscribed'=>true,
                'email_verified_at'=>now()
            ]);

            Auth::login($user, true);
            return $user;
        }

        $user->update([
            'google_id' => $dto->id,
            'google_token' => $dto->token,
            'google_refresh_token' => $dto->refresh_token,
        ]);

        Auth::login($user, true);

        return $user;
    }
}
