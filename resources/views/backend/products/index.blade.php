@extends('layouts.backend.app')
@section('title')
    Products
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
@include('backend.products.modalBuat')
@include('backend.products.modalEdit')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Products</h4>
                        </div>
                        @can('product-create')
                        <div class="col-auto">
                            <button class="btn btn-primary" onclick="buat()"><i class="fas fa-plus"></i> Tambah
                                Baru</button>
                        </div>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th class="text-center">Server</th>
                                <th class="text-center">IP Public</th>
                                <th class="text-center">Product Name</th>
                                <th class="text-center">Product Price</th>
                                <th class="text-center">Rate Download</th>
                                <th class="text-center">Rate Upload</th>
                                <th class="text-center">Product Duration</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $item)
                                <tr>
                                    <td class="text-center">{{ $item->server->domain }}</td>
                                    <td class="text-center">{{ $item->server->ip_public }}</td>
                                    <td class="text-center">{{ $item->product_name }}</td>
                                    <td class="text-center">{{ 'Rp. '.number_format($item->product_price,2,',','.') }}</td>
                                    <td class="text-center">{{ $item->rate_download }}</td>
                                    <td class="text-center">{{ $item->rate_upload }}</td>
                                    <td class="text-center">{{ $item->product_duration.' Hari' }}</td>
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
                                        @can('product-edit')
                                        <a class="btn btn-warning" onclick="edit(`{{ $item->id }}`)" data-id="{{ $item->id }}"><i class="fas fa-edit"></i> Edit</a>
                                        @endcan
                                        @can('product-delete')
                                        <a class="btn btn-danger" onclick="hapus(`{{ $item->id }}`)" data-id="{{ $item->id }}"><i class="fas fa-trash"></i> Delete</a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-danger">No Products</td>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function buat()
        {
            $('#modalBuat').modal('show');
        }

        $('#form-simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('product.simpan') }}",
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

        function edit(id)
        {
            $.ajax({
                url: '{{ url("admin/products/") }}' +"/"+id, // The server-side endpoint URL
                type: 'GET', // Use the DELETE HTTP verb
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    '_method': 'GET'
                },
                success: function(result) {
                    if (result.success == true) {
                        // alert(result);
                        $('#edit_id').val(result.data.id);
                        $('#edit_server').val(result.data.server_id);
                        $('#edit_product_name').val(result.data.product_name);
                        $('#edit_product_price').val(result.data.product_price);
                        $('#edit_rate_download').val(result.data.rate_download);
                        $('#edit_rate_upload').val(result.data.rate_upload);
                        $('#edit_product_duration').val(result.data.product_duration);
                        $('#edit_status').val(result.data.status);

                        $('#modalEdit').modal('show');

                    }
                }
            });
        }

        function hapus(id)
        {
            alert(id);
        }

        // $('.edit-btn').on('click', function() {
        //     alert('ok');
        //     // Get the ID from the data attribute
        //     var itemId = $(this).data('id');
        //     // Get a reference to the table row for later removal
        //     // var $row = $(this).closest('tr');

        //     $.ajax({
        //         url: '{{ url("admin/products/") }}' +"/"+itemId, // The server-side endpoint URL
        //         type: 'GET', // Use the DELETE HTTP verb
        //         data: {
        //             '_token': $('meta[name="csrf-token"]').attr('content'),
        //             '_method': 'GET'
        //         },
        //         success: function(result) {
        //             if (result.success == true) {
        //                 // alert(result);
        //                 $('#edit_id').val(result.data.id);
        //                 $('#edit_server').val(result.data.server_id);
        //                 $('#edit_product_name').val(result.data.product_name);
        //                 $('#edit_product_price').val(result.data.product_price);
        //                 $('#edit_rate_download').val(result.data.rate_download);
        //                 $('#edit_rate_upload').val(result.data.rate_upload);
        //                 $('#edit_product_duration').val(result.data.product_duration);
        //                 $('#edit_status').val(result.data.status);

        //                 $('#modalEdit').modal('show');

        //             }
        //         }
        //     });
        // });

        $('#form-update').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('product.update') }}",
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
