@extends('layout.fe.template')
@section('title', 'Profil')
@section('content')

    @include('layout.fe.top-nav-buttom')

    <div class="container mt-4">
        <div class="text-center">
            <img src="/img/logo.png" alt="icon-imk" max-width="100%" height="400px">
        </div>
        <div class="text-justify">
            <p>
                PT. Istana Karya Management telah berdiri sejak tahun 2022, yang berlokasi di Jl. Raya Buwun Mas Dusun
                lemer, kecamatan sekotong, Kabupaten Lombok Barat. Jarak tempuh dari kota Mataram membutuhkan waktu sekitar
                1 jam 5 menit (43,2 km).
                PT. Istana Karya Management, sebagai perusahaan yang bergerak dibidang penjualan dan penyewaan barang,
                memiliki beragam jenis barang yang ditawarkan kepada pelanggan, mulai dari penyewaan seperti event organizer
                (EO), wedding organizer (WO), fotografer & videographer, editing foto/video & desain grafis, make up, baju
                adat, gendang beleq, sablon kaos, rental HT, drone, terop dan kursi, alat camping ground, cetak foto, dan
                penjualan madu trigona, kopi, dan olahan masyarakat yaitu abon ikan.
            </p>
            <div class="text-center mt-5">
                <img src="/img/ikm.png" alt="struktur-ikm" style="max-width: 100%; height: 400px;">
            </div>
        </div>
        <div class="mt-5">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3942.4802773444494!2d116.0467554!3d-8.834796599999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dcda1ff2902fd1b%3A0x285e6134ada1e038!2sLoezawa%20Information%20Centre!5e0!3m2!1sid!2sid!4v1719544457858!5m2!1sid!2sid"
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>

@endsection
