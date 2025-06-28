@extends('layout.fe.template')
@section('title', 'Checkout')
@section('content')

    <div class="container">
        <h3 class="text-center mt-5 mb-4"><i class="fas fa-clipboard-check"></i> Checkout</h3>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <table class="table text-center">
                <thead style="background: #FFD93D">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Harga Barang</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($keranjang as $item)
                        <tr>
                            <td>{{ $item->nama_barang }}</td>
                            <td>Rp. {{ number_format($item->harga_barang, 0, ',', '.') }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>Rp. {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="form-group">
                <label for="metode_pembayaran"><i class="fas fa-credit-card"></i> Metode Pembayaran</label>
                <select name="id_metode_pembayaran" id="metode_pembayaran" class="form-control" required>
                    <option value="">Pilih Metode Pembayaran</option>
                    @foreach ($metode_pembayaran as $metode)
                        <option value="{{ $metode->id }}" data-detail="{{ $metode->detail }}"
                            {{ old('id_metode_pembayaran') == $metode->id ? 'selected' : '' }}>
                            {{ $metode->name_metode }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mt-3" id="detail_metode_pembayaran" style="display: none;">
                <label for="detail"><i class="fas fa-info-circle"></i> Detail Metode Pembayaran</label><br>
                <input name="detail" id="detail" class="form-control" readonly value="{{ old('detail') }}">
            </div>

            <div class="form-group mt-3" id="alamat_pengiriman">
                <label for="alamat"><i class="fas fa-map-marker-alt"></i> Masukkan Alamat Pengiriman Lengkap Anda</label>
                <textarea name="alamat" id="alamat" class="form-control" placeholder="Masukkan alamat pengiriman">{{ old('alamat') }}</textarea>

                @error('alamat')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group mt-3 text-right">
                <span style="font-size: 18px"><i class="fas fa-money-bill-wave"></i> Total Bayar</span><br>
                <span style="font-size: 32px; font-weight: bold; color: orange">
                    {{ number_format($total_harga, 0, ',', '.') }}
                </span>
            </div>

            <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fas fa-cart-arrow-down"></i> Pesan
                Sekarang</button>
            <a href="{{ route('detail.pemesanan.index') }}" class="btn btn-warning btn-sm btn-block">Cek Pesanan</a>
            <a href="{{ route('keranjang.pesanan.index') }}" class="btn btn-danger btn-sm btn-block"><i
                    class="fas fa-arrow-circle-left"></i> Kembali Ke Keranjang</a>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const metodePembayaranSelect = document.getElementById('metode_pembayaran');
            const detailMetodePembayaran = document.getElementById('detail_metode_pembayaran');
            const detailTextarea = document.getElementById('detail');

            metodePembayaranSelect.addEventListener('change', function() {
                const selectedOption = metodePembayaranSelect.options[metodePembayaranSelect.selectedIndex];
                const detail = selectedOption.getAttribute('data-detail');

                if (detail) {
                    detailMetodePembayaran.style.display = 'block';
                    detailTextarea.value = detail;
                } else {
                    detailMetodePembayaran.style.display = 'none';
                    detailTextarea.value = '';
                }
            });

            // Trigger change event to set initial state based on old value
            metodePembayaranSelect.dispatchEvent(new Event('change'));
        });
    </script>

    {{-- Pesan eror jika ingin menggunakan sweetalert --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cek apakah ada pesan error
            const errorMessage = '{{ session('error') }}';

            // Jika ada pesan error, tampilkan SweetAlert
            if (errorMessage) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errorMessage
                });
            }
        });
    </script> --}}
@endsection
