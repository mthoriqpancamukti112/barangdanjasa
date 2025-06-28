<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if ($guard === 'admin' && Auth::guard($guard)->check()) {
            return redirect()->route('admin.dashboard');
        }

        if ($guard === 'pelanggan' && Auth::guard($guard)->check()) {
            return redirect()->route('beranda.index');
        }

        return $next($request);
    }
}
