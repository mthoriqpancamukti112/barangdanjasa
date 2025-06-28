<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrasi</title>
    <link rel="stylesheet" href="/backend/css/bootstrap.min.css">
    <style>
        body {
            background: rgb(120, 197, 214);
            background: linear-gradient(90deg, rgba(120, 197, 214, 1) 0%, rgba(78, 115, 223, 1) 100%);
        }

        .card {
            position: relative;
        }

        .center-button {
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>
</head>

<body>
    <section>
        <div class="container" style="margin-top: 50px;">
            <div class="row">
                <div class="col-md-5 mx-auto">
                    <div class="card">
                        <div class="card">
                            <div class="d-flex justify-content-center align-items-center m-2">
                                <div class="col-md-4">
                                    <img src="/img/logo.png" alt="" style="width: auto; margin-right: 1rem"
                                        height="100px">
                                </div>
                                <div class="col-md-8">
                                    <h3>REGISTRASI USER</h3>
                                </div>
                            </div>
                        </div>
                        <span class="text-center mt-3">Silahkan Isi Data Dibawah Ini!</span>
                        <div class="container">
                            <div class="card-body">
                                <form method="POST" class="form-register" action="{{ route('pelanggan.register') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') }}"
                                            placeholder="Nama lengkap">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                                            id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                                            placeholder="No hp">
                                        @error('no_hp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                            id="jenis_kelamin" name="jenis_kelamin">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki"
                                                {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                            </option>
                                            <option value="Perempuan"
                                                {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                            </option>
                                        </select>
                                        @error('jenis_kelamin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control @error('alamat') is-invalid @enderror"
                                            id="alamat" name="alamat" value="{{ old('alamat') }}"
                                            placeholder="Alamat lengkap">
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}"
                                            placeholder="Email aktif">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror" id="password"
                                            name="password" placeholder="Password minimal 8">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm mt-2 btn-block center-button"
                                        style="width: 20%">Daftar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="/backend/js/bootstrap.bundle.min.js"></script>
</body>

</html>
