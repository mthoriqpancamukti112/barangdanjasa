@extends('layout.fe.template')
@section('title', 'Detail Pemesanan')
@section('content')
    <style>
        .status {
            background-color: #f0f0f0;
            padding: 3px 8px;
            border-radius: 5px;
            display: inline-block;
        }

        .proses-background {
            background-color: #ffff00;
            border-radius: 5px;
            padding: 3px 8px;
            display: inline-block;
        }

        .dikirim-background {
            background-color: #00ff00;
            border-radius: 5px;
            padding: 3px 8px;
            display: inline-block;
        }

        .selesai-background {
            background-color: #008000;
            color: white;
            border-radius: 5px;
            padding: 3px 8px;
        }

        .mb-5 {
            margin-bottom: 3rem;
        }
    </style>
    @include('layout.fe.top-nav-buttom')
    <div class="container">
        @if ($pemesanans->isNotEmpty())
            <h3 class="text-center mt-5 mb-4"><i class="fas fa-shopping-cart"></i> Detail Pesanan Anda</h3>
        @endif
        @forelse ($pemesanans as $pemesanan)
            <div class="card mb-5">
                <div class="card-header" style="background: #4F200D; color: white">
                    <h5 class="card-title text-center"><i class="fas fa-clipboard"></i> Pesanan ID: {{ $pemesanan->id }}
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table text-center">
                        <thead style="background: #FFD93D">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pemesanan->details as $index => $detail)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $detail->barang->nama_barang }}</td>
                                    <td>{{ $detail->barang->harga_barang }}</td>
                                    <td>{{ $detail->jumlah }}</td>
                                    <td>Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card mt-4">
                                <div class="card-header text-center" style="background: #4F200D; color: white">
                                    <i class="fas fa-info-circle"></i> Informasi Pemesanan
                                </div>
                                <div class="card-body">
                                    <label for="" style="font-weight: bold"><i class="fas fa-money-bill-wave"></i>
                                        Total Harga</label><br>
                                    <span>Rp. {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</span>
                                    <div class="mt-3">
                                        <label for="">Status: </label>
                                        <span
                                            class="status {{ $pemesanan->status == 'Proses' ? 'proses-background' : '' }}
                            {{ $pemesanan->status == 'Dikirim' ? 'dikirim-background' : '' }}
                            {{ $pemesanan->status == 'Selesai' ? 'selesai-background' : '' }}">
                                            @if ($pemesanan->status == 'Proses')
                                                <i class="fas fa-hourglass-half"></i>
                                            @elseif($pemesanan->status == 'Dikirim')
                                                <i class="fas fa-truck"></i>
                                            @elseif($pemesanan->status == 'Selesai')
                                                <i class="fas fa-check-circle"></i>
                                            @endif
                                            {{ $pemesanan->status }}
                                        </span><br>

                                        @if ($pemesanan->status === 'Dikirim')
                                            <span><i class="fas fa-info-circle"></i> Jika produk sudah diterima harap
                                                selesaikan pesanan anda</span>
                                            <form action="{{ route('pemesanan.selesai', ['id' => $pemesanan->id]) }}"
                                                method="POST" class="mt-2">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-primary btn-sm"><i
                                                        class="fas fa-check"></i>
                                                    Selesaikan</button>
                                            </form>
                                        @endif

                                    </div>
                                    <div class="mt-3">
                                        <label for="" style="font-weight: bold"><i class="fas fa-calendar-alt"></i>
                                            Tanggal Pemesanan</label><br>
                                        <span>{{ \Carbon\Carbon::parse($pemesanan->tgl_pemesanan)->isoFormat('D MMMM YYYY') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-4">
                                <div class="card-header text-center" style="background: #4F200D; color: white">
                                    <i class="fas fa-shipping-fast"></i> Informasi Pengiriman
                                </div>
                                <div class="card-body">
                                    @if ($pemesanan->pengiriman)
                                        @if ($pemesanan->pengiriman->user)
                                            <div class="form-group">
                                                <label for=""><i class="fas fa-user"></i> Nama Customer</label>
                                                <span>{{ $pemesanan->pengiriman->user->name }}</span>
                                            </div>
                                        @elseif ($pemesanan->pengiriman->pelanggan)
                                            <div class="form-group">
                                                <label for="" style="font-weight: bold"><i class="fas fa-user"></i>
                                                    Nama Customer</label><br>
                                                <span>{{ $pemesanan->pengiriman->pelanggan->name }}</span>
                                            </div>
                                        @else
                                            <span><i class="fas fa-info-circle"></i> Informasi pengiriman belum
                                                tersedia.</span>
                                        @endif
                                        <label for="" style="font-weight: bold"><i
                                                class="fas fa-map-marker-alt"></i> Alamat Pengiriman</label><br>
                                        <span>{{ $pemesanan->pengiriman->alamat }}</span>
                                    @else
                                        <p><i class="fas fa-info-circle"></i> Informasi pengiriman belum tersedia.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card mt-4">
                                @if ($pemesanan->pembayaran)
                                    <div class="card-header text-center" style="background: #4F200D; color: white">
                                        <i class="fas fa-receipt"></i> Bukti Pembayaran
                                    </div>
                                    <div class="card-body">
                                        <img src="/bukti_pembayaran/{{ $pemesanan->pembayaran->bukti_pembayaran }}"
                                            width="50%" alt="Bukti Pembayaran" class="rounded">
                                    </div>
                                @else
                                    <div class="card-header text-center" style="background: #4F200D; color: white">
                                        <i class="fas fa-money-check-alt"></i> Informasi Pembayaran
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('pembayaran.store', ['id' => $pemesanan->id]) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="" style="font-weight: bold"><i
                                                        class="fas fa-credit-card"></i> Metode
                                                    Pembayaran</label><br>
                                                <span>{{ $pemesanan->metodePembayaran->name_metode }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="" style="font-weight: bold"><i
                                                        class="fas fa-info-circle"></i> Harap Melakukan Pembayaran
                                                    Melalui
                                                    Keterangan Dibawah ini</label><br>
                                                <span>{{ $pemesanan->metodePembayaran->detail }}</span>
                                            </div>
                                            {{-- Tampilkan elemen upload_pembayaran jika bukan COD --}}
                                            @if ($pemesanan->metodePembayaran->name_metode != 'Cash on Delivery (COD)')
                                                <div class="form-group" id="upload_pembayaran">
                                                    <label for="bukti_pembayaran">Upload Bukti Pembayaran</label>
                                                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran"
                                                        accept="bukti_pembayaran/*" value="{{ old('bukti_pembayaran') }}"
                                                        class="form-control-file @error('bukti_pembayaran') is-invalid @enderror">
                                                    @error('bukti_pembayaran')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-sm"><i
                                                        class="fas fa-upload"></i>
                                                    Bayar sekarang</button>
                                            @endif
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center" style="margin-top: 10px; margin-bottom: 100px">
                <span>
                    <img src="/img/cart.jpg" alt="" style="width: 300px; height: 300px"></span><br>
                <span>Yahh, detail pesananmu belum ada nih, pesan dulu yuk!</span>
            </div>
        @endforelse
    </div>
@endsection
