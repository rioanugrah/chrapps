@extends('layouts.backend.app')
@section('title')
    Services
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ url('/') }}/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ url('/') }}/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ url('/') }}/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">@yield('title')</h4>
                <div class="">
                    <ol class="breadcrumb mb-0">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a> --}}
                        </li>
                        <li class="breadcrumb-item active">@yield('title')</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Services</h4>
                        </div>
                        <div class="col-auto">
                            {{-- <button class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Baru</button> --}}
                        </div>
                    </div>
                </div>
                {{-- @dd(strtotime(\Carbon\Carbon::now()->addDays(24)->format('Y-m-d')).' '.\Carbon\Carbon::now()->addDays(24)->format('Y-m-d')) --}}
                <div class="card-body">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th class="text-center">Code</th>
                                <th class="text-center">Product</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Address</th>
                                <th class="text-center">Expired</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($services as $item)
                                {{-- @dd(strtotime($item->expired_date)) --}}
                                <tr>
                                    <td class="text-center fw-bold">{{ explode('|', $item->service_code)[0] }}</td>
                                    <td class="text-center">{{ $item->order_service->order_name }}</td>
                                    <td class="text-center">{{ $item->username }}</td>
                                    <td class="text-center">{{ $item->ip_address }}</td>
                                    <td class="text-center">{{ $item->expired_date }}</td>
                                    <td class="text-center">
                                        {{ 'Rp. ' . number_format($item->order_service->order_price, 2, ',', '.') }}</td>
                                    <td class="text-center">
                                        @switch($item->status)
                                            @case('Active')
                                                @if ($item->order_service->payment->status == 'Pending')
                                                    <span class="badge bg-warning" style="color: black">Waiting Payment</span>
                                                @elseif($item->order_service->payment->status == 'Paid')
                                                    <span class="badge bg-success">{{ $item->status }}</span>
                                                @endif
                                            @break

                                            @case('InActive')
                                                <span class="badge bg-danger">{{ $item->status }}</span>
                                            @break

                                            @default
                                        @endswitch
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('user.service.detail', ['id' => $item->id]) }}"
                                            class="btn btn-sm edit-btn text-white"
                                            style="background: linear-gradient(90deg, #018790 0%, #00B7B5 100%);"
                                            data-id="{{ $item->id }}"><i class="fas fa-eye"></i> Detail</a>
                                    </td>
                                </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('js')
        <!-- Required datatable js -->
        <script src="{{ url('/') }}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="{{ url('/') }}/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="{{ url('/') }}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="{{ url('/') }}/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
        <script src="{{ url('/') }}/assets/libs/jszip/jszip.min.js"></script>
        <script src="{{ url('/') }}/assets/libs/pdfmake/build/pdfmake.min.js"></script>
        <script src="{{ url('/') }}/assets/libs/pdfmake/build/vfs_fonts.js"></script>
        <script src="{{ url('/') }}/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="{{ url('/') }}/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="{{ url('/') }}/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

        <!-- Responsive examples -->
        <script src="{{ url('/') }}/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="{{ url('/') }}/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

        <!-- Datatable init js -->
        <script src="{{ url('/') }}/assets/js/pages/datatables.init.js"></script>
    @endsection
