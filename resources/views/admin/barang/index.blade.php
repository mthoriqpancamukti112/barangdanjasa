@extends('layout.be.template')
@section('title', 'Barang')
@section('content')
    <link rel="stylesheet" href="/backend/css/bootstrap.min.css">
    <link rel="stylesheet" href="/backend/css/dataTables.bootstrap5.min.css">
    <style>
        .table-responsive {
            overflow-x: auto;
        }

        #barang-table th,
        #barang-table td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Barang</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Barang</li>
            </ol>

            <div class="card-body">
                <a href="{{ route('barang.create') }}" type="button" class="btn btn-success btn-sm mb-3"><i
                        class="fa-solid fa-plus"></i> Tambah</a>
                <div class="table-responsive">
                    <table id="barang-table" class="table table-bordered table-striped dataTable" deferRender="true">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Deskripsi</th>
                                <th>Bisa Disewa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <script src="/backend/js/jquery-3.5.1.js"></script>
    <script src="/backend/js/jquery.dataTables.min.js"></script>
    <script src="/backend/js/dataTables.bootstrap5.min.js"></script>
    <script src="/backend/js/sweetalert2@10.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#barang-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('barang.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        render: function(data, type, full, meta) {
                            return '<img src="/gambar_barang/' + data +
                                '" class="img-thumbnail" style="width:100px;height:auto">';
                        }
                    },
                    {
                        data: 'nama_barang',
                        name: 'nama_barang'
                    },
                    {
                        data: 'harga_barang',
                        name: 'harga_barang'
                    },
                    {
                        data: 'stok',
                        name: 'stok'
                    },
                    {
                        data: 'deskripsi',
                        name: 'deskripsi'
                    },
                    {
                        data: 'bisa_disewa',
                        name: 'bisa_disewa',
                        render: function(data, type, full, meta) {
                            return data ? 'Ya' : 'Tidak';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $(document).on('click', '.delete-btn', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin/barang/" + id,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Terhapus!',
                                    'Data berhasil dihapus.',
                                    'success'
                                );
                                $('#barang-table').DataTable().ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
