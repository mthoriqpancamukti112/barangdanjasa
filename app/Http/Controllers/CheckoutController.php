<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\DetailPemesanan;
use App\Models\KeranjangProduk;
use App\Models\MetodePembayaran;
use App\Models\Pembayaran;
use App\Models\Pengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        if (Auth::guard('pelanggan')->check()) {
            // Jika yang login adalah pelanggan, ambil keranjang belanja miliknya
            $keranjang = KeranjangProduk::where('pelanggan_id', Auth::guard('pelanggan')->id())->get();
        } else if (Auth::check()) {
            // Jika yang login adalah admin, ambil keranjang belanja berdasarkan user_id
            $keranjang = KeranjangProduk::where('user_id', Auth::id())->get();
        }

        // Ambil metode pembayaran yang tersedia
        $metode_pembayaran = MetodePembayaran::all();

        // Hitung total harga dari keranjang belanja
        $total_harga = $keranjang->sum('subtotal');

        return view('checkout', compact('keranjang', 'metode_pembayaran', 'total_harga'));
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'id_metode_pembayaran' => 'required',
            'alamat' => 'required',
        ], [
            'alamat.required' => 'Alamat pengiriman diperlukan.'
        ]);

        // Periksa apakah pengguna sudah memiliki pesanan yang belum selesai
        $existingOrder = Pemesanan::where('pelanggan_id', Auth::guard('pelanggan')->id())
            ->where('status', '<>', 'Selesai')
            ->first();

        if ($existingOrder) {
            return redirect()->back()->with('error', 'Anda sudah memiliki pesanan yang belum selesai. Silakan tunggu pesanan sebelumnya selesai.');
        }

        // Ambil keranjang belanja pengguna yang sedang login
        if (Auth::guard('pelanggan')->check()) {
            // Jika yang login adalah pelanggan, ambil keranjang belanja miliknya
            $keranjang = KeranjangProduk::where('pelanggan_id', Auth::guard('pelanggan')->id())->get();
        } else if (Auth::check()) {
            // Jika yang login adalah admin, ambil keranjang belanja berdasarkan user_id
            $keranjang = KeranjangProduk::where('user_id', Auth::id())->get();
        }

        if ($keranjang->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Hitung total harga dari keranjang belanja
        $total_harga = $keranjang->sum('subtotal');

        // Simpan data pemesanan
        $pemesanan = new Pemesanan();
        $pemesanan->pelanggan_id = Auth::guard('pelanggan')->id();
        $pemesanan->user_id = Auth::id();
        $pemesanan->id_metode_pembayaran = $request->id_metode_pembayaran; // Pastikan metode pembayaran sudah dipilih
        $pemesanan->total_harga = $total_harga;
        $pemesanan->status = 'Pending'; // Atur status awal pemesanan
        $pemesanan->tgl_pemesanan = now();
        $pemesanan->save();

        // Simpan detail pemesanan
        foreach ($keranjang as $item) {
            $detail = new DetailPemesanan();
            $detail->id_pemesanan = $pemesanan->id;
            $detail->id_barang = $item->id_barang;
            $detail->user_id = $item->user_id;
            $detail->pelanggan_id = $item->pelanggan_id;
            $detail->jumlah = $item->jumlah;
            $detail->subtotal = $item->subtotal;
            $detail->save();
        }

        // Simpan data pengiriman
        $pengiriman = new Pengiriman();
        $pengiriman->id_pemesanan = $pemesanan->id;
        $pengiriman->user_id = Auth::id();
        $pengiriman->pelanggan_id = Auth::guard('pelanggan')->id();
        $pengiriman->alamat = $request->alamat;
        $pengiriman->save();

        // Jika metode pembayaran memiliki ID 1, wajib data pertamanya Cash on Delivery (COD)
        if ($request->id_metode_pembayaran == 1) {

            // Update status pemesanan menjadi "proses"
            $pemesanan->status = 'Proses';
            $pemesanan->save();
        }

        // Hapus keranjang setelah data disimpan
        if (Auth::guard('pelanggan')->check()) {
            // Jika yang login adalah pelanggan, hapus keranjang berdasarkan pelanggan_id
            KeranjangProduk::where('pelanggan_id', Auth::guard('pelanggan')->id())->delete();
        } else if (Auth::check()) {
            // Jika yang login adalah admin, hapus keranjang berdasarkan user_id
            KeranjangProduk::where('user_id', Auth::id())->delete();
        }

        // Redirect ke halaman konfirmasi atau detail pemesanan
        return redirect()->route('pemesanan.detail', $pemesanan->id)->with('success', 'Pemesanan berhasil dilakukan.');
    }

    public function show($id)
    {
        $pemesanan = Pemesanan::with(['details.barang', 'pembayaran', 'pengiriman.user', 'pengiriman.pelanggan', 'metodePembayaran'])->findOrFail($id);

        return view('pemesanan', compact('pemesanan'));
    }

    public function createPayment(Request $request, $id)
    {
        // Validasi unggahan file pembayaran
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'bukti_pembayaran.required' => 'Upload bukti pembayaran anda.',
            'bukti_pembayaran.image' => 'File yang diunggah harus berupa gambar.',
            'bukti_pembayaran.mimes' => 'Format gambar yang diunggah harus dalam format: png, jpg, jpeg.',
            'bukti_pembayaran.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ]);

        // Ambil data pemesanan
        $pemesanan = Pemesanan::findOrFail($id);

        // Upload gambar
        if ($image = $request->file('bukti_pembayaran')) {
            $destinationPath = 'bukti_pembayaran/';
            $postImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $postImage);
            $input['bukti_pembayaran'] = "$postImage";
        }

        // Simpan data pembayaran
        $pembayaran = new Pembayaran();
        $pembayaran->id_pemesanan = $pemesanan->id;
        $pembayaran->id_metode_pembayaran = $pemesanan->id_metode_pembayaran;
        $pembayaran->user_id = Auth::id();
        $pembayaran->pelanggan_id = Auth::guard('pelanggan')->id();
        $pembayaran->total_pembayaran = $pemesanan->total_harga;
        $pembayaran->bukti_pembayaran = $postImage;
        $pembayaran->save();

        // Update status pemesanan menjadi "proses"
        $pemesanan->status = 'Proses';
        $pemesanan->save();

        // Redirect ke halaman detail pemesanan dengan ID pemesanan baru
        return redirect()->route('pemesanan.detail', ['id' => $pemesanan->id])->with('success', 'Pembayaran berhasil dilakukan.');
    }

    public function updateDikirim($id)
    {
        // Temukan data pemesanan berdasarkan ID
        $pemesanan = Pemesanan::findOrFail($id);

        // Pastikan pemesanan ditemukan
        if ($pemesanan) {
            // Update status pemesanan menjadi "Dikirim"
            $pemesanan->status = 'Dikirim';
            $pemesanan->save();

            // Redirect kembali ke halaman pemesanan dengan pesan sukses
            return redirect()->route('admin.pesanan.index')->with('success', 'Status pemesanan berhasil diupdate menjadi Dikirim.');
        }

        // Redirect kembali ke halaman pemesanan dengan pesan error jika pemesanan tidak ditemukan
        return redirect()->route('admin.pesanan.index')->with('error', 'Pemesanan tidak ditemukan.');
    }

    public function updateProses($id)
    {
        // Temukan data pemesanan berdasarkan ID
        $pemesanan = Pemesanan::findOrFail($id);

        // Pastikan pemesanan ditemukan
        if ($pemesanan) {
            // Update status pemesanan menjadi "Proses"
            $pemesanan->status = 'Proses';
            $pemesanan->save();

            // Redirect kembali ke halaman pemesanan dengan pesan sukses
            return redirect()->route('admin.pesanan.index')->with('success', 'Status pemesanan berhasil diupdate menjadi Proses.');
        }

        // Redirect kembali ke halaman pemesanan dengan pesan error jika pemesanan tidak ditemukan
        return redirect()->route('admin.pesanan.index')->with('error', 'Pemesanan tidak ditemukan.');
    }
}
