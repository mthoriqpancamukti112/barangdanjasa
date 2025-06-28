<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <div class="container-fluid"> <!-- Tambahkan container fluid untuk grid -->
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="{{ route('admin.dashboard') }}">Dashboard</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-0 order-lg-1 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4 flex-column flex-lg-row">
            <!-- Menggunakan flex untuk mengatur susunan item -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false"><i
                        class="fas fa-user fa-fw"></i>{{ Auth::user()->name }}</a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ route('beranda.index') }}">Home</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                            class="dropdown-item" href="#!">Keluar</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
