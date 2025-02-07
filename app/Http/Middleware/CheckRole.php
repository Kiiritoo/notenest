<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $user = auth()->user();
        
        foreach ($roles as $role) {
            if ($role === 'super_admin' && $user->isSuperAdmin()) {
                return $next($request);
            }
            if ($role === 'admin' && ($user->isAdmin() || $user->isSuperAdmin())) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized action.');
    }
} 