<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsPenjaga
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isPenjaga()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Penjaga Stand.');
        }

        return $next($request);
    }
}
