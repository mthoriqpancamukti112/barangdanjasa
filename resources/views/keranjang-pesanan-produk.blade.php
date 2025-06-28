@extends('layout.fe.template')
@section('title', 'Keranjang Pemesanan')
@section('content')
    <style>
        #datatablesSimple th,
        #datatablesSimple td {
            width: auto !important;
            white-space: nowrap;
            text-align: center;
        }

        .icon-spacing {
            margin-right: 5px;
        }
    </style>

    @include('layout.fe.top-nav-buttom')

    <div class="container-fluid px-4">
        @if ($pesanan->isEmpty())
            <center>
                <div style="margin-top: 10px; margin-bottom: 100px">
                    <img src="/img/keranjang.png" alt="Keranjang" style="width: 300px; height: 300px"><br>
                    <span style="font-size: 24px; font-weight: bold">
                        Wahh, keranjang pesananmu masih kosong
                    </span><br>
                    <span>Yuk, isi keranjangmu sekarang, cek di daftar produk</span>
                </div>
            </center>
        @else
            <div class="card-body table-responsive">
                <table id="datatablesSimple" class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Harga Barang</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tfoot class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Harga Barang</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Opsi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($pesanan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>Rp. {{ number_format($item->harga_barang, 0, ',', '.') }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>Rp. {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('keranjang.pesanan.edit', $item->id) }}"
                                            class="btn btn-warning btn-sm icon-spacing">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('keranjang.pesanan.destroy', $item->id) }}" method="POST"
                                            class="ml-1" id="delete-form-{{ $item->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm delete-btn"
                                                data-id="{{ $item->id }}">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <span style="font-size: 18px"><strong>Total Belanja</strong></span><br>
                <div class="input-group">
                    <input type="text" name="total_belanja" class="form-control"
                        value="Rp. {{ number_format($total_belanja, 0, ',', '.') }}"
                        style="background: #FFD93D; color: black; font-size: 24px" readonly>
                </div>
            </div>

            <div class="d-flex mt-4">
                <a href="{{ route('produk.index') }}" class="btn btn-primary btn-sm mr-3">
                    <i class="fas fa-store"></i> Lihat Katalog
                </a>
                <button id="order-button" class="btn btn-primary btn-sm">
                    <i class="fas fa-shopping-bag"></i> Order Sekarang
                </button>
            </div>
        @endif
    </div>

    <script>
        document.getElementById('order-button').addEventListener('click', function() {
            @if ($pesanan->isEmpty())
                Swal.fire({
                    icon: 'warning',
                    title: 'Keranjang Kosong',
                    text: 'Keranjang belanja Anda kosong. Silakan tambahkan produk sebelum melanjutkan ke pemesanan.'
                });
            @else
                window.location.href = "{{ route('checkout.index') }}";
            @endif
        });
    </script>

    {{-- Jika ingin tombol hapus muncul sweetalert --}}
    {{-- <script src="/frontend/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.delete-btn').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Anda tidak akan dapat mengembalikannya!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#delete-form-' + id).submit();
                    }
                });
            });
        });
    </script> --}}
@endsection
