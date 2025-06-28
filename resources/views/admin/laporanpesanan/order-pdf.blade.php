<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pemesanan</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        a,
        span,
        li,
        div,
        td,
        th {
            font-family: 'Poppins', sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th {
            text-align: center;
        }

        td {
            padding: 8px;
            text-align: left;
        }

        thead {
            background-color: #f2f2f2;
        }

        tfoot {
            background-color: #f9f9f9;
            text-align: right;
        }

        .header-container {
            display: flex;
            align-items: center;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
        }

        .header-container img {
            height: 100px;
            margin-right: 20px;
        }

        .header-container .text-center {
            text-align: center;
            flex-grow: 1;
        }

        .total-row {
            border-top: 2px solid black;
        }
    </style>
</head>

<body>
    <h2 class="header-container">
        <img src="{{ $base64 }}" alt="Logo PT">
        <div class="text-center">
            <span>LAPORAN PEMESANAN</span><br>
            <span>PT ISTANA KARYA MANAGEMENT</span>
        </div>
    </h2>
    <table>
        <thead style="text-align: center;">
            <tr>
                <th>No</th>
                <th>Customer</th>
                <th>Metode Pembayaran</th>
                {{-- <th>Sub Total</th> --}}
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pemesanans as $pemesanan)
                @foreach ($pemesanan->details as $detail)
                    <tr>
                        <td>{{ $loop->parent->iteration }}</td>
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
                                    <strong>Alamat:</strong>
                                    @if ($pemesanan->pengiriman)
                                        {{ $pemesanan->pengiriman->alamat }}
                                    @endif
                                </p>
                            </div>
                        </td>
                        <td>{{ $pemesanan->metodePembayaran->name_metode }}</td>
                        {{-- <td>{{ $pemesanan->total_harga }}</td> --}}
                        <td>{{ \Carbon\Carbon::parse($pemesanan->tgl_pemesanan)->locale('id_ID')->isoFormat('D MMMM YYYY') }}
                        </td>
                        <td>{{ $detail->barang->nama_barang }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>{{ number_format($detail->barang->harga_barang, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="6"><strong>Total:</strong></td>
                <td>{{ number_format($totalBayarSemua, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
