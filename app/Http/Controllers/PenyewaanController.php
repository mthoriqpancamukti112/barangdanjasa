<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyewaan;
use App\Models\Barang;
use App\Models\MetodePembayaran;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Pengembalian;
use App\Models\Pengiriman;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PenyewaanController extends Controller
{

    public function adminIndex()
    {
        $penyewaans = Penyewaan::with(['barang', 'pelanggan', 'user', 'pembayaran'])->orderBy('created_at', 'desc')->get();
        return view('admin.penyewaan.index', compact('penyewaans'));
    }

    public function updateStatus(Request $request, $id)
    {
        $penyewaan = Penyewaan::findOrFail($id);
        $penyewaan->status = $request->input('status');
        $penyewaan->save();

        return redirect()->route('admin.penyewaan.index')->with('success', 'Status penyewaan berhasil diperbarui.');
    }

    public function updateStatusSelesai($id)
    {
        $penyewaan = Penyewaan::findOrFail($id);
        $penyewaan->status = 'selesai';
        $penyewaan->save();

        return redirect()->route('penyewaan.index')->with('success', 'Status penyewaan telah diupdate menjadi selesai.');
    }

    public function storePengembalian(Request $request)
    {
        $request->validate([
            'penyewaan_id' => 'required|exists:penyewaans,id',
            'tgl_pengembalian' => 'required|date',
            'kondisi_barang' => 'required|string',
        ]);

        // Simpan data pengembalian
        $pengembalian = Pengembalian::create([
            'penyewaan_id' => $request->penyewaan_id,
            'tgl_pengembalian' => $request->tgl_pengembalian,
            'kondisi_barang' => $request->kondisi_barang,
        ]);

        // Temukan penyewaan dan barang terkait
        $penyewaan = Penyewaan::findOrFail($request->penyewaan_id);
        $barang = Barang::findOrFail($penyewaan->barang_id);

        // Perbarui status penyewaan menjadi selesai
        $penyewaan->status = 'selesai';
        $penyewaan->save();

        // Tambahkan kembali stok barang
        $barang->stok += $penyewaan->jumlah;
        $barang->save();

        return redirect()->route('penyewaan.index')->with('success', 'Barang berhasil dikembalikan dan status penyewaan telah diupdate.');
    }


    public function index()
    {
        $penyewaans = Penyewaan::with(['barang', 'pembayaran'])
            ->where('pelanggan_id', Auth::guard('pelanggan')->id())
            ->orderBy('created_at', 'desc')->get()
            ->map(function ($penyewaan) {
                $penyewaan->barang_dikembalikan = Pengembalian::where('penyewaan_id', $penyewaan->id)->exists();
                // Cek apakah sudah ada pembayaran
                $penyewaan->is_payed = $penyewaan->pembayaran()->exists();
                return $penyewaan;
            });

        $metodePembayaran = MetodePembayaran::all();

        // Hitung total harga semua penyewaan
        $totalHargaSemuaPenyewaan = $penyewaans->sum('total_harga');

        return view('penyewaan.index', compact('penyewaans', 'totalHargaSemuaPenyewaan', 'metodePembayaran'));
    }

    public function create($id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->stok <= 0) {
            return redirect()->route('produk.index')->with('error', 'Stok habis, tidak dapat melanjutkan.');
        }

        return view('penyewaan.create', compact('barang'));
    }

    public function store(Request $request, $id)
    {
        // Validasi data input
        $validated = $request->validate([
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Ambil data barang
        $barang = Barang::findOrFail($id);

        // Cek jika stok mencukupi
        if ($barang->stok < $validated['jumlah']) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi untuk jumlah penyewaan.');
        }

        // Ambil ID pengguna yang sedang login
        $user_id = Auth::id();
        $pelanggan_id = Auth::guard('pelanggan')->id();

        // Hitung total harga
        $total_harga = $barang->harga_barang * $validated['jumlah'];

        // Simpan data penyewaan
        $penyewaan = new Penyewaan();
        $penyewaan->barang_id = $id;
        $penyewaan->user_id = $user_id;
        $penyewaan->pelanggan_id = $pelanggan_id;
        $penyewaan->tgl_mulai = $validated['tgl_mulai'];
        $penyewaan->tgl_selesai = $validated['tgl_selesai'];
        $penyewaan->jumlah = $validated['jumlah'];
        $penyewaan->total_harga = $total_harga;
        $penyewaan->status = 'pending';
        $penyewaan->save();

        // Kurangi stok barang
        $barang->stok -= $validated['jumlah'];
        $barang->save();

        return redirect()->route('penyewaan.index')->with('success', 'Penyewaan berhasil. Tunggu persetujuan dari admin.');
    }

    public function edit(Penyewaan $penyewaan)
    {
        $barangs = Barang::where('bisa_disewa', true)->get();
        $pelanggans = Pelanggan::all();
        $users = User::all();
        return view('penyewaan.edit', compact('penyewaan', 'barangs', 'pelanggans', 'users'));
    }

    public function update(Request $request, Penyewaan $penyewaan)
    {
        $validated = $request->validate([
            'pelanggan_id' => 'required',
            'user_id' => 'required',
            'barang_id' => 'required',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'jumlah' => 'required|integer',
            'total_harga' => 'required|integer',
            'status' => 'required|string'
        ]);

        $penyewaan->update($validated);

        return redirect()->route('penyewaan.index')->with('success', 'Penyewaan updated successfully.');
    }

    public function destroy(Penyewaan $penyewaan)
    {
        $penyewaan->delete();
        return redirect()->route('penyewaan.index')->with('success', 'Penyewaan deleted successfully.');
    }

    public function storePembayaran(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required',
            'total_pembayaran' => 'required|numeric',
            'alamat' => 'required',
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $penyewaan = Penyewaan::findOrFail($id);
        $pelanggan_id = Auth::guard('pelanggan')->id();
        $user_id = Auth::id();

        // Simpan bukti pembayaran jika ada
        if ($image = $request->file('bukti_pembayaran')) {
            $destinationPath = 'bukti_pembayaran/';
            $paymentProofImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $paymentProofImage);
            $input['bukti_pembayaran'] = "$paymentProofImage";
        }

        // Simpan data pembayaran
        $pembayaran = Pembayaran::create([
            'penyewaan_id' => $penyewaan->id,
            'id_metode_pembayaran' => $request->metode_pembayaran,
            'pelanggan_id' => $pelanggan_id,
            'user_id' => $user_id,
            'total_pembayaran' => $request->total_pembayaran,
            'bukti_pembayaran' => $input['bukti_pembayaran'] ?? null,
        ]);

        // Simpan data pengiriman
        $pengiriman = new Pengiriman();
        $pengiriman->penyewaan_id = $penyewaan->id;
        $pengiriman->user_id = Auth::id();
        $pengiriman->pelanggan_id = Auth::guard('pelanggan')->id();
        $pengiriman->alamat = $request->alamat;
        $pengiriman->save();

        return redirect()->back()->with('success', 'Pembayaran dan pengiriman berhasil disimpan.');
    }
}
