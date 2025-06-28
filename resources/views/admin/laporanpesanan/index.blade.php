@extends('layout.be.template')
@section('title', 'Laporan Pemesanan')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" />
    <style>
        #datatablesSimple th,
        #datatablesSimple td {
            width: auto !important;
            white-space: nowrap;
        }

        .lightbox-image {
            width: 50%;
            cursor: pointer;
        }
    </style>

    <div class="container-fluid px-4">
        <h1 class="mt-4">Laporan Pemesanan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Laporan Pemesanan</li>
        </ol>

        <div class="card mb-4">
            <div class="card-body">
                <a href="{{ route('report.pemesanan.pdf') }}" type="button" class="btn btn-primary btn-sm mb-3">Export
                    PDF</a>
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Customer</th>
                            <th>Metode Pembayaran</th>
                            <th>Sub Total</th>
                            <th>Tanggal</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Customer</th>
                            <th>Metode Pembayaran</th>
                            <th>Sub Total</th>
                            <th>Tanggal</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($pemesanans as $pemesanan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div>
                                        <p>
                                            <strong>Nama: </strong>
                                            @if ($pemesanan->pengiriman)
                                                @if ($pemesanan->pengiriman->user)
                                                    {{ $pemesanan->pengiriman->user->name }}
                                                @elseif ($pemesanan->pengiriman->pelanggan)
                                                    {{ $pemesanan->pengiriman->pelanggan->name }}
                                                @endif
                                            @endif
                                        </p>
                                        <p>
                                            <strong>Alamat: </strong>
                                            @if ($pemesanan->pengiriman)
                                                {{ $pemesanan->pengiriman->alamat }}
                                            @endif
                                        </p>
                                    </div>
                                </td>
                                <td>{{ $pemesanan->metodePembayaran->name_metode }}</td>
                                <td>{{ $pemesanan->total_harga }}</td>
                                <td>{{ \Carbon\Carbon::parse($pemesanan->tgl_pemesanan)->locale('id_ID')->isoFormat('D MMMM YYYY') }}
                                </td>
                                @foreach ($pemesanan->details as $detail)
                                    <td>{{ $detail->barang->nama_barang }}</td>
                                    <td>{{ $detail->jumlah }}</td>
                                    <td>{{ number_format($detail->barang->harga_barang, 0, ',', '.') }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
@endsection
