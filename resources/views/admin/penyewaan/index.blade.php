@extends('layout.be.template')

@section('title', 'Data Penyewaan')

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
        <h1 class="mt-4">Data Penyewaan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Data Penyewaan</li>
        </ol>

        <div class="card mb-4">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Barang</th>
                            <th>Pelanggan</th>
                            <th>No HP</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Barang</th>
                            <th>Pelanggan</th>
                            <th>No HP</th>
                            <th>Status</th>
                            <th>Aksi</th>
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
                                <td>{{ $penyewaan->pelanggan->no_hp }}</td>
                                <td>
                                    <span
                                        class="status
                                        @if ($penyewaan->status == 'pending') pending-background
                                        @elseif ($penyewaan->status == 'disetujui') disetujui-background
                                        @elseif ($penyewaan->status == 'ditolak') ditolak-background
                                        @elseif ($penyewaan->status == 'selesai') selesai-background
                                        @elseif ($penyewaan->status == 'dikirim') dikirim-background @endif">
                                        {{ $penyewaan->status }}
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#detailModal{{ $penyewaan->id }}">
                                        Lihat Detail
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#updateStatusModal" data-id="{{ $penyewaan->id }}"
                                        data-status="{{ $penyewaan->status }}">
                                        Ubah Status
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Update Status -->
    <div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="updateStatusForm" method="POST" action="{{ route('admin.penyewaan.update-status', 0) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateStatusModalLabel">Ubah Status Penyewaan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="penyewaan_id" id="penyewaan_id">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="pending">Pending</option>
                                <option value="disetujui">Disetujui</option>
                                <option value="ditolak">Ditolak</option>
                                <option value="dikirim">Dikirim</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($penyewaans as $penyewaan)
        <!-- Modal Detail Penyewaan -->
        <div class="modal fade" id="detailModal{{ $penyewaan->id }}" tabindex="-1" role="dialog"
            aria-labelledby="detailModalLabel{{ $penyewaan->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel{{ $penyewaan->id }}">Detail Penyewaan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-4">
                                    <p><strong>Pelanggan:</strong>
                                        {{ $penyewaan->pelanggan ? $penyewaan->pelanggan->name : $penyewaan->user->name }}
                                    </p>
                                    <p><strong>No HP:</strong> {{ $penyewaan->pelanggan->no_hp }}</p>
                                    <p><strong>Barang:</strong> {{ $penyewaan->barang->nama_barang }}</p>
                                    <p><strong>Jumlah:</strong> {{ $penyewaan->jumlah }}</p>
                                    <p><strong>Total Harga:</strong>
                                        {{ 'Rp ' . number_format($penyewaan->total_harga, 0, ',', '.') }}
                                    </p>
                                    <p><strong>No HP:</strong>
                                        {{ $penyewaan->pelanggan ? $penyewaan->pelanggan->no_hp : '-' }}</p>
                                    <p><strong>Tanggal Mulai:</strong>
                                        {{ \Carbon\Carbon::parse($penyewaan->tgl_mulai)->locale('id_ID')->isoFormat('D MMMM YYYY') }}
                                    </p>
                                    <p><strong>Tanggal Selesai:</strong>
                                        {{ \Carbon\Carbon::parse($penyewaan->tgl_selesai)->locale('id_ID')->isoFormat('D MMMM YYYY') }}
                                    </p>
                                    <p><strong>Tanggal Pengembalian:</strong>
                                        @if ($penyewaan->pengembalian)
                                            {{ \Carbon\Carbon::parse($penyewaan->pengembalian->tgl_pengembalian)->locale('id_ID')->isoFormat('D MMMM YYYY') }}
                                        @else
                                            Belum dikembalikan
                                        @endif
                                    </p>
                                    <p><strong>Status:</strong> <span
                                            class="status
                                    @if ($penyewaan->status == 'pending') pending-background
                                    @elseif ($penyewaan->status == 'disetujui') disetujui-background
                                    @elseif ($penyewaan->status == 'ditolak') ditolak-background
                                    @elseif ($penyewaan->status == 'selesai') selesai-background
                                    @elseif ($penyewaan->status == 'dikirim') dikirim-background @endif">
                                            {{ $penyewaan->status }}
                                        </span></p>
                                </div>
                                <div class="col-md-4">
                                    @if ($penyewaan->pembayaran)
                                        <p><strong>Metode Pembayaran:</strong>
                                            {{ $penyewaan->pembayaran->metodePembayaran->name_metode }}</p>
                                        <p><strong>Total Pembayaran:</strong>
                                            {{ 'Rp ' . number_format($penyewaan->pembayaran->total_pembayaran, 0, ',', '.') }}
                                        </p>
                                        <p><strong>Bukti Pembayaran</strong></p>
                                        @if ($penyewaan->pembayaran->bukti_pembayaran)
                                            <a href="{{ asset('bukti_pembayaran/' . $penyewaan->pembayaran->bukti_pembayaran) }}"
                                                data-lightbox="bukti_pembayaran{{ $penyewaan->id }}">
                                                <img src="{{ asset('bukti_pembayaran/' . $penyewaan->pembayaran->bukti_pembayaran) }}"
                                                    class="img-fluid" alt="Bukti Pembayaran">
                                            </a>
                                        @else
                                            <p>Tidak ada bukti pembayaran.</p>
                                        @endif
                                    @else
                                        <p>Belum ada data pembayaran.</p>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    @if ($penyewaan->pengiriman)
                                        <p><strong>Alamat Pengiriman:</strong>
                                            {{ $penyewaan->pengiriman->alamat }}
                                        </p>
                                    @else
                                        <p>Belum ada data pengiriman.</p>
                                    @endif
                                </div>
                            </div>
                            <!-- Add additional columns for other related data such as pelanggan, pengembalian, pembayaran -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {

            $(document).ready(function() {
                // Event handler untuk Modal Update Status
                $('#updateStatusModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var id = button.data('id');
                    var status = button.data('status');
                    var modal = $(this);
                    modal.find('#penyewaan_id').val(id);
                    modal.find('#status').val(status);
                    modal.find('form').attr('action',
                        '{{ route('admin.penyewaan.update-status', '') }}/' + id);
                });
            });
        });
    </script>
@endsection
