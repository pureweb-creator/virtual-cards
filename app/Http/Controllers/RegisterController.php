<?php

namespace App\Http\Controllers;

use App\DTO\UserProfileDTO;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use App\Services\ProfileService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create()
    {
        return view('pages.auth.register');
    }

    public function store(RegisterRequest $request, AuthService $authService)
    {
        $dto = new UserProfileDTO(...$request->validated());
        $authService->register($dto);

        return redirect(route('profile.dashboard'));
    }
}
