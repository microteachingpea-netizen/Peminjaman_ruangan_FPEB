<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, \Closure $next)
{
    // Cek apakah user sudah login dan apakah rolenya admin
    if (auth()->check() && auth()->user()->isAdmin()) {
        return $next($request);
    }

    return redirect()->route('rooms.index')->with('error', 'Anda tidak memiliki hak akses ke halaman Admin.');
}
}
