@extends(Helper::setExtendFrontend())

<x-date :array="['date']" />
<x-mask :array="['number', 'money']" />

@section('content')
<!-- Product Details Area Start -->
<div class="single-product-area clearfix">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mt-50">
                        <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Confirmation Page</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- checkout section  -->
        <section class="row">
            <div class="container">

                <div class="single_product_desc">
                    <!-- Product Meta Data -->
                    <div class="product-meta-data">
                        <div class="line"></div>
                        <a chref="{{ route('branch') }}">
                            <h6>Konfirmasi Pembayaran</h6>
                        </a>
                    </div>
                </div>

                <hr>

                <div class="col-md-12 text-center">
                    @if(session()->has('success'))
                    <div style="margin-top:-20px;" class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Konfirmasi Pemesanan Telah Success, Harap menunggu !</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-12">
                        @if ($errors)
                        @foreach ($errors->all() as $error)
                        <div class="alert alert-sm alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ $error }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>

                <div id="billing" class="">
                    {!!Form::open(['route' => 'confirmation', 'class' => 'checkout-form', 'files' => true]) !!}
                    <div class="cf-title">Description Transfer
                    </div>

                    <div class="row form-group">
                        <div class="col-md-6">
                            <input class="form-control {{ $errors->has('sales_order_payment_person') ? 'error' : ''}}"
                                name="sales_order_payment_person" type="text"
                                value="{{ old('sales_order_payment_person') ?? '' }}" placeholder="Nama Pengirim">

                            {!! $errors->first('sales_order_payment_person', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="col-md-6">
                            {{ Form::select('sales_order_to_area', $bank, null, ['id' => 'location','class'=> $errors->has('sales_order_to_area') ? 'form-control form-control-sm is-invalid' : 'form-control form-control-sm']) }}
                            {!! $errors->first('finance_payment_email', '<p class="help-block">:message</p>') !!}
                        </div>

                    </div>

                    <div class="row form-group">

                        <div class="col-md-6">
                            <input type="text"
                                class="form-control {{ $errors->has('sales_order_payment_email') ? 'error' : ''}}"
                                name="sales_order_payment_email" value="{{ old('sales_order_payment_email') ?? '' }}"
                                placeholder="Email">
                            {!! $errors->first('sales_order_payment_email', '<p class="help-block">:message</p>') !!}
                        </div>

                        <div class="col-md-6">
                            <input type="text"
                                class="form-control {{ $errors->has('sales_order_payment_phone') ? 'error' : ''}}"
                                name="sales_order_payment_phone"
                                value="{{ old('sales_order_payment_phone') ?? $order->sales_order_email ?? '' }}"
                                placeholder="Phone">
                            {!! $errors->first('sales_order_payment_phone', '<p class="help-block">:message</p>') !!}
                        </div>



                    </div>

                    <div class="cf-title">Tanggal Transfer</div>
                    <div class="row form-group">

                        <div class="col-md-6">
                            <input
                                class="form-control date {{ $errors->has('sales_order_payment_date') ? 'error' : ''}}"
                                name="sales_order_payment_date" type="text"
                                value="{{ old('sales_order_payment_date') ?? date('Y-m-d') }}"
                                placeholder="Payment Date">
                            {!! $errors->first('sales_order_payment_date', '<p class="help-block">:message</p>') !!}
                        </div>

                        <div class="col-md-6">
                            <input class="form-control {{ $errors->has('code') ? 'error' : ''}}" name="code" type="text"
                                value="{{ old('code') ?? $order->sales_order_id ?? '' }}" placeholder="Order No.">
                            {!! $errors->first('code', '<p class="help-block">:message</p>')
                            !!}
                        </div>

                    </div>

                    <div class="row form-group">

                        <div class="col-md-6">
                            <input type="text"
                                class="form-control money {{ $errors->has('sales_order_payment_value') ? 'error' : ''}}"
                                name="sales_order_payment_value"
                                value="{{ old('sales_order_payment_value') ?? $order->sales_order_total ?? '' }}"
                                placeholder="Payment Amount">
                            {!! $errors->first('sales_order_payment_value', '<p class="help-block">:message</p>') !!}
                        </div>

                        <div class="col-md-6">
                            <input type="file" name="files"
                                class="form-control {{ $errors->has('files') ? 'error' : ''}} btn btn-secondary btn-sm btn-block">
                            {!! $errors->first('files', '<p class="help-block">:message</p>') !!}
                        </div>

                    </div>
                    <div class="row form-group">

                        <div class="col-md-12">
                            <textarea class="form-control {{ $errors->has('sales_order_payment_notes') ? 'error' : ''}}"
                                name="sales_order_payment_notes" placeholder="Notes" cols="30"
                                rows="2">{{ old('sales_order_payment_notes') ?? $order->sales_order_rajaongkir_notes ?? '' }}</textarea>
                            {!! $errors->first('sales_order_payment_notes', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary pull-right mb-5">Proceed</button>

                    {!! Form::close() !!}
                </div>

            </div>
        </section>
        <!-- checkout section end -->
    </div>
</div>
@endsection