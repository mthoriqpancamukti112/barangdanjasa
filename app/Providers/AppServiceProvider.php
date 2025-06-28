<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\KeranjangProduk;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Membuat view composer untuk menghitung jumlah item dalam keranjang
        View::composer('*', function ($view) {
            $view->with('jumlah_item_keranjang', $this->getJumlahItemKeranjang());
        });
    }

    // Method untuk menghitung jumlah item dalam keranjang
    private function getJumlahItemKeranjang()
    {
        if (Auth::guard('pelanggan')->check()) {
            // Jika yang login adalah pelanggan, ambil keranjang belanja miliknya
            $jumlah_item_keranjang = KeranjangProduk::where('pelanggan_id', Auth::guard('pelanggan')->id())
                ->sum('jumlah');
        } else if (Auth::check()) {
            // Jika yang login adalah admin, ambil keranjang belanja berdasarkan user_id
            $jumlah_item_keranjang = KeranjangProduk::where('user_id', Auth::id())
                ->sum('jumlah');
        } else {
            $jumlah_item_keranjang = 0;
        }

        return $jumlah_item_keranjang;
    }
}
