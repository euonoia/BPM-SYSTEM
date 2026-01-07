<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Authenticate;
use App\Models\core1\User as Core1User;

class MultiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated via default auth
        if (auth()->check()) {
            return $next($request);
        }

        // Check if Core1User is in session
        $core1UserId = $request->session()->get('core1_user_id');
        if ($core1UserId) {
            $core1User = Core1User::find($core1UserId);
            if ($core1User) {
                // Set the user in auth so other parts of the app can access it
                auth()->setUser($core1User);
                return $next($request);
            }
        }

        // No user found, redirect to login
        return redirect()->route('login');
    }
}

