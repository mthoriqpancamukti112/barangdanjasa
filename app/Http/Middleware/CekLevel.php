<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekLevel
{
    public function handle(Request $request, Closure $next, ...$levels): Response
    {
        Session::put('previous_url', url()->previous());

        if (Auth::check()) {
            if (in_array(Auth::user()->hak_akses, $levels)) {
                return $next($request);
            }
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
        return redirect('/login');
    }
}
