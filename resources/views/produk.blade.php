@extends('layout.fe.template')
@section('title', 'Produk')
@section('content')
    <style>
        .custom-btn {
            border-radius: 50px;
            background: #FFD93D;
            transition: background 0.3s;
        }

        .custom-btn:hover {
            background: #FFC107;
        }
    </style>

    {{-- <section>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="/img/1.jpg" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="/img/2.jpeg" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="/img/homeImg3.jpg" alt="">
                </div>
            </div>
            <div class="swiper-button-next nav-btn"></div>
            <div class="swiper-button-prev nav-btn"></div>
            <div class="swiper-pagination"></div>
        </div>
    </section> --}}

    @include('layout.fe.top-nav-buttom')

    <div class="container mt-4">

        <div class="mt-4">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#daftar-sewa">Daftar Sewa</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#daftar-penjualan">Daftar Penjualan</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="daftar-sewa">

                <!-- Search Form -->
                <div class="search-bar mt-4 mb-4">
                    <input type="text" id="search-query" class="form-control" placeholder="Cari produk yuk...">
                </div>

                <div class="wrapper pb-4" id="product-list">
                    @forelse ($data as $row)
                        @if ($row->bisa_disewa)
                            <div class="box">
                                <a href="{{ route('detail.produk', ['id' => $row->id]) }}">
                                    <img src="{{ asset('/gambar_barang/' . $row->image) }}" class="image" alt="">
                                </a>
                                <div>
                                    <center>
                                        <span style="font-size: 18px; font-weight: bold">
                                            {{ $row->nama_barang }}
                                        </span>
                                    </center>
                                    <br>
                                    <p style="font-size: 16px" class="custom-p text-primary"><i class="fas fa-tags"></i> Rp.
                                        {{ number_format($row->harga_barang, 0, ',', '.') }}</p>

                                    <div class="container pb-3">
                                        @if (isset($row->error_message))
                                            <p class="text-danger">{{ $row->error_message }}</p>
                                        @else
                                            <form action="{{ route('keranjang.pesanan.store', $row->id) }}" method="POST"
                                                class="purchase-form">
                                                @csrf
                                                <a href="{{ route('penyewaan.create', ['id' => $row->id]) }}"
                                                    class="btn btn-sm btn-block custom-btn"
                                                    style="border-radius: 50px">Sewa</a>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <p>Hmm, data produk belum tersedia.</p>
                    @endforelse
                </div>
            </div>

            <div class="tab-pane fade" id="daftar-penjualan">
                <!-- Search Form -->
                <div class="search-bar mt-4 mb-4">
                    <input type="text" id="search-query-penjualan" class="form-control" placeholder="Cari produk yuk...">
                </div>

                <div class="wrapper pb-4" id="product-list-penjualan"> <!-- Unique ID here -->
                    @forelse ($data as $row)
                        @if (!$row->bisa_disewa)
                            <!-- Only display products that cannot be rented -->
                            <div class="box">
                                <img src="{{ asset('/gambar_barang/' . $row->image) }}" class="image" alt="">
                                <div>
                                    <center>
                                        <span style="font-size: 18px; font-weight: bold">
                                            {{ $row->nama_barang }}
                                        </span>
                                    </center>
                                    <br>
                                    <p style="font-size: 16px" class="custom-p text-primary"><i class="fas fa-tags"></i> Rp.
                                        {{ number_format($row->harga_barang, 0, ',', '.') }}</p>

                                    <div class="container pb-3">
                                        @if (isset($row->error_message))
                                            <p class="text-danger">{{ $row->error_message }}</p>
                                        @else
                                            <form action="{{ route('keranjang.pesanan.store', $row->id) }}" method="POST"
                                                class="purchase-form">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-block custom-btn"
                                                    style="border-radius: 50px">Beli</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <p>Hmm, data produk belum tersedia.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('search-query').addEventListener('input', function() {
            const query = this.value;
            fetch(`{{ route('produk.index') }}?query=${query}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('product-list').innerHTML = new DOMParser().parseFromString(data,
                        'text/html').getElementById('product-list').innerHTML;
                });
        });

        document.getElementById('search-query-penjualan').addEventListener('input', function() {
            const query = this.value;
            fetch(`{{ route('produk.index') }}?query=${query}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('product-list-penjualan').innerHTML = new DOMParser()
                        .parseFromString(data,
                            'text/html').getElementById('product-list-penjualan').innerHTML;
                });
        });
    </script>
@endsection
