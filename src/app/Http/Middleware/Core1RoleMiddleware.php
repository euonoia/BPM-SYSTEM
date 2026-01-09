<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\core1\User as Core1User;

class Core1RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Try to get user from auth first
        $user = auth('core')->user();
        
        // If auth()->user() returns null, try to get from session (for Core1User)
        if (!$user) {
            $core1UserId = $request->session()->get('core1_user_id');
            if ($core1UserId) {
                $user = Core1User::find($core1UserId);
            }
        }
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Check if user has one of the required roles
        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}