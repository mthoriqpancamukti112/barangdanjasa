<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\MetodePembayaran;
use App\Models\Pemesanan;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MetodePembayaranController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MetodePembayaran::orderBy('name_metode', 'asc')->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($metodepembayaran) {
                    return '<div class="d-flex justify-content-center">
                    <a href="' . route("metodepembayaran.edit", $metodepembayaran->id) . '" class="btn btn-warning btn-sm me-1"><i class="fa-solid fa-pencil"></i></a>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="' . $metodepembayaran->id . '"><i class="fa-solid fa-trash"></i></button>
                            </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.metodepembayaran.index');
    }

    public function create()
    {
        return view('admin.metodepembayaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_metode' => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/u', 'max:255', 'unique:metode_pembayaran,name_metode'],
            'detail' => ['required', 'max:255'],
        ], [
            'name_metode.required' => 'Metode Pembayaran harus diisi.',
            'name_metode.string' => 'Metode Pembayaran tidak valid.',
            'name_metode.regex' => 'Metode Pembayaran tidak valid.',
            'name_metode.max' => 'Metode Pembayaran tidak boleh lebih dari 255 karakter.',
            'name_metode.unique' => 'Metode Pembayaran sudah ada.',
            'detail.required' => 'Detail harus diisi.',
            'detail.max' => 'Detail tidak boleh lebih dari 255 karakter.',
        ]);

        $input = $request->all();

        MetodePembayaran::create($input);
        return redirect()->route('metodepembayaran.index')->with('success', 'Berhasil ditambahkan');
    }

    public function edit($id)
    {
        $metodepembayaran = MetodePembayaran::findOrFail($id);
        return view('admin.metodepembayaran.edit', compact('metodepembayaran'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_metode' => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/u', 'max:255', Rule::unique('metode_pembayaran')->ignore($id)],
            'detail' => ['required', 'max:255'],
        ], [
            'name_metode.required' => 'Metode Pembayaran harus diisi.',
            'name_metode.string' => 'Metode Pembayaran tidak valid.',
            'name_metode.regex' => 'Metode Pembayaran tidak valid.',
            'name_metode.max' => 'Metode Pembayaran tidak boleh lebih dari 255 karakter.',
            'name_metode.unique' => 'Metode Pembayaran sudah ada.',
            'detail.required' => 'Detail harus diisi.',
            'detail.max' => 'Detail tidak boleh lebih dari 255 karakter.',
        ]);

        // Mendapatkan instance barang berdasarkan ID
        $metodepembayaran = MetodePembayaran::findOrFail($id);

        $input = $request->all();

        $metodepembayaran->update($input);
        return redirect()->route("metodepembayaran.index")->with("success", "Berhasil diupdate");
    }

    public function destroy($id)
    {
        $metodepembayaran = MetodePembayaran::findOrFail($id);
        $metodepembayaran->delete();
        return response()->json(['success' => 'Data berhasil dihapus']);
    }
}
