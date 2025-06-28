@extends('layout.be.template')
@section('title', 'Edit User')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Edit User</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
                <li class="breadcrumb-item active">Edit User</li>
            </ol>
            <div class="row">
                <form action="{{ route('user.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama User</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $user->name }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email"
                            value="{{ $user->email }}">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Password minimal 8">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i>
                            Simpan</button>
                        <a href="{{ route('user.index') }}" type="button" class="btn btn-danger btn-sm"><i
                                class="fa-solid fa-xmark"></i> Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
