<style>
    .navbar-nav .nav-item .fa-shopping-cart {
        font-size: 20px;
        /* position: relative; */
    }

    .navbar-nav .nav-item .fa-shopping-cart,
    .navbar-nav .nav-item .badge {
        display: inline-block;
        vertical-align: middle;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light" style="background: rgb(244, 244, 244)">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <!-- Bagian Kiri Navbar -->
            <ul class="navbar-nav">
                @if (Auth::guard('web')->check() || Auth::guard('pelanggan')->check())
                    <li class="nav-item active">
                        <span style="color: black">
                            <label for=""><i class="fas fa-user"></i> Hii..
                                @if (Auth::guard('web')->check())
                                    {{ Auth::user()->name }}
                                @else
                                    {{ Auth::guard('pelanggan')->user()->name }}
                                @endif
                            </label>
                        </span>
                    </li>
                @endif
            </ul>
            <!-- Bagian Tengah Navbar -->
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('beranda.index') }}" style="color: black">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('produk.index') }}" style="color: black">Daftar Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profil.index') }}" style="color: black">Profil</a>
                </li>
                @if (Auth::guard('web')->check() || Auth::guard('pelanggan')->check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('detail.pemesanan.index') }}" style="color: black">Pesanan
                            Anda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('penyewaan.index') }}" style="color: black">Daftar
                            Penyewaan</a>
                    </li>
                    @if (Auth::guard('web')->check() && auth()->user()->hak_akses == 'Admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}" style="color: black">Dashboard</a>
                        </li>
                    @endif
                @endif
            </ul>
            <!-- Bagian Kanan Navbar -->
            <ul class="navbar-nav">
                @if (Auth::guard('web')->check() || Auth::guard('pelanggan')->check())
                    <li class="nav-item">
                        <a onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                            class="nav-link" href="#"
                            style="color: white; background: red; border-radius: 6px">Logout</a>
                        <form id="logout-form" action="{{ route('pelanggan.logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('keranjang.pesanan.index') }}" style="color: purple;">
                            <i class="fas fa-shopping-cart"></i>
                            @if ($jumlah_item_keranjang > 0)
                                <span class="badge badge-danger">{{ $jumlah_item_keranjang }}</span>
                            @endif
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pelanggan.login.form') }}" style="color: black">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pelanggan.register.form') }}"
                            style="color: black; background: rgb(103, 214, 251); border-radius: 6px">Daftar</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
