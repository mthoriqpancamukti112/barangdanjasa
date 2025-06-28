@extends('layout.fe.template')
@section('title', 'Detail Produk')
@section('content')
    <section class="container my-5">
        <div class="row">
            <div class="col-lg-5">
                <div class="card-body text-center">
                    <img src="{{ asset('/gambar_barang/' . $detail_produk->image) }}" alt=""
                        style="width: 100%; border-radius: 10px; object-fit: cover; height: 350px;">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card-body">
                    <h2 class="font-weight-bold" style="font-size: 32px;">{{ $detail_produk->nama_barang }}</h2>
                    <span class="text-primary" style="font-size: 24px;"><i class="fas fa-tags"></i> Rp.
                        {{ number_format($detail_produk->harga_barang, 0, ',', '.') }}</span>
                    <div class="mb-4 mt-4">
                        <span style="font-size: 20px;">Stok:
                            {{ $detail_produk->stok }}</span>
                    </div>
                    <div class="d-flex mt-3">
                        @if (isset($detail_produk->error_message))
                            <button class="btn btn-danger btn-sm" style="width: 150px; font-size: 18px; border-radius: 50px"
                                disabled>{{ $detail_produk->error_message }}</button>
                        @else
                            <form action="{{ route('keranjang.pesanan.store', $detail_produk->id) }}" method="POST"
                                class="purchase-form">
                                @csrf
                                @if ($detail_produk->bisa_disewa)
                                    <a href="{{ route('penyewaan.create', ['id' => $detail_produk->id]) }}"
                                        class="btn btn-primary btn-sm"
                                        style="width: 150px; font-size: 18px; border-radius: 50px">Sewa</a>
                                @else
                                    <button type="submit" class="btn btn-primary btn-sm"
                                        style="width: 150px; font-size: 18px; border-radius: 50px">Beli</button>
                                @endif

                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div>
            <h4 class="mt-3">Deskripsi</h4>
            <p style="text-align: justify">{{ $detail_produk->deskripsi }}</p>
        </div>
    </section>
@endsection
