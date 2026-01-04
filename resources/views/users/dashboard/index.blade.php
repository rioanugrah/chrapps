@extends('layouts.backend.app')
@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row mb-4">
        @foreach ($services as $item)
            <div class="col-xl-3 col-sm-6">
                <div class="card bg-success mb-xl-0">
                    <div class="card-body">
                        <div class="">
                            <h5 class="font-size-20 text-white">Layanan Aktif</h5>
                            <h3 class="mt-3 mb-3 font-size-15 text-white">{{ $item->order_service->order_name }}</h3>
                            <h3 class="mt-3 font-size-15 text-white"><i
                                    class="mdi mdi-check-circle text-light font-size-18 me-2"></i>Expired :
                                {{ $item->expired_date }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <h4 class="mb-4">Product</h4>
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

@section('js')
@endsection
