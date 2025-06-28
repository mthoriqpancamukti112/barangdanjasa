<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pelanggan::orderBy('name', 'asc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($pelanggan) {
                    return '<div class="d-flex justify-content-center">
                            <a href="' . route("pelanggan.edit", $pelanggan->id) . '" class="btn btn-warning btn-sm me-1"><i class="fa-solid fa-pencil"></i></a>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="' . $pelanggan->id . '"><i class="fa-solid fa-trash"></i></button>
                        </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pelanggan.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pelanggan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'no_hp' => 'required|numeric|digits_between:10,15|unique:pelanggan,no_hp',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string|max:500',
            'email' => 'required|email|unique:pelanggan,email',
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'Nama harus diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'no_hp.required' => 'Nomor HP harus diisi.',
            'no_hp.numeric' => 'Nomor HP harus berupa angka.',
            'no_hp.digits_between' => 'Nomor HP harus antara 10 hingga 15 digit.',
            'no_hp.unique' => 'Nomor HP sudah terdaftar.',
            'jenis_kelamin.required' => 'Jenis kelamin harus diisi.',
            'jenis_kelamin.in' => 'Jenis kelamin harus salah satu dari: Laki-laki, Perempuan.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'alamat.max' => 'Alamat tidak boleh lebih dari 500 karakter.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password harus minimal 8 karakter.',
        ]);

        $input = $request->all();
        $input['password'] = bcrypt($request->password);

        Pelanggan::create($input);
        return redirect()->route('pelanggan.index')->with('success', 'Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('admin.pelanggan.edit', compact('pelanggan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'no_hp' => 'required|numeric|digits_between:10,15',
            'jenis_kelamin' => 'required',
            'alamat' => 'required|string|max:500',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'Nama harus diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'no_hp.required' => 'Nomor HP harus diisi.',
            'no_hp.numeric' => 'Nomor HP harus berupa angka.',
            'no_hp.digits_between' => 'Nomor HP harus antara 10 hingga 15 digit.',
            'jenis_kelamin.required' => 'Jenis kelamin harus diisi.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'alamat.max' => 'Alamat tidak boleh lebih dari 500 karakter.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password harus diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password harus minimal 8 karakter.',
        ]);

        // Mendapatkan instance barang berdasarkan ID
        $pelanggan = Pelanggan::findOrFail($id);

        $input = $request->all();

        $pelanggan->update($input);
        return redirect()->route("pelanggan.index")->with("success", "Berhasil diupdate");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();
        return response()->json(['success' => 'Data berhasil dihapus']);
    }
}
