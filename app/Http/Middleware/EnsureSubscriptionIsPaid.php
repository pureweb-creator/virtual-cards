<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSubscriptionIsPaid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user->is_subscribed && $user->trial_expiration_time->gt(now())){
            return $next($request);
        }

        if ($user->is_subscribed && !is_null($user->expiration_time) && $user->expiration_time->gt(now())){
            return $next($request);
        }

        return redirect(route('pricing'));
    }
}
