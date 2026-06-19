<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // Superadmin always has access
        if ($user->role === 'superadmin') {
            return $next($request);
        }

        // Check if user's role is in the allowed roles
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // If the user is a customer, always redirect to catalog if they hit an unauthorized admin route
        if ($user->role === 'customer') {
            return redirect()->route('catalog.index');
        }

        abort(403, 'Anda tidak memiliki hak akses (Role: ' . strtoupper($user->role) . ') untuk halaman ini.');
    }
}
