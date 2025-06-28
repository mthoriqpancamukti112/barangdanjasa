<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PelangganRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.pelanggan-register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'no_hp' => 'required|numeric|digits_between:10,15|unique:pelanggan,no_hp',
            'jenis_kelamin' => 'required',
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
            'jenis_kelamin.required' => 'Pilih jenis kelamin.',
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

        // Simpan data pelanggan ke dalam database
        Pelanggan::create([
            'name' => $request->name,
            'no_hp' => $request->no_hp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect ke halaman login setelah registrasi berhasil
        return redirect()->route('pelanggan.login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
