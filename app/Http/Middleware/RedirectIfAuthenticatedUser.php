<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticatedUser
{
    public function handle(Request $request, Closure $next)
    {
        // If user is logged in, redirect them
        if (Auth::check()) {
            return redirect()->route('dashboard'); // or any route you want
        }

        // Otherwise, allow them to proceed
        return $next($request);
    }
}
