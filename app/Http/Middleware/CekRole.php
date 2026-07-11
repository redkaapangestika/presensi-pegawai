<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CekRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Tambahkan guard('user') di sini agar Laravel tahu pintu mana yang dicek
        if (Auth::guard('user')->check() && in_array(Auth::guard('user')->user()->role, $roles)) {
            return $next($request);
        }

        // Jika tidak punya akses
        return redirect('/panel/dashboardadmin')->with(['warning' => 'Anda tidak memiliki hak akses ke halaman ini!']);
    }
}