<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>D'Brownies</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Righteous&display=swap&subset=latin-ext" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ asset('aset/logo/logo db.png') }}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ asset('aset/logo/logo db.png') }}" sizes="16x16" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}" />
    <script src="{{ asset('js/vendor/modernizr-2.8.3.min.js') }}"></script>
    <style>
        /* CSS styles remain unchanged */
    </style>
</head>

<body>
    <!-- Header Area Start -->
    <header class="top">
        <div class="fixedArea">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 noPadding">
                    <div class="content-wrapper one">
                        <header class="header">
                            <nav class="navbar navbar-default myNavBar">
                                <div class="container">
                                    <div class="navbar-header">
                                        <div class="row">
                                            <div class="col-md-9 col-sm-9 col-xs-9">
                                                <div class="row">
                                                    <div class="col-md-3 col-xs-3 col-sm-3">
                                                        <a style="padding-top: 0px"
                                                            class="navbar-brand navBrandText text-uppercase font-weight-bold"
                                                            href="">
                                                            <img src="{{ asset('aset/logo/logo db.png') }}"
                                                                alt="restorant" class="move-up" />
                                                        </a>
                                                    </div>
                                                    <div class="col-md-9 col-sm-9 col-xs-9">
                                                        <a href="">
                                                            <img class="img-responsive logo"
                                                                src="{{ asset('aset/logo/desain bg.png') }}"
                                                                alt="restorant"
                                                                style="position: relative; width: 200px !important; height: 45px !important; top: -4px; left: -10px;" />
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-3">
                                                <button type="button" class="navbar-toggle collapsed"
                                                    data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
                                                    aria-expanded="false">
                                                    <span class="sr-only">Toggle navigation</span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                        <ul class="nav navbar-nav navbar-right navBar">
                                            <li class="nav-item">
                                                <a href="#section0"
                                                    class="nav-link text-uppercase font-weight-bold js-scroll-trigger">Home</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#section1"
                                                    class="nav-link text-uppercase font-weight-bold js-scroll-trigger">Offers</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#section2"
                                                    class="nav-link text-uppercase font-weight-bold js-scroll-trigger">About</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#section7"
                                                    class="nav-link text-uppercase font-weight-bold js-scroll-trigger">Contact</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ url('login') }}"
                                                    class="nav-link text-uppercase font-weight-bold js-scroll-trigger">Login</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </header>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Area End -->


    <!-- Section0 Area Start -->
    <section id="section0" class="slider-area" style="position: relative; overflow: hidden">
        <video autoplay muted loop playsinline
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -1;">
            <source src="{{ asset('aset/ssstik.io_@dokumen_perjalanan_1729866815590.mp4') }}" type="video/mp4" />
            Your browser does not support the video tag.
        </video>

        <div class="centered-content">
            <img class="classic" src="{{ asset('aset/logo/logo db.png') }}" alt="Minkop Logo" />
            <h3 class="stroke">D'Brownies Space Cake Shop</h3>
            <h2 class="stroke">A Taste Of The Good Life</h2>
            <p class="stroke">The best taste and a new experience that has never been experienced before</p>
            <a class="default-btn" href="{{ url('menu') }}">PESAN SEKARANG</a>
            <img class="classic" src="{{ asset('aset/new/icon.png') }}" alt="Icon" style="margin-top: 20px" />
        </div>
    </section>
    <!-- Section0 Area End -->
    <!-- Section1 Start -->
    <section id="section1" class="topOff">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-body colorfullPanel text-center">
                            <h3>Suasana Baru</h3>
                            <h2>
                                <span>Music</span> Live
                                <img class="classic" src="{{ asset('aset/new/icon.png') }}" />
                            </h2>
                            <p>
                                Cake Shop and space yang menyediakan music live setiap malam minggu
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="panel panel-default colorfullParent">
                        <div class="panel-body colorfullPanel text-center">
                            <h3>Rasa Baru</h3>
                            <h2>
                                <span>Update</span> Menu
                                <img class="classic" src="{{ asset('aset/new/icon.png') }}" />
                            </h2>
                            <p>
                                penawaran Rasa baru dan menu yang selalu update mengikuti perkembangan zaman
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-body colorfullPanel text-center">
                            <h3>Pengalaman Baru</h3>
                            <h2>
                                <span>Event</span> Menarik
                                <img class="classic" src="{{ asset('aset/new/icon.png') }}" />
                            </h2>
                            <p>
                                bermacam macam event dan acara yang menarik selalu menanti anda
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section1 End -->
    <!-- Section2 Start -->
    <section id="section2">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="maintext text-center">
                        <span>TENTANG D'Brownies</span>
                        <h2 style="color: white">Selamat Datang Penikmat D'brownies</h2>
                        <p>
                            D'Brownies – Surga camilan manis di Padang yang menyajikan brownies dan cookies lezat, fresh
                            dari oven, dengan suasana hangat dan pelayanan ramah.
                            Cocok untuk bersantai, ngobrol santai, atau bekerja sambil menikmati cita rasa manis yang
                            tak terlupakan. Temukan momen manismu bersama D'Brownies!


                        </p>
                    </div>
                </div>
            </div>
            <div class="row shapes">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="row">
                        <div class="col-md-12 minHeightProp">
                            <img class="imgback" src="aset/shape/shape1.png" />
                        </div>
                        <div class="col-md-12">
                            <div class="text-center">
                                <span style="color:white;">Pemesanan cepat dan mudah</span>
                                <p>
                                    Minkop menawarkan kemudahan dalam pemesanan, sehingga Anda bisa langsung menikmati
                                    kopi favorit tanpa
                                    perlu menunggu lama.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="row">
                        <div class="col-md-12 minHeightProp">
                            <img class="imgback" src="aset/shape/shape2.png" />
                        </div>
                        <div class="col-md-12">
                            <div class="text-center">
                                <span style="color:white;">Harga terjangkau,transaksi aman</span>
                                <p>
                                    Dengan harga yang bersahabat, Minkop memastikan setiap transaksi dilakukan dengan
                                    transparansi dan
                                    kepercayaan, memberikan nilai lebih bagi setiap pelanggan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="row">
                        <div class="col-md-12 minHeightProp">
                            <img class="imgback" src="aset/shape/shape3.png" />
                        </div>
                        <div class="col-md-12">
                            <div class="text-center">
                                <span style="color:white;">Kualitas terbaik setara berlian</span>
                                <p>
                                    Produk kami dipilih dan disajikan dengan standar tertinggi, menjamin kualitas
                                    terbaik yang bisa
                                    dinikmati seperti sebuah berlian yang berharga.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section2 End -->
    <!-- Address Section Start -->
    <section id="section7" class="row address parallax-window" data-parallax="scroll"
        data-image-src="aset/background/bgcookies.png">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-5 col-md-offset-1 addess-description">
                    <span>D'Brownies Cafe</span>
                    <h2>D'Brownies About</h2>
                    <p>
                        Jika ada Informasi Seputar D'Brownies Cafe & Space Silahkan Untuk Hubungi Nomer dan Email di
                        Bawah Ini
                    </p>
                    <ul>
                        <li class="address-section">
                            <div class="row">
                                <div class="col-md-2 col-sm-2 col-xs-2">
                                    <i class="fa fa-address-card"></i>
                                </div>
                                <div class="col-md-10 col-sm-10 col-xs-10 lineHeight">
                                    D'Brownies Cafe & Space<br />Jl.Gadut
                                </div>
                            </div>
                        </li>
                        <li class="address-section">
                            <div class="row">
                                <div class="col-md-2 col-sm-2 col-xs-2">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <div class="col-md-10 col-sm-10 col-xs-10 lineHeight">
                                    Nomer Telepon D'Brownies<br />+62 851-7320-2332
                                </div>
                            </div>
                        </li>
                        <li class="address-section">
                            <div class="row">
                                <div class="col-md-2 col-sm-2 col-xs-2">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <div class="col-md-10 col-sm-10 col-xs-10 lineHeight">
                                    Email D'Brownies<br />d.brownieslof@gmail.com
                                </div>
                        <li class="address-section">
                            <div class="row">
                                <div class="col-md-2 col-sm-2 col-xs-2">
                                    <i class="fa fa-instagram"></i>
                                </div>
                                <div class="col-md-10 col-sm-10 col-xs-10 lineHeight">
                                    Instagram D'Brownies<br />
                                    <a href="https://www.instagram.com/d.browniees?igsh=MW1wc3d1OHVoMXNueg=="
                                        target="_blank" style="color: #fff; text-decoration: none;">@d.brownies</a>
                                </div>
                            </div>
                        </li>
                </div>
                </li>
                </ul>
            </div>
            <div class="col-md-6 addess-map">

            </div>
        </div>
    </section>

    <!-- Adress Section End -->


    <!-- Other sections remain unchanged -->


    <!-- Footer Start -->
    <footer class="footer-area">
        <div class="container main-footer">
            <div class="row">

                <div class="footer-bottom text-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <p>Copyright © <a
                                        href="https://www.instagram.com/r.linoo_?igsh=djBmZHYyZm00c3du&utm_source=qr"
                                        target="_blank">R.lino</a> 2025. All Right Reserved By revolino.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer End -->

    <script src="{{ asset('js/vendor/jquery-1.12.0.min.js') }}"></script>
    <script src="{{ asset('js/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/parallax.min.js') }}"></script>
    <script src="{{ asset('js/ajax-mail.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>
