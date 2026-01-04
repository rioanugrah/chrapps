@extends('layouts.backend.app')
@section('title')
    Order Baru
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">@yield('title')</h4>
                <div class="">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a>Dashboard</a></li>
                        <li class="breadcrumb-item"><a>Order</a></li>
                        <li class="breadcrumb-item active">@yield('title')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach ($products as $item)
            <div class="col-xl-3 col-sm-6">
                <div class="card bg-primary mb-xl-0">
                    <div class="card-body">
                        <div class="p-2">
                            {{-- <h5 class="font-size-16">Starter</h5> --}}
                            <h3 class="mb-3 font-size-15 text-white">{{ $item->product_name }}</h3>
                            <h3 class="text-white">{{ 'Rp. ' . number_format($item->product_price, 2, ',', '.') }} <span
                                    class="font-size-16 fw-medium text-white">/ {{ $item->product_duration }} Hari </span>
                            </h3>
                            <div class="mt-4 pt-2 text-white">
                                <p class="mb-3 font-size-15"><i
                                        class="mdi mdi-check-circle text-light font-size-18 me-2"></i>Via Tunnel L2TP</p>
                                <p class="mb-3 font-size-15"><i
                                        class="mdi mdi-check-circle text-light font-size-18 me-2"></i>Koneksi Stabil</p>
                                <p class="mb-3 font-size-15"><i
                                        class="mdi mdi-check-circle text-light font-size-18 me-2"></i>Speed Download :
                                    {{ explode('M', $item->rate_download)[0] . 'Mbps' }}</p>
                                <p class="mb-3 font-size-15"><i
                                        class="mdi mdi-check-circle text-light font-size-18 me-2"></i>Speed Upload :
                                    {{ explode('M', $item->rate_upload)[0] . 'Mbps' }}</p>
                                <p class="mb-3 font-size-15"><i
                                        class="mdi mdi-check-circle text-light font-size-18 me-2"></i>Durasi :
                                    {{ $item->product_duration }} Hari</p>
                                <p class="mb-3 font-size-15"><i
                                        class="mdi mdi-check-circle text-light font-size-18 me-2"></i>Unlimited Quota</p>
                            </div>

                            <div class="mt-4 pt-2">
                                <a href="{{ route('user.order.checkout', ['id' => $item->id]) }}"
                                    class="btn btn-info w-100">Buy Now</a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        @endforeach
    </div>
@endsection
