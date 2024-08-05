<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSubscriptionIsPaidNonAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $hash = explode('/', request()->path());
        $hash = $hash[1];

        $user = User::where('user_hash', $hash)->firstOrFail();

        if ($user->is_subscribed && $user->trial_expiration_time->gt(now())){
            return $next($request);
        }

        if ($user->is_subscribed && !is_null($user->expiration_time) && $user->expiration_time->gt(now())){
            return $next($request);
        }

        abort(404);
    }
}
