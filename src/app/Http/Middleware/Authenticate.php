<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Check the route's guards from the matching route
        $routeGuards = isset($request->route()->middleware) ? $request->route()->middleware() : [];
        
        // If route requires auth:user, redirect to user login
        if (in_array('auth:user', $routeGuards)) {
            return route('user.login');
        }
        
        // If route requires auth:admin, redirect to admin login
        if (in_array('auth:admin', $routeGuards)) {
            return route('admin.login');
        }

        // Default: redirect to user login
        return route('user.login');
    }
}
