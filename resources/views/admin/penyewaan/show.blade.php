@extends('layout.be.template')

@section('title', 'Detail Penyewaan')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <div class="container-fluid px-4">
        <h1 class="mt-4">Detail Penyewaan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.penyewaan.index') }}">Data Penyewaan</a></li>
            <li class="breadcrumb-item active">Detail Penyewaan</li>
        </ol>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Informasi Penyewaan</h5>
                <p><strong>Barang:</strong> {{ $penyewaan->barang->nama_barang }}</p>
                <p><strong>Pelanggan:</strong>
                    {{ $penyewaan->pelanggan ? $penyewaan->pelanggan->name : $penyewaan->user->name }}</p>
                <p><strong>Tanggal Mulai:</strong>
                    {{ \Carbon\Carbon::parse($penyewaan->tgl_mulai)->locale('id_ID')->isoFormat('D MMMM YYYY') }}</p>
                <p><strong>Tanggal Selesai:</strong>
                    {{ \Carbon\Carbon::parse($penyewaan->tgl_selesai)->locale('id_ID')->isoFormat('D MMMM YYYY') }}</p>
                <p><strong>Jumlah:</strong> {{ $penyewaan->jumlah }}</p>
                <p><strong>Total Harga:</strong> Rp. {{ number_format($penyewaan->total_harga, 0, ',', '.') }}</p>
                <p><strong>Status:</strong>
                    <span
                        class="status
                    @if ($penyewaan->status == 'pending') pending-background
                    @elseif ($penyewaan->status == 'disetujui') disetujui-background
                    @elseif ($penyewaan->status == 'ditolak') ditolak-background @endif">
                        {{ $penyewaan->status }}
                    </span>
                </p>
                @if ($penyewaan->status == 'disetujui' && $penyewaan->pembayaran)
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#viewPaymentModal">
                        Lihat Bukti Pembayaran
                    </button>
                @endif
            </div>
        </div>

        <!-- Modal View Payment -->
        <div class="modal fade" id="viewPaymentModal" tabindex="-1" role="dialog" aria-labelledby="viewPaymentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewPaymentModalLabel">Bukti Pembayaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img id="paymentImage" src="{{ $penyewaan->pembayaran->bukti_pembayaran_url }}"
                                    class="img-fluid lightbox-image" data-lightbox="payment" />
                            </div>
                            <div class="col-md-6">
                                <p><strong>Pelanggan:</strong> {{ $penyewaan->pelanggan->name }}</p>
                                <p><strong>Total Pembayaran:</strong> Rp.
                                    {{ number_format($penyewaan->pembayaran->total_pembayaran, 0, ',', '.') }}</p>
                                <p><strong>Alamat Pengiriman:</strong> {{ $penyewaan->pembayaran->alamat_pengiriman }}</p>
                                <p><strong>Metode Pembayaran:</strong>
                                    {{ $penyewaan->pembayaran->metodePembayaran->name_metode }}</p>
                                <p><strong>Detail Pembayaran:</strong> {{ $penyewaan->pembayaran->detail_pembayaran }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.penyewaan.update-status', $penyewaan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="status">Ubah Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="pending" {{ $penyewaan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="disetujui" {{ $penyewaan->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ $penyewaan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="dikirim" {{ $penyewaan->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.penyewaan.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#viewPaymentModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var modal = $(this);
                var imageUrl = button.data('image');
                modal.find('#paymentImage').attr('src', imageUrl);
            });
        });
    </script>
@endsection
