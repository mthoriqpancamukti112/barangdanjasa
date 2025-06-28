@extends('layout.be.template')

@section('title', 'Pemesanan')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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

        .status {
            padding: 3px 8px;
            border-radius: 5px;
            display: inline-block;
        }

        .pending-status {
            background-color: #ff4500;
            color: #ffffff;
        }

        .proses-status {
            background-color: #ffd700;
            color: #000000;
        }

        .dikirim-status {
            background-color: #00ff00;
            color: #000000;
        }

        .selesai-status {
            background-color: #0400ff;
            color: #ffffff;
        }
    </style>

    <div class="container-fluid px-4">
        <h1 class="mt-4">Pemesanan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Pemesanan</li>
        </ol>

        <div class="card mb-4">
            <div class="card-body">
                <table id="datatablesSimple" class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Customer</th>
                            <th>Tanggal Pesan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pemesanans as $pemesanan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div>
                                        <p>
                                            @if ($pemesanan->pengiriman)
                                                @if ($pemesanan->pengiriman->user)
                                                    {{ $pemesanan->pengiriman->user->name }}
                                                @elseif ($pemesanan->pengiriman->pelanggan)
                                                    {{ $pemesanan->pengiriman->pelanggan->name }}
                                                @endif
                                            @endif
                                        </p>
                                    </div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($pemesanan->tgl_pemesanan)->locale('id_ID')->isoFormat('D MMMM YYYY') }}
                                </td>
                                <td>
                                    <span
                                        class="status
                                        @if ($pemesanan->status == 'Proses') proses-status
                                        @elseif ($pemesanan->status == 'Dikirim') dikirim-status
                                        @elseif ($pemesanan->status == 'Selesai') selesai-status
                                        @elseif ($pemesanan->status == 'Pending') pending-status @endif">
                                        {{ $pemesanan->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-info btn-sm mr-2" data-toggle="modal"
                                            data-target="#detailModal{{ $pemesanan->id }}">
                                            Lihat Detail
                                        </button>
                                        @if ($pemesanan->status == 'Proses')
                                            <form action="{{ route('pemesanan.update-dikirim', ['id' => $pemesanan->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-primary btn-sm">Update
                                                    Dikirim</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($pemesanans as $pemesanan)
        <!-- Modal Detail Pemesanan -->
        <div class="modal fade" id="detailModal{{ $pemesanan->id }}" tabindex="-1" role="dialog"
            aria-labelledby="detailModalLabel{{ $pemesanan->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel{{ $pemesanan->id }}">Detail
                            Pemesanan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Nama Customer:</strong>
                                        @if ($pemesanan->pengiriman)
                                            @if ($pemesanan->pengiriman->user)
                                                {{ $pemesanan->pengiriman->user->name }}
                                            @elseif ($pemesanan->pengiriman->pelanggan)
                                                {{ $pemesanan->pengiriman->pelanggan->name }}
                                            @endif
                                        @endif
                                    </p>
                                    <p><strong>Alamat Pengiriman:</strong>
                                        @if ($pemesanan->pengiriman)
                                            {{ $pemesanan->pengiriman->alamat }}
                                        @endif
                                    </p>
                                    <p><strong>Metode Pembayaran:</strong>
                                        {{ $pemesanan->metodePembayaran->name_metode }}</p>
                                    <p><strong>Tanggal Pesan:</strong>
                                        {{ \Carbon\Carbon::parse($pemesanan->tgl_pemesanan)->locale('id_ID')->isoFormat('D MMMM YYYY') }}
                                    </p>
                                    <p><strong>Status:</strong> <span
                                            class="status
                                        @if ($pemesanan->status == 'Proses') proses-status
                                        @elseif ($pemesanan->status == 'Dikirim') dikirim-status
                                        @elseif ($pemesanan->status == 'Selesai') selesai-status
                                        @elseif ($pemesanan->status == 'Pending') pending-status @endif">
                                            {{ $pemesanan->status }}
                                        </span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Bukti Pembayaran</strong> </p>
                                    @if ($pemesanan->pembayaran)
                                        <a href="/bukti_pembayaran/{{ $pemesanan->pembayaran->bukti_pembayaran }}"
                                            data-lightbox="bukti-pembayaran">
                                            <img src="/bukti_pembayaran/{{ $pemesanan->pembayaran->bukti_pembayaran }}"
                                                alt="Bukti Pembayaran" class="rounded lightbox-image">
                                        </a>
                                    @else
                                        <p>Pembayaran belum ada</p>
                                    @endif
                                </div>
                                <div>
                                    <h5 class="text-center mt-4">Barang yang dipesan</h5>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <th>Total Bayar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pemesanan->details as $detail)
                                                <tr>
                                                    <td>{{ $detail->barang->nama_barang }}</td>
                                                    <td>{{ 'Rp ' . number_format($detail->barang->harga_barang, 0, ',', '.') }}
                                                    </td>
                                                    <td>{{ $detail->jumlah }}</td>
                                                    <td>{{ 'Rp ' . number_format($detail->pemesanan->total_harga, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
@endsection
