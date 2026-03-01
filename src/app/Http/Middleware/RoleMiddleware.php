<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Accepts comma-separated role names; admin guard bypasses check.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // admin users can always proceed
        if (auth()->guard('admin')->check()) {
            return $next($request);
        }

        // only apply to user guard
        if (!auth()->guard('user')->check()) {
            abort(403, 'Unauthorized.');
        }

        $user = auth()->guard('user')->user();
        if (!$user) {
            abort(403, 'Unauthorized.');
        }

        if (! in_array($user->role, $roles)) {
            abort(403, 'Insufficient permissions.');
        }

        return $next($request);
    }
}
