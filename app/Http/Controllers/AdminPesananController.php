<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;

class AdminPesananController extends Controller
{
    public function index()
    {
        $pemesanans = Pemesanan::orderBy('created_at', 'desc')->get();
        $hasPembayaran = $pemesanans->contains(function ($pemesanan) {
            return $pemesanan->pembayaran !== null;
        });

        return view('admin.pesanan.index', compact('pemesanans', 'hasPembayaran'));
    }
}
