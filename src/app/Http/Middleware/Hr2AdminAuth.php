<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Hr2AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->get('hr2_admin_logged_in')) {
            return redirect()->route('hr2.admin.login');
        }

        return $next($request);
    }
}
