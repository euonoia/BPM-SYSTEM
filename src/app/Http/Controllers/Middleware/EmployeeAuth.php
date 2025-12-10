<?php

namespace App\Http\Middleware;

use Closure;

class EmployeeAuth
{
    public function handle($request, Closure $next)
    {
        if (!session()->has('employee_id')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
