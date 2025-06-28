@extends('layout.be.template')
@section('title', 'Admin Dashboard')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="row">
                <h2 style="margin-bottom: 50px">Selamat Datang <span style="color: #ff8a00">
                        {{ Auth::user()->name }}
                    </span>
                </h2>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="p-3 shadow-sm d-flex justify-content-around align-items-center rounded bg-primary">
                        <div>
                            <h3 class="fs-2 text-white text-center">{{ $jumlah_pelanggan }}</h3>
                            <p class="fs-5 text-white">Pelanggan</p>
                        </div>
                        <i class="fa-solid fa-users" style="font-size: 50px; color: white"></i>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="p-3 shadow-sm d-flex justify-content-around align-items-center rounded bg-success">
                        <div>
                            <h3 class="fs-2 text-white text-center">{{ $jumlah_user }}</h3>
                            <p class="fs-5 text-white">User</p>
                        </div>
                        <i class="fa-solid fa-user" style="font-size: 50px; color: white"></i>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="p-3 shadow-sm d-flex justify-content-around align-items-center rounded bg-danger">
                        <div>
                            <h3 class="fs-2 text-white text-center">{{ $jumlah_produk }}</h3>
                            <p class="fs-5 text-white">Produk</p>
                        </div>
                        <i class="fa-solid fa-basket-shopping" style="font-size: 50px; color: white"></i>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="p-3 shadow-sm d-flex justify-content-around align-items-center rounded bg-warning">
                        <div>
                            <h3 class="fs-2 text-white text-center">{{ $jumlah_pesanan }}</h3>
                            <p class="fs-5 text-white">Pemesanan</p>
                        </div>
                        <i class="fa-solid fa-cart-shopping" style="font-size: 50px; color: white"></i>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
