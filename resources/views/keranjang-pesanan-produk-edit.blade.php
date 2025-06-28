@extends('layout.fe.template')
@section('title', 'Edit Pemesanan')
@section('content')
    <section class="container my-5">
        <div class="row">
            <div class="col-lg-5">
                <div class="card-body text-center">
                    <img src="{{ asset('/gambar_barang/' . $data->barang->image) }}" alt=""
                        style="width: 100%; border-radius: 10px; object-fit: cover; height: 350px;">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card-body">
                    <h2 class="font-weight-bold" style="font-size: 32px;">{{ $data->nama_barang }}</h2>
                    <span class="text-primary" style="font-size: 24px;"><i class="fas fa-tags"></i> Rp.
                        {{ number_format($data->harga_barang, 0, ',', '.') }}</span>
                    <div class="mb-4 mt-2">
                        <span style="font-size: 20px;">Stok:
                            {{ $data->barang->stok }}</span>
                    </div>
                    <form action="{{ route('keranjang.pesanan.update', $data->id) }}" method="post">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <label for="jumlah"><i class="fas fa-sort-numeric-up"></i> Jumlah</label>
                            <input type="number" class="form-control col-md-3 col-6" name="jumlah"
                                value="{{ $data->jumlah }}">
                        </div>
                        <div class="d-flex mt-3">
                            <button type="submit" value="Simpan" class="btn btn-success btn-sm mr-2"><i
                                    class="fas fa-save"></i> Update</button>
                            <a href="{{ route('keranjang.pesanan.index') }}" class="btn btn-danger btn-sm"><i
                                    class="fas fa-times"></i> Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
