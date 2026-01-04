@extends('layouts.backend.app')
@section('title')
    PPP - Active Connections
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
                        <h4 class="card-title">PPP - Active Connections</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Service</th>
                            <th class="text-center">Caller ID</th>
                            <th class="text-center">Address</th>
                            <th class="text-center">Encoding</th>
                            <th class="text-center">Uptime</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($responses as $item)
                            <tr>
                                <td class="text-center">{{ $item['.id'] }}</td>
                                <td class="text-center">{{ $item['name'] }}</td>
                                <td class="text-center">{{ $item['service'] }}</td>
                                <td class="text-center">{{ $item['caller-id'] }}</td>
                                <td class="text-center">{{ $item['address'] }}</td>
                                <td class="text-center">{{ $item['encoding'] }}</td>
                                <td class="text-center">{{ $item['uptime'] }}</td>
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
