@extends('layout.be.template')
@section('title', 'Laporan Penyewaan')
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

        .selesai-background {
            background-color: #0000ff;
            padding: 3px 8px;
            color: white;
            border-radius: 5px;
            display: inline-block;
        }

        .pending-background {
            background-color: grey;
            border-radius: 5px;
            padding: 3px 8px;
            display: inline-block;
        }

        .disetujui-background {
            background-color: #00ff00;
            border-radius: 5px;
            padding: 3px 8px;
            display: inline-block;
        }

        .ditolak-background {
            background-color: #ff0000;
            border-radius: 5px;
            color: white;
            padding: 3px 8px;
        }

        .dikirim-background {
            background-color: #ffff00;
            border-radius: 5px;
            color: white;
            padding: 3px 8px;
        }
    </style>

    <div class="container-fluid px-4">
        <h1 class="mt-4">Laporan Penyewaan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Laporan Penyewaan</li>
        </ol>

        <div class="card mb-4">
            <div class="card-body">
                <a href="{{ route('report.penyewaan.pdf') }}" type="button" class="btn btn-primary btn-sm mb-3">Export
                    PDF</a>
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Barang</th>
                            <th>Pelanggan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Barang</th>
                            <th>Pelanggan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($penyewaans as $penyewaan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $penyewaan->barang->nama_barang }}</td>
                                <td>
                                    @if ($penyewaan->pelanggan)
                                        {{ $penyewaan->pelanggan->name }}
                                    @else
                                        {{ $penyewaan->user->name }}
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($penyewaan->tgl_mulai)->locale('id_ID')->isoFormat('D MMMM YYYY') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($penyewaan->tgl_selesai)->locale('id_ID')->isoFormat('D MMMM YYYY') }}
                                </td>
                                <td>
                                    @if ($penyewaan->pengembalian)
                                        {{ \Carbon\Carbon::parse($penyewaan->pengembalian->tgl_pengembalian)->locale('id_ID')->isoFormat('D MMMM YYYY') }}
                                    @else
                                        Belum dikembalikan
                                    @endif
                                </td>
                                <td>{{ $penyewaan->jumlah }}</td>
                                <td>{{ $penyewaan->total_harga }}</td>
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
