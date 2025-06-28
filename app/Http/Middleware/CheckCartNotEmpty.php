<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KeranjangProduk;
use Symfony\Component\HttpFoundation\Response;

class CheckCartNotEmpty
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah pengguna sudah login
        if (Auth::check()) {

            // Ambil keranjang belanja pengguna yang sedang login
            $keranjang = KeranjangProduk::where('user_id', Auth::id())->get();

            // Jika keranjang kosong, redirect dengan pesan error
            if ($keranjang->isEmpty()) {
                return redirect()->route('keranjang.pesanan.index')->with('error', 'Keranjang belanja Anda kosong.');
            }
        }

        return $next($request);
    }
}
