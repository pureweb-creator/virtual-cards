<?php

namespace App\Http\Controllers;

use App\DTO\UserRegisterDTO;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;

class RegisterController extends Controller
{
    public function create()
    {
        return view('pages.auth.register');
    }

    public function store(RegisterRequest $request, AuthService $authService)
    {
        $data = $request->validated();
        $dto = new UserRegisterDTO(
            first_name: $data['first_name'],
            email: $data['email'],
            password: $data['password'],
            remember_me: isset($data['remember_me']) ? (bool) $data['remember_me'] : null,
        );
        $authService->register($dto);

        return redirect(route('profile.dashboard'));
    }
}
