@extends('layouts.backend.app')
@section('title')
    Servers
@endsection
@section('css')
    <link href="{{ url('/') }}/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @include('backend.servers.modalBuat')
    @include('backend.servers.modalEdit')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Servers</h4>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary" onclick="buat()"><i class="fas fa-plus"></i> Tambah
                                Baru</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th class="text-center">Domain</th>
                                <th class="text-center">IP Public</th>
                                <th class="text-center">IP Address</th>
                                <th class="text-center">Gateway</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($servers as $item)
                                <tr>
                                    <td class="text-center">{{ $item->domain }}</td>
                                    <td class="text-center">{{ $item->ip_public }}</td>
                                    <td class="text-center">{{ $item->ip_address }}</td>
                                    <td class="text-center">{{ $item->gateway }}</td>
                                    <td class="text-center">
                                        @switch($item->status)
                                            @case('Active')
                                                <span class="badge bg-success">Aktif</span>
                                                @break
                                            @case('InActive')
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                                @break
                                            @default
                                        @endswitch
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void" class="btn btn-warning edit-btn" data-id="{{ $item->id }}"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="javascript:void" class="btn btn-danger delete-btn" data-id="{{ $item->id }}"><i class="fas fa-trash"></i> Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-danger">No Servers</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ url('/') }}/assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script>
        function buat() {
            $('#modalBuat').modal('show');
        }

        $('#form-simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('server.simpan') }}",
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
                        $('#modalBuat').modal('hide');
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
                url: '{{ url("servers/") }}' +"/"+itemId, // The server-side endpoint URL
                type: 'GET', // Use the DELETE HTTP verb
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    '_method': 'GET'
                },
                success: function(result) {
                    if (result.success == true) {
                        // alert(result);
                        $('#edit_id').val(result.data.id);
                        $('#edit_domain').val(result.data.domain);
                        $('#edit_ip_address').val(result.data.ip_address);
                        $('#edit_gateway').val(result.data.gateway);
                        $('#edit_status').val(result.data.status);

                        $('#modalEdit').modal('show');

                    }
                }
            });
        });

        $('#form-update').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('server.update') }}",
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
                        $('#modalEdit').modal('hide');
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
    </script>
@endsection
