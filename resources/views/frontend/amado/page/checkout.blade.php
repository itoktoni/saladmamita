@extends(Helper::setExtendFrontend())
<x-date :array="['date']" />
@section('content')

<!-- Product Details Area Start -->
<div class="single-product-area clearfix">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mt-50">
                        <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="single_product_desc">
                    <!-- Product Meta Data -->
                    {!!Form::open(['route' => 'checkout', 'class' => 'checkout-form', 'files' => true]) !!}
                    <div class="row">
                        <div class="col-md-7">

                            <div class="product-meta-data">
                                <div class="line"></div>
                                <a chref="{{ route('branch') }}">
                                    <h6>Checkout</h6>
                                </a>
                            </div>

                            <table class="table table-bordered table-hover mt-3">
                                <thead>
                                    <tr>
                                        <td class="text-left" width="60%">Product Name</td>
                                        <td class="text-right" width="15%">Price</td>
                                        <td class="text-right" width="10%">Qty</td>
                                        <td class="text-right" width="15%">Qty</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($carts->count() > 0)
                                    @foreach($carts as $cart)
                                    @php
                                    $item = $cart->attributes->detail ?? null;
                                    $product_id = $cart->id;
                                    @endphp
                                    <tr>
                                        <td>
                                            {{ $cart->name }}

                                            <input type="hidden" value="{{ $product_id }}"
                                                name="detail[{{ $loop->index }}][sales_order_detail_item_product_id]">

                                            <input type="hidden" value="{{ $cart->quantity }}"
                                                name="detail[{{ $loop->index }}][sales_order_detail_qty]">

                                            <input type="hidden" value="{{ $cart->price }}"
                                                name="detail[{{ $loop->index }}][sales_order_detail_price]">

                                            <input type="hidden" value="{{ $cart->price * $cart->quantity }}"
                                                name="detail[{{ $loop->index }}][sales_order_detail_total]">

                                            <input type="hidden" value="{{ $item['temp_product_notes'] }}"
                                                name="detail[{{ $loop->index }}][sales_order_detail_notes]">

                                            @if($cart->attributes->variant)
                                            <ul>
                                                @foreach($cart->attributes->variant as $var)
                                                <input type="hidden" value="{{ $product_id }}"
                                                    name="detail[{{ $loop->parent->index }}][variant][{{ $loop->index }}][sales_order_detail_variant_item_product_id]">

                                                <input type="hidden" value="{{ $var['temp_variant_id'] }}"
                                                    name="detail[{{ $loop->parent->index }}][variant][{{ $loop->index }}][sales_order_detail_variant_item_variant_id]">

                                                <input type="hidden" value="{{ $var['temp_variant_qty'] }}"
                                                    name="detail[{{ $loop->parent->index }}][variant][{{ $loop->index }}][sales_order_detail_variant_qty]">

                                                @if($var['temp_variant_qty'] > 0)
                                                <li>- <span
                                                        class="badge badge-dark">{{ $var['temp_variant_qty'] ?? 0 }}</span>
                                                    {{ Str::lower($var['temp_variant_name']) ?? '' }}
                                                </li>
                                                @endif
                                                @endforeach
                                            </ul>
                                            @endif
                                        </td>
                                        <td class="align-middle text-right">{{ number_format($cart->price) }}</td>
                                        <td class="align-middle text-right">{{ $cart->quantity }}</td>
                                        <td class="align-middle text-right">{{ number_format($cart->getPriceSum()) }}
                                        </td>
                                    </tr>

                                    @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="3">Sub Total</td>
                                        <td class="text-right">{{ number_format(Cart::getSubTotal()) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="total-col text-right" colspan="3">
                                            Redem Discount :
                                            {{ Cart::getConditions()->first() ? Cart::getConditions()->first()->getAttributes()['name'] : 'No Voucher' }}
                                        </td>
                                        <td class="text-right">
                                            {{ Cart::getConditions()->first() ? number_format(Cart::getConditions()->first()->getValue()) : 0 }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="3">Grand Total</td>
                                        <td class="text-right">{{ number_format(Cart::getTotal()) }}</td>
                                    </tr>
                                </tfoot>
                            </table>

                            <small id="passwordHelpBlock" class="form-text text-muted mb-3">
                                {!! config('website.header') !!}
                            </small>

                            <hr>

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="">Pilihan Pickup Barang</label>
                                        @php

                                        @endphp
                                        {{ Form::select('sales_order_from_id', $branch, null, ['class'=> $errors->has('sales_order_from_id') ? 'form-control form-control-sm is-invalid' : 'form-control form-control-sm']) }}
                                        {!! $errors->first('sales_order_from_id', '<small
                                            class="form-text text-danger">:message</small>') !!}
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="">Metode Pengambilan Barang</label>
                                        {{ Form::select('sales_order_delivery_type', $metode, null, ['class'=> $errors->has('sales_order_delivery_type') ? 'form-control form-control-sm is-invalid' : 'form-control form-control-sm']) }}
                                        {!! $errors->first('sales_order_delivery_type', '<small
                                            class="form-text text-danger">:message</small>') !!}
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="col-md-5">
                            <div class="single_product_desc">

                                <div>

                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <label>Name</label>
                                            <input type="text" name="sales_order_to_name"
                                                class="form-control form-control-sm {{ $errors->has('sales_order_to_name') ? 'is-invalid' : ''}}"
                                                value="{{ old('sales_order_to_name') ?? null }}">
                                            {!! $errors->first('sales_order_to_name', '<small
                                                class="form-text text-danger">:message</small>') !!}
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-6">
                                            <label>Email</label>
                                            <input type="text" name="sales_order_to_email"
                                                class="form-control form-control-sm {{ $errors->has('sales_order_to_email') ? 'is-invalid' : ''}}"
                                                value="{{ old('sales_order_to_email') ?? null }}">
                                            {!! $errors->first('sales_order_to_email', '<small
                                                class="form-text text-danger">:message</small>') !!}
                                        </div>
                                        <div class="col-md-6">
                                            <label>Phone</label>
                                            <input type="text" name="sales_order_to_phone"
                                                class="form-control form-control-sm {{ $errors->has('sales_order_to_phone') ? 'is-invalid' : ''}}"
                                                value="{{ old('sales_order_to_phone') ?? null }}">
                                            {!! $errors->first('sales_order_to_phone', '<small
                                                class="form-text text-danger">:message</small>') !!}
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <label>Address</label>
                                            <textarea name="sales_order_to_address"
                                                class="form-control {{ $errors->has('sales_order_to_address') ? 'is-invalid' : '' }}"
                                                rows="2">{{ old('sales_order_to_address') ?? '' }}</textarea>
                                            {!! $errors->first('sales_order_to_address', '<small
                                                class="form-text text-danger">:message</small>') !!}
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            {{ Form::select('province', $list_province, isset($area['province']) ? array_keys($area['province']) : null, ['id' => 'province', 'class'=> ''.($errors->has('province') ? 'error':'')]) }}
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            {{ Form::select('city', $area['city'] ?? [], null, ['id' => 'city','class'=> 'chosen']) }}
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <input type="hidden" id="area_name" value="{{ old('area_name') ?? null }}" name="area_name">
                                            {{ Form::select('sales_order_to_area', [old('sales_order_to_area') => old('area_name')] ?? [], null, ['id' => 'location','class'=> $errors->has('sales_order_to_area') ? 'form-control form-control-sm is-invalid' : 'form-control form-control-sm']) }}
                                            {!! $errors->first('sales_order_to_area', '<small
                                                class="form-text text-danger">:message</small>') !!}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <label>Dikirim Tanggal</label>
                                            {!! Form::text('sales_order_date_order', $model->sales_order_date_order ??
                                            date('Y-m-d'), ['class' =>
                                            $errors->has('sales_order_date_order') ? 'form-control form-control-sm date
                                            is-invalid' : 'form-control form-control-sm date']) !!}
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            {!! Form::textarea('sales_order_notes_external', null, ['class' =>
                                            'form-control form-control-sm',
                                            'rows' => 2, 'placeholder' => 'Catatan Pengiriman']) !!}
                                            {!! $errors->first('name', '<p class="text-danger">:message</p>')
                                            !!}
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <p class="text-right">
                                                <a class="btn btn-warning btn-sm" href="{{ route('login') }}">Login</a>

                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    Create Order
                                                </button>
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Product Details Area End -->

@push('javascript')

<script>
$(document).ready(function() {

    $('#province').change(function() { // Jika Select Box id provinsi dipilih
        var data = $("#province option:selected");
        var province = data.val(); // Ciptakan variabel provinsi
        var city = $('#city');
        $.ajax({
            type: 'GET', // Metode pengiriman data menggunakan POST
            url: '{{ route("city") }}',
            data: 'province=' + province, // Data yang akan dikirim ke file pemroses
            success: function(response) { // Jika berhasil
                city.empty();
                city.append('<option value=""></option>');
                $.each(response, function(idx, obj) {
                    city.append('<option postcode="' + obj
                        .rajaongkir_city_postal_code + '" value="' + obj
                        .rajaongkir_city_id + '">' + obj.rajaongkir_city_name +
                        '</option>');
                });
                city.trigger("chosen:updated");
            }
        });
    });

    $('#city').change(function() { // Jika Select Box id provinsi dipilih
        var data = $("#city option:selected");
        var city = data.val(); // Ciptakan variabel provinsi
        // var postcode = data.attr('postcode');
        var location = $('#location');
        // $('#postcode').val(postcode);
        $.ajax({
            type: 'GET', // Metode pengiriman data menggunakan POST
            url: '{{ route("location") }}',
            data: 'city=' + city, // Data yang akan dikirim ke file pemroses
            success: function(response) { // Jika berhasil
                location.empty();
                location.append('<option value=""></option>');
                $.each(response, function(idx, obj) {
                    location.append('<option value="' + obj.rajaongkir_area_id +
                        '">' + obj.rajaongkir_area_name + '</option>');
                });
                $("#location").trigger("chosen:updated");
            }
        });
    });

    $('#location').change(function(){
        var data = $("#location option:selected").text();
        $('#area_name').val(data);
    });

});
</script>
@endpush

@endsection