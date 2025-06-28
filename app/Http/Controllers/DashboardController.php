<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Pemesanan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlah_pelanggan = Pelanggan::count();
        $jumlah_user = User::count();
        $jumlah_produk = Barang::count();
        $jumlah_pesanan = Pemesanan::count();

        return view("admin.dashboard", compact('jumlah_pelanggan', 'jumlah_user', 'jumlah_produk', 'jumlah_pesanan'));
    }
}
