<?php

namespace App\Http\Controllers;

use App\DTO\UserProfileDTO;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Google\Service\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function create()
    {
        return view('pages.auth.login');
    }

    public function store(LoginRequest $request, AuthService $loginService)
    {
        $dto = new UserProfileDTO(...$request->validated());
        if ($loginService->login($dto))
        {
            $request->session()->regenerate();
            return redirect()->route('profile.dashboard');
        }

        return back()->withInput()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function authGoogleRedirect(AuthService $authService)
    {
        return Socialite::driver('google')
            ->scopes(['email', 'profile'])
            ->redirect();

//        return redirect(
//            $authService->createAuthUrl()
//        );
    }

    /**
     * @throws Exception
     */
    public function authGoogleCallback(Request $request, AuthService $authService)
    {

//        $code = $request->code;
//        $user = $authService->retrieveUserDetails($code);

        $user = Socialite::driver('google')->user();

        $dto = new UserProfileDTO(
            google_id: $user->id,
            google_token: $user->token,
            google_refresh_token: $user->refreshToken ?? null,
            first_name: $user->name,
            avatar: $user->avatar,
            email: $user->email,
        );

        $authService->googleAuth($dto);

        return redirect(route('profile.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
