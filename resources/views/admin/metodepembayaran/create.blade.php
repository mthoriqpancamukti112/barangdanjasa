@extends('layout.be.template')
@section('title', 'Tambah Metode Pembayaran')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tambah Metode Pembayaran</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('metodepembayaran.index') }}">Metode Pembayaran</a></li>
                <li class="breadcrumb-item active">Tambah Metode Pembayaran</li>
            </ol>
            <div class="row">
                <form action="{{ route('metodepembayaran.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name_metode" class="form-label">Metode Pembayaran</label>
                        <input type="text" class="form-control @error('name_metode') is-invalid @enderror"
                            id="name_metode" name="name_metode" value="{{ old('name_metode') }}">
                        @error('name_metode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="detail" class="form-label">Keterangan</label>
                        <input type="text" class="form-control @error('detail') is-invalid @enderror" id="detail"
                            name="detail" value="{{ old('detail') }}">
                        @error('detail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
