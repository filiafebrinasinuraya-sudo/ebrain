<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // kalau belum login
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userRole = Auth::user()->role;

        // kalau role tidak cocok
        if (!in_array($userRole, $roles, true)) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}