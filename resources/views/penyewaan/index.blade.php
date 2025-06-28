@extends('layout.fe.template')
@section('title', 'Daftar Penyewaan')
<style>
    .status-pending {
        color: white;
        background-color: grey;
        padding: 2px 5px;
        border-radius: 3px;
    }

    .status-disetujui {
        color: white;
        background-color: #28a745;
        padding: 2px 5px;
        border-radius: 3px;
    }

    .status-dikirim {
        color: white;
        background-color: #ffc107;
        padding: 2px 5px;
        border-radius: 3px;
    }

    .status-selesai {
        color: white;
        background-color: #007bff;
        padding: 2px 5px;
        border-radius: 3px;
    }

    .status-dibatalkan {
        color: white;
        background-color: #dc3545;
        padding: 2px 5px;
        border-radius: 3px;
    }
</style>
@section('content')

    @include('layout.fe.top-nav-buttom')

    <div class="container" style="margin-top: 100px">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($penyewaans->isEmpty())
            <p>Belum ada penyewaan.</p>
        @else
            <div class="table-responsive">
                <table id="datatablesSimple" class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Barang</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penyewaans as $penyewaan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $penyewaan->barang->nama_barang }}</td>
                                <td>{{ \Carbon\Carbon::parse($penyewaan->tgl_mulai)->locale('id_ID')->isoFormat('D MMMM YYYY') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($penyewaan->tgl_selesai)->locale('id_ID')->isoFormat('D MMMM YYYY') }}
                                </td>
                                <td>{{ $penyewaan->jumlah }}</td>
                                <td>Rp. {{ number_format($penyewaan->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    @if ($penyewaan->status == 'disetujui')
                                        <span class="status-disetujui">{{ ucfirst($penyewaan->status) }}</span>
                                    @elseif($penyewaan->status == 'pending')
                                        <span class="status-pending">{{ ucfirst($penyewaan->status) }}</span>
                                    @elseif($penyewaan->status == 'dikirim')
                                        <span class="status-dikirim">{{ ucfirst($penyewaan->status) }}</span>
                                    @elseif($penyewaan->status == 'selesai')
                                        <span class="status-selesai">{{ ucfirst($penyewaan->status) }}</span>
                                    @elseif($penyewaan->status == 'dibatalkan')
                                        <span class="status-dibatalkan">{{ ucfirst($penyewaan->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($penyewaan->status == 'disetujui')
                                        @if ($penyewaan->is_payed)
                                            <span class="text-success">Sudah Dibayar</span>
                                        @else
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#paymentModal" data-id="{{ $penyewaan->id }}"
                                                data-totalharga="{{ $penyewaan->total_harga }}">Isi Pembayaran</button>
                                        @endif
                                    @elseif($penyewaan->status == 'dikirim')
                                        <form action="{{ route('pelanggan.penyewaan.selesai', $penyewaan->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-success btn-sm">Update Barang
                                                Sampai</button>
                                        </form>
                                    @elseif($penyewaan->status == 'selesai')
                                        @if ($penyewaan->barang_dikembalikan)
                                            <span class="text-muted">Barang Sudah Dikembalikan</span>
                                        @else
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#returnModal" data-id="{{ $penyewaan->id }}">
                                                Kembalikan Barang
                                            </button>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5"><strong>Total Harga Semua Penyewaan</strong></td>
                            <td colspan="3"><strong>Rp.
                                    {{ number_format($totalHargaSemuaPenyewaan, 0, ',', '.') }}</strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    </div>

    <!-- Modal Pembayaran -->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="paymentForm" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Isi Pembayaran dan Pengiriman</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="penyewaan_id" id="penyewaan_id">
                        <div class="form-group">
                            <label for="metode_pembayaran">Metode Pembayaran</label>
                            <select name="metode_pembayaran" id="metode_pembayaran" class="form-control">
                                <option value="" disabled selected>Pilih Metode Pembayaran</option>
                                @foreach ($metodePembayaran as $metode)
                                    <option value="{{ $metode->id }}" data-detail="{{ $metode->detail }}">
                                        {{ $metode->name_metode }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="detail_pembayaran">Detail Metode Pembayaran</label>
                            <textarea class="form-control" id="detail_pembayaran" readonly></textarea>
                        </div>
                        <div class="form-group">
                            <label for="total_pembayaran">Total Pembayaran</label>
                            <input type="number" class="form-control" name="total_pembayaran" id="total_pembayaran"
                                required readonly>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat Pengiriman</label>
                            <textarea name="alamat" id="alamat" class="form-control" required></textarea>
                        </div>
                        <div class="form-group" id="buktiPembayaranGroup" style="display: none;">
                            <label for="bukti_pembayaran">Bukti Pembayaran</label>
                            <input type="file" class="form-control" name="bukti_pembayaran" id="bukti_pembayaran">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Pengembalian -->
    <div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="returnModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="returnForm" method="POST" action="{{ route('pelanggan.pengembalian.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="returnModalLabel">Kembalikan Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="penyewaan_id" id="return_penyewaan_id">
                        <div class="form-group">
                            <label for="tgl_pengembalian">Tanggal Pengembalian</label>
                            <input type="date" class="form-control" name="tgl_pengembalian" id="tgl_pengembalian"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="kondisi_barang">Kondisi Barang</label>
                            <textarea class="form-control" name="kondisi_barang" id="kondisi_barang" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Kembalikan Barang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include jQuery, DataTables CSS and JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#paymentModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var modal = $(this);
                modal.find('#penyewaan_id').val(id);
                modal.find('form').attr('action', '{{ url('pelanggan/penyewaan/pembayaran') }}/' + id);

                // Mengatur nilai total_harga ke dalam total_pembayaran
                var totalHarga = button.data(
                    'totalharga'); // Pastikan Anda menyertakan data 'totalharga' saat memanggil modal
                modal.find('#total_pembayaran').val(totalHarga);
            });

            $('#jumlah').on('input', function() {
                var jumlah = $(this).val();
                var hargaBarang = $('#harga_barang')
                    .val(); // Pastikan ada input hidden atau elemen dengan id 'harga_barang'
                var totalPembayaran = jumlah * hargaBarang;
                $('#total_pembayaran').val(totalPembayaran);
            });

            $('#metode_pembayaran').on('change', function() {
                var detail = $(this).find(':selected').data('detail');
                $('#detail_pembayaran').val(detail);

                if ($(this).val() == '1') {
                    $('#bukti_pembayaran').closest('.form-group').hide();
                    $('#bukti_pembayaran').prop('required', false);
                } else {
                    $('#bukti_pembayaran').closest('.form-group').show();
                    $('#bukti_pembayaran').prop('required', true);
                }

            });

            $('#returnModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var modal = $(this);
                modal.find('#return_penyewaan_id').val(id);
                modal.find('form').attr('action', '{{ route('pelanggan.pengembalian.store') }}');
            });
        });
    </script>
@endsection
