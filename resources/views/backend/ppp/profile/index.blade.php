@extends('layouts.backend.app')
@section('title')
    PPP - Profile
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ url('/') }}/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/') }}/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ url('/') }}/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title">PPP - Profile</h4>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Baru</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Bridge Learning</th>
                            <th class="text-center">Local Address</th>
                            <th class="text-center">Remote Address</th>
                            <th class="text-center">Rate Limit</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($responses as $item)
                            <tr>
                                <td class="text-center">{{ $item['.id'] }}</td>
                                <td class="text-center">{{ $item['name'] }}</td>
                                <td class="text-center">{{ $item['bridge-learning'] }}</td>
                                <td class="text-center">{{ empty($item['local-address']) ? '-' : $item['local-address'] }}</td>
                                <td class="text-center">{{ empty($item['remote-address']) ? '-' : $item['remote-address'] }}</td>
                                <td class="text-center">{{ empty($item['rate-limit']) ? '-' : $item['rate-limit'] }}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                        @endforeach
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
