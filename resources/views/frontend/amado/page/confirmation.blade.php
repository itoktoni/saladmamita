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

                <div id="billing" class="">
                    {!!Form::open(['route' => 'confirmation', 'class' => 'checkout-form', 'files' => true]) !!}
                    <div class="cf-title">Description Transfer
                    </div>

                    <div class="row form-group">
                        <div class="col-md-6">
                            <input class="form-control {{ $errors->has('finance_payment_person') ? 'error' : ''}}"
                                name="finance_payment_person" type="text"
                                value="{{ old('finance_payment_person') ?? $order->sales_order_rajaongkir_name ?? '' }}"
                                placeholder="Nama Penerima">

                            {!! $errors->first('finance_payment_person', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="col-md-6">
                            <input type="text"
                                class="form-control {{ $errors->has('finance_payment_email') ? 'error' : ''}}"
                                name="finance_payment_email"
                                value="{{ old('finance_payment_email') ?? $order->sales_order_email ?? '' }}"
                                placeholder="Email">
                            {!! $errors->first('finance_payment_email', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>

                    <div class="row form-group">

                        <div class="col-md-6">
                            <input type="text"
                                class="form-control {{ $errors->has('finance_payment_phone') ? 'error' : ''}}"
                                name="finance_payment_phone"
                                value="{{ old('finance_payment_phone') ?? $order->sales_order_email ?? '' }}"
                                placeholder="Phone">
                            {!! $errors->first('finance_payment_phone', '<p class="help-block">:message</p>') !!}
                        </div>

                        <div class="col-md-6">
                            <input class="form-control date {{ $errors->has('finance_payment_date') ? 'error' : ''}}"
                                name="finance_payment_date" type="text"
                                value="{{ old('finance_payment_date') ?? date('Y-m-d') }}" placeholder="Payment Date">
                            {!! $errors->first('finance_payment_date', '<p class="help-block">:message</p>') !!}
                        </div>

                    </div>

                    <div class="cf-title">Description Order</div>
                    <div class="row form-group">

                        <div class="col-md-6">
                            <input
                                class="form-control {{ $errors->has('finance_payment_sales_order_id') ? 'error' : ''}}"
                                name="finance_payment_sales_order_id" type="text"
                                value="{{ old('finance_payment_sales_order_id') ?? $order->sales_order_id ?? '' }}"
                                placeholder="Order No.">
                            {!! $errors->first('finance_payment_sales_order_id', '<p class="help-block">:message</p>')
                            !!}
                        </div>


                        <div class="col-md-6">
                            <input type="text"
                                class="form-control money {{ $errors->has('finance_payment_amount') ? 'error' : ''}}"
                                name="finance_payment_amount"
                                value="{{ old('finance_payment_amount') ?? $order->sales_order_total ?? '' }}"
                                placeholder="Payment Amount">
                            {!! $errors->first('finance_payment_amount', '<p class="help-block">:message</p>') !!}
                        </div>

                    </div>

                    <div class="row form-group">

                        <div class="col-md-6">
                            <textarea class="form-control {{ $errors->has('finance_payment_note') ? 'error' : ''}}"
                                name="finance_payment_note" placeholder="Notes" cols="30"
                                rows="2">{{ old('finance_payment_note') ?? $order->sales_order_rajaongkir_notes ?? '' }}</textarea>
                            {!! $errors->first('finance_payment_note', '<p class="help-block">:message</p>') !!}
                        </div>

                        <div class="col-md-6">
                            <input type="file" name="files"
                                class="form-control {{ $errors->has('files') ? 'error' : ''}} btn btn-info btn-sm btn-block">
                            {!! $errors->first('files', '<p class="help-block">:message</p>') !!}
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