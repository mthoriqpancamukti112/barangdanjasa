<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $data = Barang::where('nama_barang', 'LIKE', "%{$query}%")->orderBy('created_at', 'desc')->get();
        } else {
            $data = Barang::orderBy('created_at', 'desc')->get();
        }

        foreach ($data as $item) {
            if ($item->stok <= 0) {
                $item->error_message = 'Stok habis';
            }
        }

        if ($request->ajax()) {
            return view('partials.produk-list', compact('data'))->render();
        }

        return view('produk', compact('data', 'query'));
    }

    public function detailproduk($id)
    {
        $detail_produk = Barang::findOrFail($id);

        if ($detail_produk->stok <= 0) {
            $detail_produk->error_message = 'Stok habis';
        }

        return view('detail-produk', compact('detail_produk'));
    }
}