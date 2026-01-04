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
    <div class="row">
        <div class="col-xl-3 col-md-6">

            <div class="card card-h-100">

                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Total All Secret</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ count($secret) }}">{{ count($secret) }}</span>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card card-h-100">

                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">PPP Active</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ count($secretactive) }}">{{ count($secretactive) }}</span>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card card-h-100">

                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Uptime</span>
                            <h4 class="mb-3" id="uptime"></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">

            <div class="card card-h-100">

                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">CPU Load</span>
                            <h4 class="mb-3" id="cpu"></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        setInterval('cpu();',2000);
        function cpu() {
            $('#cpu').load('{{ route("realtime.cpu") }}')
        }

        setInterval('uptime();',1000);
        function uptime() {
            $('#uptime').load('{{ route("realtime.uptime") }}')
        }
    </script>
@endsection
