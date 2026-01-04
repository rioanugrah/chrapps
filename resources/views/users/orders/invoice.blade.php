@extends('layouts.backend.app')
@section('title')
    Invoices
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-title">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <div class="mb-4">
                                    <img src="https://is3.cloudhost.id/eagleinformatika/Logo%20Eagle%20Media%20Informatika.webp" alt="" height="24"><span
                                        class="logo-txt">Eagle Media Informatika</span>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="mb-4">
                                    <h4 class="float-end font-size-16">Invoice #{{ $order->order_code }}</h4>
                                </div>
                            </div>
                        </div>

                        <p class="mb-1"><i class="mdi mdi-email align-middle me-1"></i> contact@eagleinformatika.biz.id</p>
                        {{-- <p><i class="mdi mdi-phone align-middle me-1"></i> 012-345-6789</p> --}}
                    </div>
                    <hr class="my-4">
                    <div class="row">
                        <div class="col-sm-6">
                            <div>
                                <h5 class="font-size-15 mb-3">Billed To:</h5>
                                <h5 class="font-size-14 mb-2">{{ json_decode($order->payment->payment_billing)->first_name.' '.json_decode($order->payment->payment_billing)->last_name }}</h5>
                                <p class="mb-1">{{ json_decode($order->payment->payment_billing)->email }}</p>
                                <p>{{ json_decode($order->payment->payment_billing)->phone }}</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div>
                                <div>
                                    <h5 class="font-size-15">Order Date:</h5>
                                    <p>{{ $order->created_at->format('d-m-Y') }}</p>
                                </div>

                                <div class="mt-4">
                                    <h5 class="font-size-15">Payment Method:</h5>
                                    <p class="mb-1">{{ $order->payment->payment_method }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-2 mt-3">
                        <h5 class="font-size-15">Order summary</h5>
                    </div>
                    <div class="p-4 border rounded">
                        <div class="table-responsive">
                            <table class="table table-nowrap align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 70px;">No.</th>
                                        <th>Item</th>
                                        <th class="text-end" style="width: 120px;">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">01</th>
                                        <td>
                                            <h5 class="font-size-15 mb-1">{{ $order->order_name }}</h5>
                                        </td>
                                        <td class="text-end">{{ 'Rp. '.number_format($order->order_price,2,',','.') }}</td>
                                    </tr>

                                    <tr>
                                        <th scope="row">02</th>
                                        <td>
                                            <h5 class="font-size-15 mb-1">Fee Admin</h5>
                                        </td>
                                        <td class="text-end">{{ 'Rp. '.number_format($order->payment->fee_admin,2,',','.') }}</td>
                                    </tr>

                                    <tr>
                                        <th scope="row" colspan="2" class="text-end">Sub Total</th>
                                        <td class="text-end">{{ 'Rp. '.number_format($order->order_price+$order->payment->fee_admin,2,',','.') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" colspan="2" class="border-0 text-end">
                                            Tax</th>
                                        <td class="border-0 text-end">Rp. 0,00</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" colspan="2" class="border-0 text-end">Total</th>
                                        <td class="border-0 text-end">
                                            <h4 class="m-0">{{ 'Rp. '.number_format($order->order_price+$order->payment->fee_admin,2,',','.') }}</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-print-none mt-3">
                        <div class="float-end">
                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i
                                    class="fa fa-print"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
