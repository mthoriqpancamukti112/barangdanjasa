<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
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
                                    <h3>LOGIN ADMIN</h3>
                                </div>

                            </div>
                        </div>
                        <span class="text-center mt-3">Silahkan Isi Data Dibawah Ini!</span>
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert"
                                style="margin-left: 25px; margin-right: 25px; margin-top: 25px">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                        <div class="container">
                            <div class="card-body">
                                <form action="/login-post" method="post" class="form-login">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <input type="email" name="email" id="email" class="form-control"
                                            value="{{ old('email') }}" placeholder="Email">
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="Password">
                                        @error('password')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        Belum punya akun? <a href="/register" style="text-decoration: none">Daftar
                                            Akun</a>
                                    </div>
                                    <div style="margin-bottom: 2rem; color: black"><a href="/register"
                                            style="text-decoration: none">Lupa Password?</a>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm mt-2 btn-block center-button"
                                        style="width: 20%">Masuk</button>

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
