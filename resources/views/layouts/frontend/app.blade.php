<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('frontend') }}/assets/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/js/bootstrap.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="{{ asset('frontend') }}/assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('frontend') }}/assets/css/custom-style.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('frontend') }}/assets/css/special-classes.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('frontend') }}/assets/css/responsive.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <title>@yield('title')</title>
    @yield('css')
</head>

<body>
    <div class="banner_outer">
        <header class="header">
            <div class="main-header">
                <div class="container-fluid">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="{{ route('frontend.index') }}">
                            <figure class="mb-0 banner-logo"><img
                                    src="https://is3.cloudhost.id/eagleinformatika/Logo Eagle Media Informatika Cover.png"
                                    alt="" class="img-fluid" style="filter: brightness(0) invert(1);"
                                    width="200"></figure>
                        </a>
                        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                            <span class="navbar-toggler-icon"></span>
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                <li class="nav-item active">
                                    <a class="nav-link" href="{{ route('frontend.index') }}">Beranda</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Tentang</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Produk</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Kontak Kami</a>
                                </li>
                            </ul>
                            <div class="last_list">
                                <figure class="nav-phoneimage mb-0"><img class="img-fluid"
                                        src="{{ asset('frontend') }}/assets/images/nav-phoneimage.png" alt="">
                                </figure>
                                <div class="content">
                                    <p class="text-size-18 text-white">Email Kami:</p>
                                    <a class="text-decoration-none last_list_atag"
                                        href="mailto:marketing@eagleinformatika.com">marketing@eagleinformatika.com</a>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </header>
        <figure class="banner-layerright mb-0">
            <img src="{{ asset('frontend') }}/assets/images/banner-layerright.png" class="img-fluid" alt="">
        </figure>
        <section class="banner-section">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5 col-md-12 col-sm-12 col-12" data-aos="fade-right">
                        <div class="social-icons position-relative" data-aos="fade-up">
                            <ul class="list-unstyled position-absolute">
                                <li><a href="" class="text-decoration-none"><i
                                            class="fa-brands fa-facebook-f social-networks"></i></a></li>
                                <li><a href="" class="text-decoration-none"><i
                                            class="fa-brands fa-twitter social-networks"></i></a></li>
                                <li><a href="" class="text-decoration-none"><i
                                            class="fa-brands fa-google-plus-g social-networks"></i></a></li>
                                <li><a href="" class="text-decoration-none"><i
                                            class="fa-brands fa-instagram social-networks"></i></a></li>
                            </ul>
                        </div>
                        <div class="banner_content">
                            <figure class="banner-line mb-0"><img
                                    src="{{ asset('frontend') }}/assets/images/banner-line.png" alt=""
                                    class="img-fluid"></figure>
                            <h6 class="text-white">Kami Menyediakan Layanan</h6>
                            <h1 class="text-white">IT Services & Solutions</h1>
                            <a class="get_started button1 text-white text-decoration-none" href="#">Mulai
                                <figure class="mb-0"><img
                                        src="{{ asset('frontend') }}/assets/images/button-arrow.png" alt=""
                                        class="img-fluid"></figure>
                            </a>
                            <a class="get_started button2 text-white text-decoration-none" href="#">Kontak Kami
                                <figure class="mb-0"><img
                                        src="{{ asset('frontend') }}/assets/images/button-arrow.png" alt=""
                                        class="img-fluid"></figure>
                            </a>
                            <figure class="banner-circleleft mb-0">
                                <img src="{{ asset('frontend') }}/assets/images/banner-circleleft.png"
                                    class="img-fluid" alt="">
                            </figure>
                            <figure class="banner-dotleft mb-0">
                                <img src="{{ asset('frontend') }}/assets/images/banner-dotleft.png" class="img-fluid"
                                    alt="">
                            </figure>
                        </div>
                    </div>
                    {{-- <div class="col-lg-7 col-md-12 col-sm-12 col-12">
                        <div class="banner_wrapper">
                            <figure class="mb-0 banner-image">
                                <img src="{{ asset('frontend') }}/assets/images/banner-image.jpg" alt=""
                                    class="img-fluid">
                            </figure>
                            <div class="position-relative">
                                <a class="popup-vimeo"
                                    href="https://video-previews.elements.envatousercontent.com/h264-video-previews/d1c81f1e-849f-4d45-ae57-b61c2f5db34a/25628048.mp4">
                                    <figure class="mb-0 banner-vedioimage">
                                        <img class="thumb img-fluid" style="cursor: pointer"
                                            src="{{ asset('frontend') }}/assets/images/banner-vedioimage.png"
                                            alt="">
                                    </figure>
                                </a>
                            </div>
                            <figure class="banner-circleright mb-0">
                                <img src="{{ asset('frontend') }}/assets/images/banner-circleright.png"
                                    class="img-fluid" alt="">
                            </figure>
                            <figure class="banner-dotright mb-0">
                                <img src="{{ asset('frontend') }}/assets/images/banner-dotright.png"
                                    class="img-fluid" alt="">
                            </figure>
                        </div>
                    </div> --}}
                </div>
            </div>
        </section>
    </div>

    @yield('content')

    <section class="footer-section">
        <div class="container">
            <figure class="footer-leftimage mb-0">
                <img src="https://is3.cloudhost.id/eagleinformatika/Logo%20Eagle%20Media%20Informatika.webp"
                    alt="" class="img-fluid" width="250">
            </figure>
            <figure class="mb-0 about-leftcircle">
                <img src="{{ asset('frontend') }}/assets/images/about-rightcircle.png" alt=""
                    class="img-fluid">
            </figure>
            <div class="middle-portion">
                <div class="row">
                    <div class="col-lg-4 col-md-5 col-sm-6 col-12">
                        <div class="first-column">
                            <a href="{{ route('frontend.index') }}">
                                <figure class="footer-logo">
                                    <img src="https://is3.cloudhost.id/eagleinformatika/Logo Eagle Media Informatika Cover.png"
                                        class="img-fluid" alt="" width="200"
                                        style="filter: brightness(0) invert(1);">
                                </figure>
                            </a>
                            <p class="text-size-18 footer-text">Eagle Media Informatika adalah pionir teknologi yang
                                fokus pada solusi IT Solustion cerdas untuk menjawab tantangan industri modern. Kami
                                menggabungkan kreativitas dan keunggulan teknis untuk membantu bisnis bertransformasi
                                lebih cepat.</p>
                            <div class="lower">
                                <div class="lower-content">
                                    <figure class="icon">
                                        <img src="{{ asset('frontend') }}/assets/images/footer-emailicon.png"
                                            alt="" class="img-fluid">
                                    </figure>
                                    <div class="content">
                                        <span class="text-white">Email us:</span>
                                        <a href="mailto:info@eagleinformatika.com"
                                            class="text-size-18 mb-0 text-decoration-none">info@eagleinformatika.com</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-12 col-12 d-md-block d-none">
                        <div class="links list-pd">
                            <h4 class="heading text-white">Tautan Cepat</h4>
                            <ul class="list-unstyled mb-0">
                                <li><a href="#" class="text-size-18 text text-decoration-none">Beranda</a>
                                </li>
                                <li><a href="#" class="text-size-18 text text-decoration-none">Tentang Kami</a>
                                </li>
                                <li><a href="#" class="text-size-18 text text-decoration-none">Produk</a></li>
                                <li><a href="#" class="text-size-18 text text-decoration-none">Kontak Kami</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-12 d-lg-block d-none">
                        <div class="links">
                            <h4 class="heading text-white">Layanan Kami</h4>
                            <ul class="list-unstyled mb-0">
                                <li><a href="#" class="text-size-18 text text-decoration-none">Mikrotik CHR</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-12 d-sm-block d-none">
                        <div class="icons">
                            <h4 class="heading mb-3 text-white">Info Berlanjut</h4>
                            <form id="contactpage1" method="POST" action="#">
                                <div class="form-group mb-0">
                                    <input type="text" class="form_style" placeholder="Enter Email Address:"
                                        name="email">
                                </div>
                                <button type="submit" class="subscribe_now text-white text-decoration-none">Subscribe
                                    Now
                                    <i class="circle fa-thin fa-arrow-right"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <div class="container">
                    <div class="row copyright-border">
                        <div class="col-lg-6 col-md-6 col-sm-12 co-12 column">
                            <p class="text-size-16">Copyright ©2025 Eagle Media Informatika</p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 co-12 d-md-block d-none">
                            <div class="social-icons position-relative">
                                <ul class="list-unstyled position-absolute">
                                    <li><a href="" class="text-decoration-none"><i
                                                class="fa-brands fa-facebook-f social-networks"></i></a></li>
                                    <li><a href="" class="text-decoration-none"><i
                                                class="fa-brands fa-twitter social-networks"></i></a></li>
                                    <li><a href="" class="text-decoration-none"><i
                                                class="fa-brands fa-google-plus-g social-networks"></i></a></li>
                                    <li><a href="" class="text-decoration-none"><i
                                                class="fa-brands fa-instagram social-networks"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <figure class="footer-dotimage mb-0">
                <img src="{{ asset('frontend') }}/assets/images/footer-dotimage.png" alt=""
                    class="img-fluid">
            </figure>
            <figure class="footer-leftlayer mb-0">
                <img src="{{ asset('frontend') }}/assets/images/footer-leftlayer.png" alt=""
                    class="img-fluid">
            </figure>
        </div>
    </section>
    <script src="{{ asset('frontend') }}/assets/js/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/bootstrap.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/video_link.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/video.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/counter.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/owl.carousel.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/custom-carousel.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/custom.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/animation_links.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/animation.js"></script>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/69621ba73e77c41972068c48/1jejjo29f';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
    @yield('js')
</body>

</html>
