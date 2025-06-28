<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="/frontend/assets/images/logo-wisata.png" type="image/x-icon" />
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title')</title>
    <link href="/backend/style.min.css" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="/backend/css/styles.css" rel="stylesheet" />
    <script src="/backend/js/all.js" crossorigin="anonymous"></script>
    <style>
        html,
        body {
            font-family: sans-serif;
        }

        .breadcrumb-item a {
            text-decoration: none;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    @include('layout.be.top-nav')

    <div id="layoutSidenav">
        @include('layout.be.sidebar')

        <div id="layoutSidenav_content">
            @yield('content') @include('layout.be.footer')
        </div>
    </div>

    <script src="/backend/js/bootstrap.bundle.min.js"></script>
    <script src="/backend/js/scripts.js"></script>
    <script src="/backend/js/simple-datatables.min.js"></script>
    <script src="/backend/js/datatables-simple-demo.js"></script>
    @yield('script')
</body>

</html>
