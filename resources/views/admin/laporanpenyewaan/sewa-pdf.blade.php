<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penyewaan</title>
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
            <span>LAPORAN PENYEWAAN</span><br>
            <span>PT ISTANA KARYA MANAGEMENT</span>
        </div>
    </h2>
    <table>
        <thead style="text-align: center;">
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Customer</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Tanggal Pengembalian</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
            </tr>
        </thead>
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
        <tfoot>
            <tr class="total-row">
                <td colspan="7"><strong>Total:</strong></td>
                <td>{{ number_format($totalBayarSemua, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
