<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Check if user role is allowed
        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, "You don't have permission to access this page.");
        }

        return $next($request);
    }
}
