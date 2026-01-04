@extends('layouts.backend.app')
@section('title')
    DNS
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ url('/') }}/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/') }}/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ url('/') }}/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/') }}/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title">DNS</h4>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('mikrotik.dns.static') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Static</a>
                        <a class="btn btn-primary"><i class="fas fa-info"></i> Cache</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="">Server</label>
                    <div>{{ $response[0]['servers'] }}</div>
                </div>
                <div class="mb-3">
                    <label for="">Dynamic Server</label>
                    <div>{{ $response[0]['dynamic-servers'] }}</div>
                </div>
                <div class="mb-3">
                    <label for="">Use Doh Server</label>
                    <div>{{ $response[0]['use-doh-server'] }}</div>
                </div>
                <div class="mb-3">
                    <label for="">Verify Doh Server</label>
                    <div>{{ $response[0]['verify-doh-cert'] }}</div>
                </div>
                <div class="mb-3">
                    <label for="">Doh Max Server Connections</label>
                    <div>{{ $response[0]['doh-max-server-connections'] }}</div>
                </div>
                <div class="mb-3">
                    <label for="">Allow Remote Request</label>
                    <div>{{ $response[0]['allow-remote-requests'] }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
@endsection
