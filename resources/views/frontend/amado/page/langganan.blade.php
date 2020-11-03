@extends(Helper::setExtendFrontend())
<x-date :array="['date']" />
@section('content')

@php
$area = session()->has('area') ? session()->get('area') : false;
$city = $location = [];
if($area){
$city = $area['city'] ?? [];
$location = $area['area'] ?? [];
}
@endphp

<!-- Product Details Area Start -->
<div class="single-product-area clearfix">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mt-50">
                        <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Berlangganan</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="single_product_desc">
                    <!-- Product Meta Data -->
                    {!!Form::open(['route' => 'langganan', 'class' => 'checkout-form', 'files' => true]) !!}

                    <div class="product-meta-data">
                        <div class="line"></div>
                        <a chref="{{ route('langganan') }}">
                            <h6>Berlangganan</h6>
                        </a>
                    </div>

                    <hr>

                    <div class="col-md-12">
                        <div class="single_product_desc">
                            <div>
                                <div class="row form-group">

                                    <div class="col-md-4">
                                        <label>Name</label>
                                        {!! Form::text('sales_langganan_to_name', $user->name ??
                                        null, ['class' =>
                                        $errors->has('sales_langganan_to_name') ? 'form-control form-control-sm
                                        is-invalid' : 'form-control form-control-sm']) !!}

                                        {!! $errors->first('sales_langganan_to_name', '<small
                                            class="form-text text-danger">:message</small>') !!}
                                    </div>

                                    <div class="col-md-4">
                                        <label>Email</label>
                                        {!! Form::text('sales_langganan_to_email', $user->email ??
                                        null, ['class' =>
                                        $errors->has('sales_langganan_to_email') ? 'form-control form-control-sm
                                        is-invalid' : 'form-control form-control-sm']) !!}

                                        {!! $errors->first('sales_langganan_to_email', '<small
                                            class="form-text text-danger">:message</small>') !!}
                                    </div>
                                    <div class="col-md-4">
                                        <label>Phone</label>
                                        {!! Form::text('sales_langganan_to_phone', $user->phone ??
                                        null, ['class' =>
                                        $errors->has('sales_langganan_to_phone') ? 'form-control form-control-sm
                                        is-invalid' : 'form-control form-control-sm']) !!}

                                        {!! $errors->first('sales_langganan_to_phone', '<small
                                            class="form-text text-danger">:message</small>') !!}
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <label>Address</label>
                                        {!! Form::textarea('sales_langganan_to_address', $user->address ??
                                        null, ['rows' => 2, 'class' =>
                                        $errors->has('sales_langganan_to_address') ? 'form-control form-control-sm
                                        is-invalid' : 'form-control form-control-sm']) !!}

                                        {!! $errors->first('sales_langganan_to_address', '<small
                                            class="form-text text-danger">:message</small>') !!}
                                    </div>
                                </div>
                                <hr>

                                <div class="row form-group">
                                    <div class="col-md-4">
                                        {{ Form::select('province', $list_province, isset($area['province']) ? array_keys($area['province']) : null, ['id' => 'province', 'class'=> 'form-control form-control-sm']) }}
                                    </div>
                                    <div class="col-md-4">
                                        {{ Form::select('city', $city ?? [], null, ['id' => 'city','class'=> 'form-control form-control-sm']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <input type="hidden" id="area_name" value="{{ old('area_name') ?? null }}"
                                            name="area_name">
                                        {{ Form::select('sales_langganan_to_area', $location ?? [], null, ['id' => 'location','class'=> $errors->has('sales_langganan_to_area') ? 'form-control form-control-sm is-invalid' : 'form-control form-control-sm']) }}
                                        {!! $errors->first('sales_langganan_to_area', '<small
                                            class="form-text text-danger">:message</small>') !!}
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        {{ Form::select('sales_langganan_marketing_langganan_id', $langganan ?? [], request()->get('code') ?? null, ['class'=> $errors->has('sales_langganan_marketing_langganan_id') ? 'form-control form-control-sm is-invalid' : 'form-control form-control-sm']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend">
                                                <span class="btn btn-secondary" id="inputGroup-sizing-sm">
                                                    Tgl Mulai
                                                </span>
                                            </div>
                                            {!! Form::text('sales_langganan_date_order',
                                            $model->sales_langganan_date_order ??
                                            date('Y-m-d'), ['class' =>
                                            $errors->has('sales_langganan_date_order') ? 'form-control form-control-sm
                                            date
                                            is-invalid' : 'form-control form-control-sm date']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        {{ Form::select('sales_langganan_from_id', $branch ?? [], null, ['class'=> $errors->has('sales_langganan_from_id') ? 'form-control form-control-sm is-invalid' : 'form-control form-control-sm']) }}
                                    </div>
                                </div>
                                <div class="row form-group">


                                    <div class="col-md-8">
                                        {!! Form::textarea('sales_langganan_notes_external', null, ['class' =>
                                        'form-control form-control-sm',
                                        'rows' => 3, 'placeholder' => 'Catatan Pengiriman']) !!}
                                        {!! $errors->first('name', '<p class="text-danger">:message</p>')
                                        !!}
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Promo Code</label>
                                        {!! Form::text('sales_langganan_discount_code',
                                        null, ['class' =>
                                        $errors->has('sales_langganan_discount_code') ? 'form-control form-control-sm
                                        is-invalid' : 'form-control form-control-sm']) !!}

                                        {!! $errors->first('sales_langganan_discount_code', '<small
                                            class="form-text text-danger">:message</small>') !!}
                                    </div>

                                </div>

                                <hr>

                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <p class="text-right">
                                            <a class="btn btn-warning btn-sm" href="{{ route('login') }}">Login</a>

                                            <button type="submit" name="pilih" value="pilih"
                                                class="btn btn-primary btn-sm">
                                                Pilih Variant
                                            </button>
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="container">
                            <div class="col-md-12">
                                @if(!empty($langganan_data))
                                @for ($i = 0; $i < $langganan_data->marketing_langganan_day; $i++)
                                    @php
                                    $tanggal = request()->get('date');
                                    $date = \Carbon\Carbon::createFromFormat('Y-m-d', $tanggal, 'Asia/Jakarta');
                                    @endphp

                                    <table class="table table-bordered table-responsive">
                                        <thead>
                                            <tr class="{{ $errors->has('hari.'.$i.'.qty') ? 'table-danger' : '' }}"
                                                style="background-color: whitesmoke;">
                                                <td width="60%" class="align-middle align-items-center">
                                                    Hari ke {{ $i+1 }}
                                                    {{ $errors->has('hari.'.$i.'.qty') ? '- Error : Qty Harus Diisi' : '' }}
                                                </td>
                                                <td width="50%" class="align-middle align-items-center">
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="btn btn-secondary" id="inputGroup-sizing-sm">
                                                                Tgl Kirim
                                                            </span>
                                                        </div>

                                                        <input type="text"
                                                            class="form-control form-control-sm text-right date"
                                                            value="{{ $date->addDay($i)->format('Y-m-d') ?? date('Y-m-d') }}"
                                                            name="detail[{{ $i }}][langganan_date]">

                                                    </div>
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($product as $item)
                                            <tr>
                                                <td class="align-middle">
                                                    {{ $item->item_product_name }}
                                                    ( Harga : {{ Helper::createRupiah($item->item_product_sell) }} )
                                                    <textarea placeholder="Catatan Pesanan"
                                                        name="detail[{{ $i }}][product][{{ $loop->index }}][sales_order_detail_notes]"
                                                        class="form-control mt-2"
                                                        rows="2">{{ old('detail.'.$i.'.product.'.$loop->index.'.sales_order_detail_notes') ?? '' }}</textarea>
                                                </td>

                                                <td class="align-middle align-items-center">
                                                    @if($item->variant($item->item_product_id)->count() > 0)

                                                    @foreach($item->variant($item->item_product_id) as $var)

                                                    <div class="row mt-2 align-items-center">
                                                        <div class="col-md-8">
                                                            <small>{{ $var->item_variant_name ?? '' }}</small>
                                                        </div>
                                                        <div class="col-md-4 pull-right">
                                                            <input type="text" placeholder="Qty"
                                                                value="{{ old('detail.'.$i.'.product.'.$loop->parent->index.'.variant.'.$loop->index.'.sales_order_detail_variant_qty') ?? '' }}"
                                                                class="form-control form-control-sm text-right"
                                                                name="detail[{{ $i }}][product][{{ $loop->parent->index }}][variant][{{ $loop->index }}][sales_order_detail_variant_qty]">
                                                        </div>
                                                    </div>

                                                    <input type="hidden" value="{{ $item->item_product_id }}"
                                                        name="detail[{{ $i }}][product][{{ $loop->parent->index }}][variant][{{ $loop->index }}][sales_order_detail_variant_item_product_id]">
                                                    <input type="hidden" value="{{ $var->item_variant_id ?? '' }}"
                                                        name="detail[{{ $i }}][product][{{ $loop->parent->index }}][variant][{{ $loop->index }}][sales_order_detail_variant_item_variant_id]">

                                                    @endforeach
                                                    @else
                                                    <input placeholder="Input Quantity" type="text"
                                                        class="form-control form-control-sm text-right"
                                                        value="{{ old('detail.'.$i.'.product.'.$loop->index.'.sales_order_detail_qty') ?? '' }}"
                                                        name="detail[{{ $i }}][product][{{ $loop->index }}][sales_order_detail_qty]">
                                                    @endif

                                                    <input type="hidden" value="{{ $item->item_product_id }}"
                                                        name="detail[{{ $i }}][product][{{ $loop->index }}][sales_order_detail_item_product_id]">

                                                    <input type="hidden" value="{{ $item->item_product_sell }}"
                                                        name="detail[{{ $i }}][product][{{ $loop->index }}][sales_order_detail_price]">

                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>

                                    </table>

                                    @endfor
                                    @endif

                                    @if(!empty($langganan_data))
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <p class="text-right">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    Berlangganan
                                                </button>
                                            </p>
                                        </div>
                                    </div>
                                    @endif
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

<style>
.table-bordered {
    border: unset;
}
</style>

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

    $('#location').change(function() {
        var data = $("#location option:selected").text();
        $('#area_name').val(data);
    });

});
</script>
@endpush

@endsection