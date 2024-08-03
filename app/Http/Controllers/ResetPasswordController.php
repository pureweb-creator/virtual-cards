<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequestLink;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function create()
    {
        return view('pages.auth.forgot-password');
    }

    public function store(ResetPasswordRequestLink $request)
    {
        $status = Password::sendResetLink($request->validated());

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
}
