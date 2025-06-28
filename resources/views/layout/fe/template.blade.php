<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/frontend/css/style.css">
    <link href="/frontend/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/frontend/css/bootstrap.min.css">
    <!-- Swiper JS CSS-->
    <link rel="stylesheet" href="/frontend/css/swiper-bundle.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.22/dist/sweetalert2.min.css">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="/frontend/all.min.css">

</head>

<body>

    @include('layout.fe.top-nav')

    @yield('content')

    @include('layout.fe.footer')

    <!-- Swiper JS -->
    <script src="/frontend/js/swiper-bundle.min.js"></script>

    {{-- Js --}}
    <script src="/frontend/js/script.js"></script>
    <script src="/frontend/js/jquery.min.js"></script>
    <script src="/frontend/js/popper.min.js"></script>
    <script src="/frontend/js/bootstrap.min.js"></script>

    <script src="/frontend/js/bootstrap.bundle.min.js"></script>
    <script src="/frontend/js/all.js" crossorigin="anonymous"></script>

    <script src="/frontend/js/simple-datatables.min.js"></script>
    <script src="/frontend/js/datatables-simple-demo.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.22/dist/sweetalert2.min.js"></script>
</body>

</html>
