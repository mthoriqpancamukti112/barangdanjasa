@extends('layout.fe.template')
@section('title', 'Pengembalian Barang')

@section('content')
    <section class="container mt-4">
        <h2 class="mb-4">Form Pengembalian Barang</h2>
        <form action="{{ route('penyewaan.storeReturn', $penyewaan->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="tgl_pengembalian" class="form-label">Tanggal Pengembalian</label>
                <input type="date" class="form-control" id="tgl_pengembalian" name="tgl_pengembalian" required>
            </div>
            <div class="mb-3">
                <label for="kondisi_barang" class="form-label">Kondisi Barang</label>
                <textarea class="form-control" id="kondisi_barang" name="kondisi_barang" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Kembalikan Barang</button>
        </form>
    </section>
@endsection
