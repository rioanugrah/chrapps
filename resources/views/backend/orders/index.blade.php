@extends('layouts.backend.app')
@section('title')
    Orders
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
@include('backend.orders.modalBuat')
@include('backend.orders.modalPerpanjangan')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Orders</h4>
                        </div>
                        <div class="col-auto">
                            <a class="btn btn-primary" onclick="buat()"><i class="fas fa-plus"></i> Order
                                Baru</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th class="text-center">Order Code</th>
                                <th class="text-center">Product</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Service Code</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $item)
                            @php
                                // $periodeCount = \Carbon\CarbonPeriod::create('2026-02-04', '2026-02-03')->count();
                                // $periodeCount = \Carbon\CarbonPeriod::create(\Carbon\Carbon::now()->addDays(30)->format('Y-m-d'), $item->service->expired_date)->count();
                                $periodeCount = \Carbon\CarbonPeriod::create(date('Y-m-d'), $item->service->expired_date)->count();
                            @endphp
                                <tr>
                                    <td class="text-center">{{ $item->order_code }}</td>
                                    <td class="text-center">{{ $item->order_name }}</td>
                                    <td class="text-center">{{ 'Rp. '.number_format($item->order_price,2,',','.') }}</td>
                                    <td class="text-center text-info fw-bold">
                                        {{ '#'.explode('|',$item->service->service_code)[0] }}
                                    </td>
                                    <td class="text-center">
                                        @switch($item->status)
                                            @case('Pending')
                                                <span class="badge bg-warning" style="color: black">{{ $item->status }}</span>
                                                @break
                                            @case('Paid')
                                                @if ($periodeCount >= 1 && $periodeCount <= 5)
                                                    <span class="badge bg-warning" style="color: black">Reminder {{ $periodeCount.' Days' }}</span>
                                                @elseif($periodeCount == 0)
                                                    <span class="badge bg-danger">Service Shutdown</span>
                                                @else
                                                    <span class="badge bg-success" style="color: black">{{ $item->status }}</span>
                                                @endif
                                                @break
                                            @case('Canceled')
                                                <span class="badge bg-danger" style="color: black">{{ $item->status }}</span>
                                                @break
                                            @case('Expired')
                                                <span class="badge bg-danger" style="color: black">{{ $item->status }}</span>
                                                @break
                                            @default
                                        @endswitch
                                    </td>
                                    <td class="text-center">
                                        @if ($periodeCount >= 1 && $periodeCount <= 5)
                                        <a class="btn btn-sm text-white" onclick="perpanjangan(`{{ $item->id }}`)" style="background: linear-gradient(90deg, #007E6E 0%, #628141 100%);"><i class="fas fa-money-bill-alt"></i> Perpanjangan</a>
                                        @endif
                                        @if ($item->payment->status != 'Paid')
                                        {{-- <a class="btn btn-sm edit-btn text-white" style="background: linear-gradient(90deg, #9E3B3B 0%, #FF0000 100%);" data-id="{{ $item->id }}"><i class="fas fa-ban"></i> Cancel</a> --}}
                                        <a href="{{ json_decode($payment->detailTransaction($item->payment->payment_references))->data->checkout_url }}" target="_blank" class="btn btn-sm delete-btn text-white" style="background: linear-gradient(90deg, #018790 0%, #00B7B5 100%);" data-id="{{ $item->id }}"><i class="fas fa-money-check"></i> Buy Now</a>
                                        @else
                                        <a href="{{ route('order.invoice',['id' => $item->id]) }}" class="btn btn-sm text-white" style="background: linear-gradient(90deg, #05339C 0%, #1055C9 100%);"><i class="fas fa-file-invoice"></i> Invoice</a>
                                        @endif
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
    <script src="{{ url('/') }}/assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script>
        function buat()
        {
            $('#modalBuat').modal('show');
        }

        $('#form-simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('order.simpan') }}",
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
                            // window.location.reload();
                            window.location.href = result.link_payment;
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
                url: '{{ url("products/") }}' +"/"+itemId, // The server-side endpoint URL
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
                        $('#edit_product_duration').val(result.data.product_duration);
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

        function perpanjangan(id)
        {
            // alert(id)
            $.ajax({
                url: '{{ url("admin/orders/") }}' +"/"+id, // The server-side endpoint URL
                type: 'GET', // Use the DELETE HTTP verb
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    '_method': 'GET'
                },
                success: function(result) {
                    if (result.success == true) {
                        // alert(result);
                        $('#perpanjangan_id').val(result.data.id);
                        document.getElementById('perpanjangan_product_name').innerHTML = result.data.order_name;

                        const paymentMethodPerpanjangan = document.querySelectorAll('input[name="method"]');
                            paymentMethodPerpanjangan.forEach((radio) => {
                            radio.addEventListener('change', function() {
                                console.log('Selected value:', this.value);
                                if (this.value.split('|')[0] != 'QRISC') {
                                    document.getElementById('tag_perpanjangan_price').innerHTML = formatterIDR.format(parseFloat(result.data.product.product_price));
                                    document.getElementById('tag_perpanjangan_fee_admin').innerHTML = formatterIDR.format(this.value.split('|')[1]);
                                    document.getElementById('tag_perpanjangan_total').innerHTML = formatterIDR.format(parseFloat(result.data.product.product_price)+parseFloat(this.value.split('|')[1]));
                                    // console.log($('#selectProduct').val());
                                }else{
                                }
                            });
                        });

                        $('#modalPerpanjangan').modal('show');

                    }
                }
            });
        }

        $('#form-perpanjangan-simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('order.perpanjangan_simpan') }}",
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
                        $('#modalPerpanjangan').modal('hide');
                        this.reset();
                        setTimeout(() => {
                            // window.location.reload();
                            window.location.href = result.link_payment;
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

        const formatterIDR = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
        });

        const paymentMethod = document.querySelectorAll('input[name="method"]');
            paymentMethod.forEach((radio) => {
            radio.addEventListener('change', function() {
                console.log('Selected value:', this.value);
                if (this.value.split('|')[0] != 'QRISC') {
                    document.getElementById('tag_price').innerHTML = formatterIDR.format($('#selectProduct').val().split('|')[1]);
                    document.getElementById('tag_fee_admin').innerHTML = formatterIDR.format(this.value.split('|')[1]);
                    document.getElementById('tag_total').innerHTML = formatterIDR.format(parseFloat($('#selectProduct').val().split('|')[1])+parseFloat(this.value.split('|')[1]));
                    // console.log($('#selectProduct').val());
                }else{
                }
            });
        });
    </script>
@endsection
