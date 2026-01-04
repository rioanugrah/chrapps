<div class="modal fade" id="modalBuat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Order Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-simpan" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Product Name</label>
                        <select name="product_id" class="form-control" id="selectProduct">
                            <option value="">-- Select Product --</option>
                            @foreach ($products as $item)
                            <option value="{{ $item->id.'|'.$item->product_price }}">{{ $item->product_name.' | Rp. '.number_format($item->product_price,2,',','.').' | '.$item->product_duration.' Hari' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">First Name</label>
                                <input type="text" name="first_name" class="form-control" id="">
                            </div>
                            <div class="col-md-6">
                                <label for="">Last Name</label>
                                <input type="text" name="last_name" class="form-control" id="">
                            </div>
                            <div class="col-md-6">
                                <label for="">Email</label>
                                <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control" id="">
                            </div>
                            <div class="col-md-6">
                                <label for="">Phone</label>
                                <input type="text" name="no_telp" class="form-control" id="">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="">Payment Method</label>
                        {{-- <select name="payment_method" class="form-control" id="">
                            <option value="">-- Select Payment Method --</option>
                            @foreach ($listPayments as $item)
                            @if ($item->group == 'Virtual Account')
                            <option value="{{ $item->code.'|'.$item->total_fee->flat }}">{{ explode('Virtual Account',$item->name)[0].' Rp. '.number_format($item->total_fee->flat,0,',','.') }}</option>
                            @endif
                            @endforeach
                        </select> --}}
                        @foreach ($listPayments as $item)
                            @if ($item->group == 'Virtual Account')
                            <div class="form-check">
                                <input type="radio" name="method" class="form-check-input paymentMethod" id="{{ $item->code }}" value="{{ $item->code.'|'.$item->total_fee->flat }}" required>
                                <label for="{{ $item->code }}">{{ explode('Virtual Account',$item->name)[0] }} &nbsp; - &nbsp; <span style="font-weight: bold">{{ 'Rp. '.number_format($item->total_fee->flat,0,',','.') }}</span></label>
                            </div>
                            @endif
                        @endforeach
                    </div>
                    <hr>
                    <div class="mb-3">
                        <table class="table">
                            <tr>
                                <td>Price</td>
                                <td class="text-end text-success" id="tag_price"></td>
                            </tr>
                            <tr>
                                <td>Fee Admin</td>
                                <td class="text-end text-warning" id="tag_fee_admin"></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Total</td>
                                <td class="text-end fw-bold text-primary" id="tag_total"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
