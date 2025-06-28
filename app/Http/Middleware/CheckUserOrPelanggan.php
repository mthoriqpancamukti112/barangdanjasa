<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserOrPelanggan
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('web')->check() || Auth::guard('pelanggan')->check()) {
            return $next($request);
        }

        return redirect()->route('pelanggan.login.form')->with('error', 'Anda harus login terlebih dahulu.');
    }
}
