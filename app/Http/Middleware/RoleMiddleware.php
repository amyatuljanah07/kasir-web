<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Split roles jika ada multiple roles (dipisah dengan |)
        $allowedRoles = explode('|', $role);
        
        // Cek apakah user punya relasi role dan nama role ada di daftar allowed roles
        if (!auth()->user()->role || !in_array(auth()->user()->role->name, $allowedRoles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }

        return $next($request);
    }
}
