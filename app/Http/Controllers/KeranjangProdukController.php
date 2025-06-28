<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KeranjangProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangProdukController extends Controller
{
    public function index()
    {
        if (Auth::guard('pelanggan')->check()) {
            // Jika yang login adalah pelanggan, ambil keranjang belanja miliknya dan urutkan berdasarkan created_at
            $pesanan = KeranjangProduk::where('pelanggan_id', Auth::guard('pelanggan')->id())
                ->orderBy('created_at', 'desc')
                ->get();
        } else if (Auth::check()) {
            // Jika yang login adalah admin, ambil keranjang belanja berdasarkan user_id dan urutkan berdasarkan created_at
            $pesanan = KeranjangProduk::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Hitung jumlah item dalam keranjang
        $jumlah_item_keranjang = $pesanan->sum('jumlah');

        // Hitung total belanja
        $total_belanja = $pesanan->sum('subtotal');

        // Tampilkan view dengan data pesanan
        return view('keranjang-pesanan-produk', compact('pesanan', 'total_belanja', 'jumlah_item_keranjang'));
    }

    public function store(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        if (Auth::guard('pelanggan')->check()) {
            $userId = Auth::guard('pelanggan')->id();
            $column = 'pelanggan_id';
        } else if (Auth::check()) {
            $userId = Auth::id();
            $column = 'user_id';
        } else {
            return redirect()->route('login')->with('error', 'Silahkan login terlebih dahulu.');
        }

        // Cek apakah produk sudah ada di keranjang
        $existingItem = KeranjangProduk::where($column, $userId)
            ->where('id_barang', $id)
            ->first();

        if ($existingItem) {
            // Jika sudah ada, beri pesan kepada pengguna
            return redirect()->route('keranjang.pesanan.index')->with('error', 'Produk sudah ada dalam keranjang.');
        } else {
            // Jika belum ada, tambahkan produk baru ke keranjang
            $pemesanan = new KeranjangProduk();
            $pemesanan->id_barang = $barang->id;
            $pemesanan->nama_barang = $barang->nama_barang;
            $pemesanan->harga_barang = $barang->harga_barang;
            $pemesanan->jumlah = $request->jumlah ?? 1;
            $pemesanan->subtotal = $barang->harga_barang * $pemesanan->jumlah;
            $pemesanan->$column = $userId;
            $pemesanan->save();
        }

        // Mengurangi stok barang
        $barang->stok -= 1;
        $barang->save();

        return redirect()->route('keranjang.pesanan.index')->with('success', 'Produk berhasil ditambahkan ke dalam pemesanan.');
    }


    public function update(Request $request, $id)
    {
        $pemesanan = KeranjangProduk::findOrFail($id);
        $jumlah_awal = $pemesanan->jumlah; // Simpan jumlah awal sebelum diperbarui
        $pemesanan->jumlah = $request->jumlah;

        // Hitung subtotal baru berdasarkan jumlah yang diperbarui
        $pemesanan->subtotal = $pemesanan->harga_barang * $request->jumlah;

        // Mengurangi stok barang berdasarkan perbedaan jumlah
        $perbedaan_jumlah = $pemesanan->jumlah - $jumlah_awal;
        $barang = Barang::findOrFail($pemesanan->id_barang);
        $barang->stok -= $perbedaan_jumlah; // Kurangi stok dengan perbedaan jumlah
        $barang->save(); // Simpan perubahan stok barang

        $pemesanan->save();

        return redirect()->route('keranjang.pesanan.index')->with('success', 'Pemesanan berhasil diperbarui');
    }

    public function edit($id)
    {
        $data = KeranjangProduk::find($id);
        return view('keranjang-pesanan-produk-edit', compact('data'));
    }

    public function destroy($id)
    {
        // Temukan pesanan berdasarkan ID
        $pesanan = KeranjangProduk::findOrFail($id);

        // Kembalikan stok barang dengan menambahkan jumlah pesanan yang dihapus
        $barang = Barang::findOrFail($pesanan->id_barang);
        $barang->stok += $pesanan->jumlah; // Tambahkan stok dengan jumlah pesanan yang dihapus
        $barang->save(); // Simpan perubahan stok barang

        // Hapus pesanan
        $pesanan->delete();

        return redirect()->route('keranjang.pesanan.index')->with('success', 'Pemesanan berhasil dihapus');
    }
}