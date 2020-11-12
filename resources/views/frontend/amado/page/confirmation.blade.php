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
                            <input class="form-control {{ $errors->has('payment_person') ? 'error' : ''}}"
                                name="payment_person" type="text"
                                value="{{ old('payment_person') ?? '' }}" placeholder="Nama Pengirim">

                            {!! $errors->first('payment_person', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="col-md-6">
                            {{ Form::select('payment_bank', $bank, null, ['id' => 'location','class'=> $errors->has('payment_bank') ? 'form-control form-control-sm is-invalid' : 'form-control form-control-sm']) }}
                            {!! $errors->first('payment_bank', '<p class="help-block">:message</p>') !!}
                        </div>

                    </div>

                    <div class="row form-group">

                        <div class="col-md-6">
                            <input type="text"
                                class="form-control {{ $errors->has('payment_email') ? 'error' : ''}}"
                                name="payment_email" value="{{ old('payment_email') ?? '' }}"
                                placeholder="Email">
                            {!! $errors->first('payment_email', '<p class="help-block">:message</p>') !!}
                        </div>

                        <div class="col-md-6">
                            <input type="text"
                                class="form-control {{ $errors->has('payment_phone') ? 'error' : ''}}"
                                name="payment_phone"
                                value="{{ old('payment_phone') ?? $order->email ?? '' }}"
                                placeholder="Phone">
                            {!! $errors->first('payment_phone', '<p class="help-block">:message</p>') !!}
                        </div>



                    </div>

                    <div class="cf-title">Tanggal Transfer</div>
                    <div class="row form-group">

                        <div class="col-md-6">
                            <input
                                class="form-control date {{ $errors->has('payment_date') ? 'error' : ''}}"
                                name="payment_date" type="text"
                                value="{{ old('payment_date') ?? date('Y-m-d') }}"
                                placeholder="Payment Date">
                            {!! $errors->first('payment_date', '<p class="help-block">:message</p>') !!}
                        </div>

                        <div class="col-md-6">
                            <input class="form-control {{ $errors->has('code') ? 'error' : ''}}" name="code" type="text"
                                value="{{ old('code') ?? $order->id ?? '' }}" placeholder="Order No.">
                            {!! $errors->first('code', '<p class="help-block">:message</p>')
                            !!}
                        </div>

                    </div>

                    <div class="row form-group">

                        <div class="col-md-6">
                            <input type="text"
                                class="form-control money {{ $errors->has('payment_value') ? 'error' : ''}}"
                                name="payment_value"
                                value="{{ old('payment_value') ?? $order->total ?? '' }}"
                                placeholder="Payment Amount">
                            {!! $errors->first('payment_value', '<p class="help-block">:message</p>') !!}
                        </div>

                        <div class="col-md-6">
                            <input type="file" name="files"
                                class="form-control {{ $errors->has('files') ? 'error' : ''}} btn btn-secondary btn-sm btn-block">
                            {!! $errors->first('files', '<p class="help-block">:message</p>') !!}
                        </div>

                    </div>
                    <div class="row form-group">

                        <div class="col-md-12">
                            <textarea class="form-control {{ $errors->has('payment_notes') ? 'error' : ''}}"
                                name="payment_notes" placeholder="Notes" cols="30"
                                rows="2">{{ old('payment_notes') ?? $order->rajaongkir_notes ?? '' }}</textarea>
                            {!! $errors->first('payment_notes', '<p class="help-block">:message</p>') !!}
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