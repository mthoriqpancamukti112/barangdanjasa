@extends('layout.fe.template')
@section('title', 'Home')
@section('content')
    <style>
        .custom-btn {
            background: hsl(48, 100%, 62%);
            transition: background 0.3s;
        }

        .custom-btn:hover {
            background: white;
        }
    </style>
    {{-- <section>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="/img/homeImg1.jpg" alt="">
                </div>

                <div class="swiper-slide">
                    <img src="/img/homeImg2.jpg" alt="">
                </div>

                <div class="swiper-slide">
                    <img src="/img/homeImg3.jpg" alt="">
                </div>
            </div>

            <div class="swiper-button-next nav-btn"></div>
            <div class="swiper-button-prev nav-btn"></div>
            <div class="swiper-pagination"></div>
        </div>
    </section> --}}

    @include('layout.fe.top-nav-buttom')

    <section>
        <div class="swiper">
            <div class="dark-overlay">
                <img src="/img/1.jpg" alt="">
            </div>
            <div class="home-details">
                <div class="container">
                    <h2 class="homeTitle">ISTANA KARYA MANAGEMENT</h2>
                    <h4 class="homeSubtitle mb-5">Jln. Raya Lemer Kecamatan Sekotong <br> Kb. Lombok Barat</h4>
                    <div class="d-flex justify-content-center align-items-center">
                        <a href="{{ route('produk.index') }}" type="button" class="btn mr-5 custom-btn"><i
                                class="fas fa-store"></i> Lihat
                            Katalog</a>
                        <a href="{{ route('detail.pemesanan.index') }}" type="button" class="btn custom-btn"><i
                                class="fas fa-shopping-cart"></i> Lihat
                            Pesanan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
