<?php

use App\Http\Controllers\AdminPesananController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeranjangProdukController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MetodePembayaranController;
use App\Http\Controllers\PelangganAuthController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PelangganRegisterController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BerandaController::class, 'index']);
Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda.index');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/detail-produk/{id}', [ProdukController::class, 'detailproduk'])->name('detail.produk');
Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');


Route::middleware(['check.user.or.pelanggan'])->group(function () {
    Route::get('/keranjang-pesanan-produk', [KeranjangProdukController::class, 'index'])->name('keranjang.pesanan.index');

    Route::post('/keranjang-pesanan-produk/{id}', [KeranjangProdukController::class, 'store'])->name('keranjang.pesanan.store');
    Route::patch('/keranjang-pesanan-produk/{id}', [KeranjangProdukController::class, 'update'])->name('keranjang.pesanan.update');
    Route::get('/keranjang-pesanan-produk/{id}', [KeranjangProdukController::class, 'edit'])->name('keranjang.pesanan.edit');
    Route::delete('/keranjang-pesanan-produk/{id}', [KeranjangProdukController::class, 'destroy'])->name('keranjang.pesanan.destroy');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index')->middleware('check.cart.not.empty');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::post('/pemesanan', [CheckoutController::class, 'store'])->name('pemesanan.store');
    Route::get('/pemesanan/{id}', [CheckoutController::class, 'show'])->name('pemesanan.detail');

    Route::get('/detail-pemesanan', [PesananController::class, 'index'])->name('detail.pemesanan.index');

    Route::post('/pembayaran/{id}', [CheckoutController::class, 'createPayment'])->name('pembayaran.store');

    Route::put('/pemesanan/{id}/selesai', [PesananController::class, 'updateSelesai'])->name('pemesanan.selesai');

    Route::get('penyewaan', [PenyewaanController::class, 'index'])->name('penyewaan.index');
    Route::get('penyewaan/create/{id}', [PenyewaanController::class, 'create'])->name('penyewaan.create');
    Route::post('penyewaan/store/{id}', [PenyewaanController::class, 'store'])->name('penyewaan.store');
    Route::get('admin/penyewaan', [PenyewaanController::class, 'adminIndex'])->name('admin.penyewaan.index');
    Route::put('admin/penyewaan/update-status/{id}', [PenyewaanController::class, 'updateStatus'])->name('admin.penyewaan.update-status');
    Route::post('pelanggan/penyewaan/pembayaran/{id}', [PenyewaanController::class, 'storePembayaran'])->name('pelanggan.penyewaan.pembayaran');

    Route::get('admin/penyewaan/pembayaran/{id}', [PenyewaanController::class, 'getPembayaran'])->name('admin.penyewaan.pembayaran');
    Route::get('admin/penyewaan/pengiriman/{id}', [PenyewaanController::class, 'getPengiriman'])->name('admin.penyewaan.pengiriman');

    Route::post('/pelanggan/penyewaan/{id}/selesai', [PenyewaanController::class, 'updateStatusSelesai'])->name('pelanggan.penyewaan.selesai');
    Route::post('/pelanggan/penyewaan/pengembalian', [PenyewaanController::class, 'storePengembalian'])->name('pelanggan.pengembalian.store');
});

Route::get('/admin/login', [LoginController::class, 'index'])->name('login');
Route::post('login-post', [LoginController::class, 'authenticate'])->name('login.post');

Route::group(['middleware' => 'guest:pelanggan'], function () {
    Route::get('/pelanggan/login', [PelangganAuthController::class, 'showLoginForm'])->name('pelanggan.login.form');
    Route::post('/pelanggan/login', [PelangganAuthController::class, 'login'])->name('pelanggan.login');

    Route::get('/pelanggan/register', [PelangganRegisterController::class, 'showRegistrationForm'])->name('pelanggan.register.form');
    Route::post('/pelanggan/register', [PelangganRegisterController::class, 'register'])->name('pelanggan.register');
});

// Logout Admin
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::post('logoutgues', [LoginController::class, 'logoutgues'])->name('logoutgues');

// Logout Pelanggan
Route::post('/pelanggan/logout', [PelangganAuthController::class, 'logout'])->name('pelanggan.logout');
// Route::get('/pelanggan/logout', [PelangganAuthController::class, 'logout'])->name('pelanggan.logout');

// Route::group(['middleware' => ['auth:pelanggan']], function () {
// });

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Route Data Barang
    Route::get('/admin/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/admin/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/admin/barang/store', [BarangController::class, 'store'])->name('barang.store');
    Route::delete('/admin/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
    Route::get('/admin/barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::patch('/admin/barang/{id}/update', [BarangController::class, 'update'])->name('barang.update');

    // Route Data Metode Pembayaran
    Route::get('/admin/metodepembayaran', [MetodePembayaranController::class, 'index'])->name('metodepembayaran.index');
    Route::get('/admin/metodepembayaran/create', [MetodePembayaranController::class, 'create'])->name('metodepembayaran.create');
    Route::post('/admin/metodepembayaran/store', [MetodePembayaranController::class, 'store'])->name('metodepembayaran.store');
    Route::delete('/admin/metodepembayaran/{id}', [MetodePembayaranController::class, 'destroy'])->name('metodepembayaran.destroy');
    Route::get('/admin/metodepembayaran/{id}/edit', [MetodePembayaranController::class, 'edit'])->name('metodepembayaran.edit');
    Route::patch('/admin/metodepembayaran/{id}/update', [MetodePembayaranController::class, 'update'])->name('metodepembayaran.update');

    // Route Data Pemesanan
    Route::get('/admin/pesanan', [AdminPesananController::class, 'index'])->name('admin.pesanan.index');

    // Route Data Pelanggan
    Route::resource('/admin/pelanggan', PelangganController::class);

    // Route Data User/Admin
    Route::resource('/admin/user', UserController::class);

    Route::put('/pemesanan/{id}/update-dikirim', [CheckoutController::class, 'updateDikirim'])->name('pemesanan.update-dikirim');
    Route::put('/pemesanan/{id}/update-proses', [CheckoutController::class, 'updateProses'])->name('pemesanan.update-proses');

    Route::get('/laporan-pemesanan', [LaporanController::class, 'index'])->name('laporan-pesanan.index');
    Route::get('/laporan-pemesanan/pdf', [LaporanController::class, 'pemesananReportPdf'])->name('report.pemesanan.pdf');

    Route::get('/laporan-penyewaan', [LaporanController::class, 'indexsewa'])->name('laporan-penyewaan.index');
    Route::get('/laporan-penyewaan/pdf', [LaporanController::class, 'penyewaanReportPdf'])->name('report.penyewaan.pdf');
});

// Route::resource('penyewaan', PenyewaanController::class);