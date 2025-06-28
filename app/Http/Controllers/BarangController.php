<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Barang::orderBy('created_at', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($barang) {
                    return '<div class="d-flex justify-content-center">
                    <a href="' . route("barang.edit", $barang->id) . '" class="btn btn-warning btn-sm me-1"><i class="fa-solid fa-pencil"></i></a>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="' . $barang->id . '"><i class="fa-solid fa-trash"></i></button>
                </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.barang.index');
    }

    public function create()
    {
        return view('admin.barang.create');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('admin.barang.edit', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'nama_barang' => 'required|unique:barang,nama_barang',
            'harga_barang' => 'required|numeric|gt:0',
            'stok' => 'required|integer|gt:0',
            'deskripsi' => 'required',
            'bisa_disewa' => 'required|boolean',
            'harga_sewa' => 'nullable|numeric|gt:0',
        ], [
            'image.required' => 'Gambar barang harus diunggah.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format gambar yang diunggah harus dalam format: png, jpg, jpeg.',
            'nama_barang.required' => 'Nama barang harus diisi.',
            'nama_barang.unique' => 'Nama barang sudah ada.',
            'harga_barang.required' => 'Harga barang harus diisi.',
            'harga_barang.numeric' => 'Harga barang harus berupa angka.',
            'harga_barang.gt' => 'Harga barang tidak valid.',
            'stok.required' => 'Stok barang harus diisi.',
            'stok.integer' => 'Stok barang harus berupa bilangan bulat',
            'stok.gt' => 'Stok barang tidak valid.',
            'deskripsi.required' => 'Deskripsi barang harus diisi.',
            'bisa_disewa.required' => 'Status bisa disewa harus diisi.',
            'bisa_disewa.boolean' => 'Status bisa disewa tidak valid.',
            'harga_sewa.numeric' => 'Harga sewa harus berupa angka.',
            'harga_sewa.gt' => 'Harga sewa tidak valid.',
        ]);

        $input = $request->all();

        //upload gambar
        if ($image = $request->file('image')) {
            $destinationPath = 'gambar_barang/';
            $postImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $postImage);
            $input['image'] = "$postImage";
        }

        Barang::create($input);
        return redirect()->route('barang.index')->with('success', 'Berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => ['required', Rule::unique('barang')->ignore($id)],
            'harga_barang' => 'required|numeric|gt:0',
            'stok' => 'required|integer|gt:0',
            'deskripsi' => 'required',
            'image' => 'sometimes|image|mimes:png,jpg,jpeg|max:2048',
            'bisa_disewa' => 'required|boolean',
            'harga_sewa' => 'nullable|numeric|gt:0',
        ], [
            'nama_barang.required' => 'Nama barang harus diisi.',
            'nama_barang.unique' => 'Nama barang sudah ada.',
            'harga_barang.required' => 'Harga barang harus diisi.',
            'harga_barang.numeric' => 'Harga barang harus berupa angka.',
            'harga_barang.gt' => 'Harga barang tidak valid.',
            'stok.required' => 'Stok barang harus diisi.',
            'stok.integer' => 'Stok barang harus berupa bilangan bulat.',
            'stok.gt' => 'Stok barang tidak valid.',
            'deskripsi.required' => 'Deskripsi barang harus diisi.',
            'image.required' => 'Gambar barang harus diunggah.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format gambar yang diunggah harus dalam format: png, jpg, jpeg.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            'bisa_disewa.required' => 'Status bisa disewa harus diisi.',
            'bisa_disewa.boolean' => 'Status bisa disewa tidak valid.',
            'harga_sewa.numeric' => 'Harga sewa harus berupa angka.',
            'harga_sewa.gt' => 'Harga sewa tidak valid.',
        ]);

        // Mendapatkan instance barang berdasarkan ID
        $barang = Barang::findOrFail($id);

        $input = $request->except(['image']);

        // upload gambar utama
        if ($request->hasFile('image')) {
            $destinationPath = 'gambar_barang/';

            // Hapus gambar lama jika ada
            if ($barang->image && file_exists($destinationPath . $barang->image)) {
                unlink($destinationPath . $barang->image);
            }

            // Upload dan simpan gambar baru
            $image = $request->file('image');
            $postImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $postImage);
            $input['image'] = $postImage;
        }

        $barang->update($input);
        return redirect()->route("barang.index")->with("success", "Berhasil diupdate");
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();
        return response()->json(['success' => 'Data berhasil dihapus']);
    }
}