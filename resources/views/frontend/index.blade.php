@extends('layouts.frontend.app')
@section('title', 'Eagle Informatika')
@section('content')
    <section class="service-section">
        <figure class="service-leftlayer mb-0">
            <img src="{{ asset('frontend') }}/assets/images/service-leftlayer.png" alt="" class="img-fluid">
        </figure>
        <figure class="service-dotimage mb-0">
            <img src="{{ asset('frontend') }}/assets/images/service-dotimage.png" alt="" class="img-fluid">
        </figure>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="service_contentbox">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="service-box box-mb">
                                    <figure class="service-marketicon">
                                        <img src="{{ asset('frontend') }}/assets/images/service-marketicon.png"
                                            alt="" class="img-fluid">
                                    </figure>
                                    <h4>Digital Marketing</h4>
                                    {{-- <p class="text-size-18">Nostrum exercitationem ae ullam corporis suscipit labo
                                        riosam aliruiea.</p> --}}
                                    <a class="arrow text-decoration-none" href="./service.html"><i
                                            class="circle fa-thin fa-arrow-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="box-top">
                                    <div class="service-box box-mb">
                                        <figure class="service-producticon">
                                            <img src="{{ asset('frontend') }}/assets/images/service-producticon.png"
                                                alt="" class="img-fluid">
                                        </figure>
                                        <h4>Product Development</h4>
                                        {{-- <p class="text-size-18">Nostrum exercitationem ae ullam corporis suscipit labo
                                            riosam aliruiea.</p> --}}
                                        <a class="arrow text-decoration-none" href="./service.html"><i
                                                class="circle fa-thin fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="service-box">
                                    <figure class="service-designicon">
                                        <img src="{{ asset('frontend') }}/assets/images/service-designicon.png"
                                            alt="" class="img-fluid">
                                    </figure>
                                    <h4>Ui/Ux Designing</h4>
                                    {{-- <p class="text-size-18">Nostrum exercitationem ae ullam corporis suscipit labo
                                        riosam aliruiea.</p> --}}
                                    <a class="arrow text-decoration-none" href="./service.html"><i
                                            class="circle fa-thin fa-arrow-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="box-top">
                                    <div class="service-box">
                                        <figure class="service-dataicon">
                                            <img src="{{ asset('frontend') }}/assets/images/service-dataicon.png"
                                                alt="" class="img-fluid">
                                        </figure>
                                        <h4>Data Analysis</h4>
                                        {{-- <p class="text-size-18">Nostrum exercitationem ae ullam corporis suscipit labo
                                            riosam aliruiea.</p> --}}
                                        <a class="arrow text-decoration-none" href="./service.html"><i
                                                class="circle fa-thin fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="service_content position-relative" data-aos="fade-right">
                        <figure class="service-rightcircle mb-0">
                            <img src="{{ asset('frontend') }}/assets/images/service-rightcircle.png" alt=""
                                class="img-fluid">
                        </figure>
                        <h6>Layanan Kami</h6>
                        <h2>Solusi IT Terbaik Untuk Bisnis Anda</h2>
                        {{-- <p>Grursus mal suada faci lisis lorem ipsum dolarorit more ame
                            ion consectetur elit vesti at bulum nec odio aea the dumm ipsumm recreo that dolocons.</p> --}}
                        {{-- <ul class="list-unstyled mb-0">
                            <li class="text"><i class="circle fa-duotone fa-check"></i>Quisquam est, rui dolorem
                                ipsum quia dolor corporis.</li>
                            <li class="text"><i class="circle fa-duotone fa-check"></i>Rem aperiam, eaque ipsa quae
                                ab illo inventore veritatis.</li>
                            <li class="text"><i class="circle fa-duotone fa-check"></i>Duis aute irure dolor in
                                reprehenderit in voluptate velio.</li>
                            <li class="text text1"><i class="circle fa-duotone fa-check"></i>Molestiae non recusandae
                                itarue earum rerum maio.</li>
                        </ul> --}}
                        <a class="get_started text-white text-decoration-none" href="#">Mulai
                            <figure class="mb-0"><img src="{{ asset('frontend') }}/assets/images/button-arrow.png"
                                    alt="" class="img-fluid"></figure>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <figure class="service-rightlayer mb-0">
            <img src="{{ asset('frontend') }}/assets/images/service-rightlayer.png" alt="" class="img-fluid">
        </figure>
    </section>

    @php
        $proyeks = [
            [
                'id' => 1,
                'category' => 'Website',
                'title' => 'Pesona Plesiran Indonesia',
                'link' => '#',
                'cover' => 'https://is3.cloudhost.id/eagleinformatika/SC PPI.webp',
            ],
            [
                'id' => 2,
                'category' => 'Web App',
                'title' => 'Afkar Mobil',
                'link' => '#',
                'cover' => 'https://is3.cloudhost.id/eagleinformatika/SC AF.webp',
            ],
            // [
            //     'id' => 3,
            //     'category' => 'Website',
            //     'title' => 'Ars Desain Studio',
            //     'link' => '#',
            //     'cover' => '-'
            // ],
        ];
    @endphp

    <section class="project-section">
        <figure class="offer-toplayer mb-0">
            <img src="{{ asset('frontend') }}/assets/images/offer-toplayer.png" alt="" class="img-fluid">
        </figure>
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="project_content" data-aos="fade-right">
                        <h6>Proyek</h6>
                        <h2>Proyek Terbaru</h2>
                        {{-- <p>Dursus mal suada faci lisis lorem ipsum dolarorit more ame ion consectetur elit vesti at
                            bulum nec
                            odio aea the dumm recreo that dolocons.</p> --}}
                        <figure class="offer-circleimage mb-0">
                            <img src="{{ asset('frontend') }}/assets/images/offer-circleimage.png" alt=""
                                class="img-fluid">
                        </figure>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="owl-carousel owl-theme">
                    @foreach ($proyeks as $item)
                        <div class="item">
                            <div class="case-box1 case-box overlay">
                                <div class="overlay-image">
                                    <figure class="image mb-0">
                                        <img src="{{ $item['cover'] }}" alt="" class="">
                                    </figure>
                                </div>
                                <div class="content">
                                    <span class="text-white">{{ $item['category'] }}</span>
                                    <h5 class="text-white">{{ $item['title'] }}</h5>
                                    {{-- <p class="text-white text-size-18">Rerum hic tenetur sapiente...</p> --}}
                                    {{-- <i class="circle fa-thin fa-arrow-right"></i> --}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <figure class="offer-bottomlayer mb-0">
            <img src="{{ asset('frontend') }}/assets/images/offer-bottomlayer.png" alt="" class="img-fluid">
        </figure>
    </section>
@endsection
