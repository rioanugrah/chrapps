@extends('layouts.backend.app')
@section('title')
    IP Address
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

@include('backend.address.modalBuat')
@include('backend.address.modalEdit')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title">IP - Addresses</h4>
                    </div>
                    <div class="col-auto">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Baru</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Address</th>
                            <th class="text-center">Network</th>
                            <th class="text-center">Interface</th>
                            <th class="text-center">Invalid</th>
                            <th class="text-center">Dynamic</th>
                            <th class="text-center">Disable</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($responses as $item)
                            <tr>
                                <td class="text-center">{{ $item['.id'] }}</td>
                                <td class="text-center">{{ $item['address'] }}</td>
                                <td class="text-center">{{ $item['network'] }}</td>
                                <td class="text-center">
                                    @switch(explode('-',$item['interface'])[0])
                                        @case('ppp')
                                            <span class="badge bg-primary fs-6">{{ $item['interface'] }}</span>
                                            @break
                                        @case('ether1')
                                            <span class="badge bg-info fs-6">{{ $item['interface'] }}</span>
                                            @break
                                        @case('<l2tp')
                                            <span class="badge bg-success fs-6">{{ $item['interface'] }}</span>
                                            @break
                                        @default

                                    @endswitch
                                    {{-- {{ explode('-',$item['interface'])[0] }} --}}
                                </td>
                                <td class="text-center">{{ $item['invalid'] }}</td>
                                <td class="text-center">
                                    @switch($item['dynamic'])
                                        @case(true)
                                            <span class="badge bg-success fs-6">Yes</span>
                                            @break
                                        @case(false)
                                            <span class="badge bg-danger fs-6">No</span>
                                            @break
                                        @default

                                    @endswitch
                                </td>
                                <td class="text-center">
                                    @switch($item['disabled'])
                                        @case('true')
                                            <span class="badge bg-success fs-6">Yes</span>
                                            @break
                                        @case('false')
                                            <span class="badge bg-danger fs-6">No</span>
                                            @break
                                        @default

                                    @endswitch
                                </td>
                                <td class="text-center">
                                    {{-- <a href="javascript:void" onclick="edit(`{{ $item['.id'] }}`)" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a> --}}
                                    @if ($item['.id'] != '*1')
                                    <a href="{{ route('editIpAddresses',['id' => $item['.id']]) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="javascript:void" class="btn btn-danger delete-btn" data-id="{{ $item['.id'] }}"><i class="fas fa-trash"></i> Delete</a>
                                    @endif
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
    <script src="{{ url('/') }}/assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#form-simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('saveIpAddresses') }}",
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
                        // setTimeout(function(){
                        //     location.reload();
                        // }, 2000);
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

        $('.delete-btn').on('click', function() {
            // Get the ID from the data attribute
            var itemId = $(this).data('id');
            // Get a reference to the table row for later removal
            // var $row = $(this).closest('tr');

            if (confirm('Are you sure you want to delete this item?')) {
            $.ajax({
                url: '{{ url("ip/address/") }}' +"/"+itemId+"/delete", // The server-side endpoint URL
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
                    }
                // On success, remove the row from the page without a full refresh
                // $row.remove();
                // alert('Item deleted successfully!');
                // },
                // error: function(xhr, status, error) {
                // // Handle any errors
                // alert('An error occurred: ' + error);
                }
            });
            }
        });
    </script>
@endsection
