<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class CheckUserType
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->usertype == '1' || $user->usertype == '2') {
                // User is admin
                return $next($request);
            }
        }

        return $next($request);
    }
}
