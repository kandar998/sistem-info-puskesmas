<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Cek apakah user memiliki role yang dimaksud
        if (!$request->user()->hasRole($role)) {
            abort(403, 'Unauthorized access. You need ' . $role . ' role.');
        }

        return $next($request);
    }
}
