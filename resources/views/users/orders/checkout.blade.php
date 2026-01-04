@extends('layouts.backend.app')
@section('title')
    Checkout
@endsection
@section('css')
    <link href="{{ url('/') }}/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">@yield('title')</h4>
                <div class="">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a>Dashboard</a></li>
                        <li class="breadcrumb-item"><a>Order</a></li>
                        <li class="breadcrumb-item active">@yield('title')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <form id="form-simpan" method="post">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h5>Billing</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">First Name</label>
                                    <input type="text" name="first_name" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">Email</label>
                                    <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control"
                                        id="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">Phone</label>
                                    <input type="text" name="no_telp" class="form-control" id="">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="">Payment Method</label>
                            @foreach ($listPayments as $item)
                                @if ($item->group == 'Virtual Account')
                                <div class="form-check">
                                    <input type="radio" name="method" class="form-check-input paymentMethod" id="{{ $item->code }}" value="{{ $item->code.'|'.$item->total_fee->flat }}" required>
                                    <label for="{{ $item->code }}">{{ explode('Virtual Account',$item->name)[0] }} &nbsp; - &nbsp; <span style="font-weight: bold">{{ 'Rp. '.number_format($item->total_fee->flat,0,',','.') }}</span></label>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h5>Billing Detail</h5>
                        <hr>
                        <div class="mb-3">
                            <label for="">Product Item</label>
                            <div>{{ $product->product_name }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="">Price</label>
                            <div>{{ 'Rp. '.number_format($product->product_price,2,',','.') }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="">Fee Admin</label>
                            <div id="tag_fee_admin"></div>
                        </div>
                        <div class="mb-3">
                            <label for="">Total</label>
                            <div id="tag_total"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('user.order') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-success">Checkout Now</button>
            </div>
        </div>
    </form>
@endsection
@section('js')
    <script src="{{ url('/') }}/assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script>
        $('#form-simpan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('user.order.buy_now',['id' => $product->id]) }}",
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

        const formatterIDR = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
        });

        const paymentMethod = document.querySelectorAll('input[name="method"]');
            paymentMethod.forEach((radio) => {
            radio.addEventListener('change', function() {
                console.log('Selected value:', this.value);
                if (this.value.split('|')[0] != 'QRISC') {
                    document.getElementById('tag_fee_admin').innerHTML = formatterIDR.format(this.value.split('|')[1]);
                    document.getElementById('tag_total').innerHTML = formatterIDR.format(parseFloat({{ $product->product_price }})+parseFloat(this.value.split('|')[1]));
                    // console.log($('#selectProduct').val());
                }else{
                }
                // You can perform actions here based on the selected radio button
            });
        });
    </script>
@endsection
