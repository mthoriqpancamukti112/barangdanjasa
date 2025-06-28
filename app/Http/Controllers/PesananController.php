<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        // Mengambil semua pesanan untuk pengguna yang sedang login
        if (Auth::guard('pelanggan')->check()) {
            // Jika yang login adalah pelanggan, ambil keranjang belanja miliknya
            $pemesanans = Pemesanan::where('pelanggan_id', Auth::guard('pelanggan')->id())->orderBy('created_at', 'desc')->get();
        } else if (Auth::check()) {
            // Jika yang login adalah admin, ambil keranjang belanja berdasarkan user_id
            $pemesanans = Pemesanan::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        }

        return view('detail-pemesanan', compact('pemesanans'));
    }

    public function updateSelesai($id)
    {
        // Temukan data pemesanan berdasarkan ID
        $pemesanan = Pemesanan::findOrFail($id);

        // Pastikan pemesanan ditemukan
        if ($pemesanan) {
            // Update status pemesanan menjadi "Selesai"
            $pemesanan->status = 'Selesai';
            $pemesanan->save();

            // Redirect kembali ke halaman detail pemesanan dengan pesan sukses
            return redirect()->route('detail.pemesanan.index', ['id' => $id])->with('success', 'Status pemesanan berhasil diupdate menjadi Selesai.');
        }

        // Redirect kembali ke halaman detail pemesanan dengan pesan error jika pemesanan tidak ditemukan
        return redirect()->route('detail.pemesanan.index', ['id' => $id])->with('error', 'Pemesanan tidak ditemukan.');
    }
}
