@extends('layouts.backend.app')
@section('title')
    Service - #{{ explode('|', $service->service_code)[0] }}
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
    <link href="{{ url('/') }}/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @include('backend.services.modalBuatNat')
    @include('backend.services.modalEditNat')

    @include('backend.services.modalBuatDomain')
    @include('backend.services.modalEditDomain')

    {{-- <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">Warning!</h4>
        <p>Diharapkan berhati-hati saat melakukan konfigurasi <b>NAT Rule & Domains</b> agar tidak terjadi konflik
            konfigurasi. Jika anda ingin konfigurasi <b>NAT Rule</b> maka, pada bagian <b>Domains</b> tidak perlu diisi
            namun juga sebaliknya.</p>
    </div> --}}
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
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td class="fw-bold" style="width: 10%">Status</td>
                            <td>:</td>
                            <td>
                                @switch($service->status)
                                    @case('Active')
                                        @if ($service->order_service->payment->status == 'Pending')
                                        <span class="badge bg-warning" style="color: black">Waiting Payment</span>
                                        @elseif($service->order_service->payment->status == 'Paid')
                                        <span class="badge bg-success">{{ $service->status }}</span>
                                        @endif
                                    @break

                                    @case('InActive')
                                        <span class="badge bg-warning">{{ $service->status }}</span>
                                    @break

                                    @case('Expired')
                                        <span class="badge bg-danger">{{ $service->status }}</span>
                                    @break

                                    @default
                                @endswitch
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Product</td>
                            <td>:</td>
                            <td>{{ $service->order_service->order_name }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Price</td>
                            <td>:</td>
                            <td>{{ 'Rp. ' . number_format($service->order_service->order_price, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Server Address</td>
                            <td>:</td>
                            <td>{{ $service->server->ip_public . ' (' . $service->server->domain . ') ' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Username</td>
                            <td>:</td>
                            <td>{{ $service->username }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Password</td>
                            <td>:</td>
                            <td>{{ $service->password }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Expired Date</td>
                            <td>:</td>
                            <td>{{ $service->expired_date }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">IP Address</td>
                            <td>:</td>
                            <td>{{ $service->ip_address }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">L2TP Config</td>
                            <td>:</td>
                            <td style="word-wrap: break-word;">{{ $service->l2tp_config }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('user.service.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">NAT Rule</h4>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary" onclick="buat_nat()"><i class="fas fa-plus"></i> Tambah
                                Baru</button>
                        </div>
                    </div>
                    <div class="table-responsive mt-3">
                        <table id="datatable" class="table">
                            <thead>
                                <tr>
                                    <th>Port NAT</th>
                                    <th>To Addresses</th>
                                    <th>To Ports Address</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($service->service_nat_rules as $item)
                                    <tr>
                                        <td>{{ explode('|', $item->port)[0] }}</td>
                                        <td>{{ $item->to_addresses }}</td>
                                        <td>{{ $item->to_port }}</td>
                                        <td>
                                            @switch($item->status)
                                                @case('Active')
                                                    <span class="badge bg-success">{{ $item->status }}</span>
                                                @break

                                                @case('InActive')
                                                    <span class="badge bg-danger">{{ $item->status }}</span>
                                                @break

                                                @default
                                            @endswitch
                                        </td>
                                        <td>
                                            <a href="javascript:void" class="btn btn-sm btn-warning edit-btn"
                                                data-id="{{ $item->id }}"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="javascript:void" class="btn btn-sm btn-danger delete-btn"
                                                data-id="{{ $item->id }}"><i class="fas fa-trash"></i> Delete</a>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title">Domains</h4>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-primary" onclick="buat_domain()"><i class="fas fa-plus"></i> Tambah
                                    Baru</button>
                            </div>
                        </div>
                        <div class="table-responsive mt-3">
                            <table id="datatable2" class="table">
                                <thead>
                                    <tr>
                                        <th>Domain</th>
                                        <th>IP Address</th>
                                        <th>Port</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($service->service_domains as $item)
                                        <tr>
                                            <td>{{ $item->domain }}</td>
                                            <td>{{ $service->ip_address }}</td>
                                            <td>{{ explode('|', $item->port)[0] }}</td>
                                            <td>
                                                @switch($item->status)
                                                    @case('Active')
                                                        <span class="badge bg-success">{{ $item->status }}</span>
                                                    @break

                                                    @case('InActive')
                                                        <span class="badge bg-danger">{{ $item->status }}</span>
                                                    @break

                                                    @default
                                                @endswitch
                                            </td>
                                            <td>
                                                <a href="javascript:void" class="btn btn-sm btn-warning edit-btn-domain"
                                                    data-id="{{ $item->id }}"><i class="fas fa-edit"></i> Edit</a>
                                                <a href="javascript:void" class="btn btn-sm btn-danger delete-btn-domain"
                                                    data-id="{{ $item->id }}"><i class="fas fa-trash"></i> Delete</a>
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
            <script src="{{ url('/') }}/assets/libs/sweetalert2/sweetalert2.min.js"></script>

            <script>
                $('#datatable2').DataTable();

                function buat_nat() {
                    $('#modalBuatNat').modal('show');
                }

                function buat_domain() {
                    $('#modalBuatDomain').modal('show');
                }

                $('#form-simpan-nat').submit(function(e) {
                    e.preventDefault();
                    let formData = new FormData(this);
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('user.service.serviceNatRuleSimpan', ['id' => $service->id]) }}",
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: () => {
                            Swal.fire({
                                icon: "info",
                                title: "Sedang Diproses, Silahkan Tunggu",
                                showConfirmButton: false,
                            });
                        },
                        success: (result) => {
                            if (result.success != false) {
                                Swal.fire({
                                    icon: result.message_type,
                                    title: result.message_title,
                                    text: result.message_content,
                                    showConfirmButton: true,
                                });
                                $('#modalBuatNat').modal('hide');
                                this.reset();
                                setTimeout(() => {
                                    window.location.reload();
                                }, 2000);
                            } else {
                                Swal.fire({
                                    icon: result.message_type,
                                    title: result.message_title,
                                    text: result.message_content,
                                    showConfirmButton: true,
                                });
                            }
                        },
                        error: function(request, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: error,
                                // showConfirmButton: false,
                            });
                        }
                    });
                });

                $('#form-simpan-domain').submit(function(e) {
                    e.preventDefault();
                    let formData = new FormData(this);
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('user.service.serviceDomainSimpan', ['id' => $service->id]) }}",
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: () => {
                            Swal.fire({
                                icon: "info",
                                title: "Sedang Diproses, Silahkan Tunggu",
                                showConfirmButton: false,
                            });
                        },
                        success: (result) => {
                            if (result.success != false) {
                                Swal.fire({
                                    icon: result.message_type,
                                    title: result.message_title,
                                    text: result.message_content,
                                    showConfirmButton: true,
                                });
                                $('#modalBuatDomain').modal('hide');
                                this.reset();
                                setTimeout(() => {
                                    window.location.reload();
                                }, 2000);
                            } else {
                                Swal.fire({
                                    icon: result.message_type,
                                    title: result.message_title,
                                    text: result.message_content,
                                    showConfirmButton: true,
                                });
                            }
                        },
                        error: function(request, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: error,
                                // showConfirmButton: false,
                            });
                        }
                    });
                });

                $('#form-update-nat').submit(function(e) {
                    e.preventDefault();
                    let formData = new FormData(this);
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('user.service.serviceNatRuleUpdate', ['id' => $service->id]) }}",
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: () => {
                            Swal.fire({
                                icon: "info",
                                title: "Sedang Diproses, Silahkan Tunggu",
                                showConfirmButton: false,
                            });
                        },
                        success: (result) => {
                            if (result.success != false) {
                                Swal.fire({
                                    icon: result.message_type,
                                    title: result.message_title,
                                    text: result.message_content,
                                    showConfirmButton: true,
                                });
                                $('#modalEditNat').modal('hide');
                                this.reset();
                                setTimeout(() => {
                                    window.location.reload();
                                }, 2000);
                            } else {
                                Swal.fire({
                                    icon: result.message_type,
                                    title: result.message_title,
                                    text: result.message_content,
                                    showConfirmButton: true,
                                });
                            }
                        },
                        error: function(request, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: error,
                                // showConfirmButton: false,
                            });
                        }
                    });
                });

                $('#form-update-domain').submit(function(e) {
                    e.preventDefault();
                    let formData = new FormData(this);
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('user.service.serviceDomainUpdate', ['id' => $service->id]) }}",
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: () => {
                            Swal.fire({
                                icon: "info",
                                title: "Sedang Diproses, Silahkan Tunggu",
                                showConfirmButton: false,
                            });
                        },
                        success: (result) => {
                            if (result.success != false) {
                                Swal.fire({
                                    icon: result.message_type,
                                    title: result.message_title,
                                    text: result.message_content,
                                    showConfirmButton: true,
                                });
                                $('#modalEditDomain').modal('hide');
                                this.reset();
                                setTimeout(() => {
                                    window.location.reload();
                                }, 2000);
                            } else {
                                Swal.fire({
                                    icon: result.message_type,
                                    title: result.message_title,
                                    text: result.message_content,
                                    showConfirmButton: true,
                                });
                            }
                        },
                        error: function(request, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: error,
                                // showConfirmButton: false,
                            });
                        }
                    });
                });

                $('.edit-btn').on('click', function() {
                    // Get the ID from the data attribute
                    var itemId = $(this).data('id');
                    // Get a reference to the table row for later removal
                    // var $row = $(this).closest('tr');

                    $.ajax({
                        url: '{{ url('services/' . $service->id . '/') }}' + "/nat/" +
                        itemId, // The server-side endpoint URL
                        type: 'GET', // Use the DELETE HTTP verb
                        data: {
                            '_token': $('meta[name="csrf-token"]').attr('content'),
                            '_method': 'GET'
                        },
                        success: function(result) {
                            // console.log(result);
                            if (result.success == true) {
                                // alert(result);
                                // console.log(result);
                                $('#edit_id').val(result.data.id);
                                $('#edit_to_port').val(result.data.to_port);
                                $('#edit_status').val(result.data.status);

                                $('#modalEditNat').modal('show');

                            }
                        }
                    });
                });

                $('.edit-btn-domain').on('click', function() {
                    // Get the ID from the data attribute
                    var itemId = $(this).data('id');
                    // Get a reference to the table row for later removal
                    // var $row = $(this).closest('tr');

                    $.ajax({
                        url: '{{ url("services/" . $service->id . "/") }}' + "/domain/" +
                        itemId, // The server-side endpoint URL
                        type: 'GET', // Use the DELETE HTTP verb
                        data: {
                            '_token': $('meta[name="csrf-token"]').attr('content'),
                            '_method': 'GET'
                        },
                        success: function(result) {
                            // console.log(result);
                            if (result.success == true) {
                                // alert(result);
                                // console.log(result);
                                $('#edit_domain_id').val(result.data.id);
                                $('#edit_domain').val(result.data.domain);
                                $('#edit_domain_port').val(result.data.port.split('|')[0]);
                                $('#edit_domain_status').val(result.data.status);

                                $('#modalEditDomain').modal('show');

                            }
                        }
                    });
                });

                $('.delete-btn').on('click', function() {
                    // Get the ID from the data attribute
                    var itemId = $(this).data('id');

                    if (confirm('Are you sure you want to delete this item?')) {
                        $.ajax({
                            url: '{{ url('services/' . $service->id . '/') }}' + "/nat/" + itemId +
                            "/delete", // The server-side endpoint URL
                            type: 'DELETE', // Use the DELETE HTTP verb
                            data: {
                                '_token': $('meta[name="csrf-token"]').attr('content'),
                                '_method': 'DELETE'
                            },
                            success: function(result) {
                                if (result.success == true) {
                                    Swal.fire({
                                        icon: result.message_type,
                                        title: result.message_title,
                                        text: result.message_content,
                                        showConfirmButton: true,
                                    });

                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 2000);
                                }
                            }
                        });
                    }
                });

                $('.delete-btn-domain').on('click', function() {
                    // Get the ID from the data attribute
                    var itemId = $(this).data('id');

                    if (confirm('Are you sure you want to delete this item?')) {
                        $.ajax({
                            url: '{{ url("services/" . $service->id . "/") }}' + "/domain/" + itemId +
                            "/delete", // The server-side endpoint URL
                            type: 'DELETE', // Use the DELETE HTTP verb
                            data: {
                                '_token': $('meta[name="csrf-token"]').attr('content'),
                                '_method': 'DELETE'
                            },
                            success: function(result) {
                                if (result.success == true) {
                                    Swal.fire({
                                        icon: result.message_type,
                                        title: result.message_title,
                                        text: result.message_content,
                                        showConfirmButton: true,
                                    });

                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 2000);
                                }
                            }
                        });
                    }
                });
            </script>
        @endsection
