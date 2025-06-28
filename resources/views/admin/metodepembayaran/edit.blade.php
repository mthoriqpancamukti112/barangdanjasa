@extends('layout.be.template')
@section('title', 'Edit Metode Pembayaran')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Edit Metode Pembayaran</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('metodepembayaran.index') }}">Metode Pembayaran</a></li>
                <li class="breadcrumb-item active">Edit Metode Pembayaran</li>
            </ol>
            <div class="row">
                <form action="{{ route('metodepembayaran.update', $metodepembayaran->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="name_metode" class="form-label">Metode Pembayaran</label>
                        <input type="text" class="form-control" id="name_metode" name="name_metode"
                            value="{{ $metodepembayaran->name_metode }}">
                    </div>
                    <div class="mb-3">
                        <label for="detail" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="detail" name="detail"
                            value="{{ $metodepembayaran->detail }}">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i>
                            Simpan</button>
                        <a href="{{ route('metodepembayaran.index') }}" type="button" class="btn btn-danger btn-sm"><i
                                class="fa-solid fa-xmark"></i> Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
