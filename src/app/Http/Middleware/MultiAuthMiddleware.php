<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MultiAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Core authentication (PRIMARY)
        if (Auth::guard('core')->check()) {
            Auth::shouldUse('core');
            return $next($request);
        }

        // Optional: future guards can go here
        // if (Auth::guard('employee')->check()) {
        //     Auth::shouldUse('employee');
        //     return $next($request);
        // }

        return redirect()->route('login');
    }
}