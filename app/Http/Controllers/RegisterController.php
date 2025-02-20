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
        $dto = new UserRegisterDTO(...$request->validated());
        $authService->register($dto);

        return redirect(route('profile.dashboard'));
    }
}
