<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-house"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="{{ route('user.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                    User
                </a>
                <a class="nav-link" href="{{ route('admin.pesanan.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                    Pesanan Barang
                </a>
                <a class="nav-link" href="{{ route('admin.penyewaan.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-receipt"></i> </div>
                    Pesanan Sewa
                </a>
                <a class="nav-link" href="{{ route('pelanggan.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                    Pelanggan
                </a>
                <a class="nav-link" href="{{ route('barang.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-basket-shopping"></i></div>
                    Produk
                </a>
                <a class="nav-link" href="{{ route('metodepembayaran.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-credit-card"></i></div>
                    Metode Pembayaran
                </a>


                <a class="nav-link" href="{{ route('laporan-pesanan.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-file"></i></div>
                    Laporan Penjualan
                </a>
                <a class="nav-link" href="{{ route('laporan-penyewaan.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-file"></i></div>
                    Laporan Penyewaan
                </a>
                {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Layouts
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('tour.index') }}">Wisata</a>
                    </nav>
                </div> --}}
            </div>
        </div>
    </nav>
</div>
