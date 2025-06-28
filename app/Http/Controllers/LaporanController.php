<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Penyewaan;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $pemesanans = Pemesanan::orderBy('created_at', 'desc')->get();
        return view('admin.laporanpesanan.index', compact('pemesanans'));
    }

    public function pemesananReportPdf()
    {
        $pemesanans = Pemesanan::orderBy('created_at', 'desc')->get();
        $totalBayarSemua = Pemesanan::sum('total_harga');

        // Konversi gambar ke base64
        $path = public_path('img/logo.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.laporanpesanan.order-pdf', compact('pemesanans', 'totalBayarSemua', 'base64'));
        return $pdf->download('laporan_pemesanan.pdf');
    }

    public function indexsewa()
    {
        $penyewaans = Penyewaan::orderBy('created_at', 'desc')->get();
        return view('admin.laporanpenyewaan.index', compact('penyewaans'));
    }

    public function penyewaanReportPdf()
    {
        $penyewaans = Penyewaan::orderBy('created_at', 'desc')->get();
        $totalBayarSemua = Penyewaan::sum('total_harga');

        // Konversi gambar ke base64
        $path = public_path('img/logo.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.laporanpenyewaan.sewa-pdf', compact('penyewaans', 'totalBayarSemua', 'base64'));
        return $pdf->download('laporan_penyewaan.pdf');
    }
}