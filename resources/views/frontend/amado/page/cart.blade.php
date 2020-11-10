@extends(Helper::setExtendFrontend())

@section('content')
<!-- Product Details Area Start -->
<div class="single-product-area clearfix">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mt-50">
                        <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Branch</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="single_product_desc">
                    <!-- Product Meta Data -->
                    <div class="product-meta-data">
                        <div class="line"></div>
                        <a chref="{{ route('branch') }}">
                            <h6>List Belanja</h6>
                        </a>

                        <hr>
                        {!!Form::open(['route' => 'cart', 'class' => 'header-search-form', 'files' => true]) !!}
                        <table id="table" class="table table-bordered table-sm table-responsive">
                            <thead>
                                <tr>
                                    <td width="10%">Delete</td>
                                    <td width="10%">Image</td>
                                    <td width="30%">Product Name</td>
                                    <td width="30%">Qty</td>
                                    <td width="10%" class="text-right">Price</td>
                                </tr>
                            </thead>
                            <tbody>
                                @if($carts->count() > 0)
                                @foreach($carts as $cart)
                                @php
                                $item = $cart->attributes->detail ?? null;
                                $product_id = $item['temp_product_id'];
                                @endphp
                                <tr>
                                    <td class="align-middle">
                                        <a onclick="return confirm('Are you sure to delete product ?');"
                                            class="btn btn-danger btn-sm"
                                            href="{{ route('delete', ['id' =>  $product_id ]) }}">Delete</a>
                                    </td>

                                    <td class="align-middle">
                                        <img class="img-fluid"  data-src="{{ Helper::files('product/thumbnail_'.$cart->attributes['detail']['temp_product_image']) }}"
                                            src="{{ Helper::files('product/thumbnail_'.$cart->attributes['detail']['temp_product_image']) }}"
                                            alt="{{ $cart->name }}">
                                    </td>
                                    <td class="align-middle">
                                        <small>{{ $cart->name}}</small>
                                        <textarea name="detail[{{ $loop->index }}][temp_product_notes]"
                                            class="form-control" rows="2">{{ $item['temp_product_notes'] }}</textarea>
                                    </td>

                                    <td class="align-middle">
                                        @if($cart->attributes->variant)

                                        <input type="hidden" value="{{ $item['temp_product_qty'] }}"
                                            name="detail[{{ $loop->index }}][temp_product_qty]">

                                        @foreach($cart->attributes->variant as $var)

                                        <div class="row mt-2 align-items-center">
                                            <div class="col-md-8">
                                                <small>{{ $var['temp_variant_name'] ?? '' }}</small>
                                            </div>
                                            <div class="col-md-4 pull-right">
                                                <input type="text" name="detail[{{ $loop->parent->index }}][temp_product_variant][{{ $loop->index }}][temp_variant_qty]" class="form-control form-control-sm text-right" value="{{ $var['temp_variant_qty'] ?? 0 }}" name="" id="">
                                            </div>

                                            <input type="hidden" value="{{ $var['temp_variant_id'] }}"
                                                name="detail[{{ $loop->parent->index }}][temp_product_variant][{{ $loop->index }}][temp_variant_id]">

                                            <input type="hidden" value="{{ $var['temp_variant_name'] }}"
                                                name="detail[{{ $loop->parent->index }}][temp_product_variant][{{ $loop->index }}][temp_variant_name]">

                                        </div>

                                        @endforeach
                                        @else
                                        <input placeholder="Input Quantity" value="{{ $cart->quantity }}" type="text"
                                            class="form-control form-control-sm text-right"
                                            value="{{ $cart->quantity }}"
                                            name="detail[{{ $loop->index }}][temp_product_qty]">
                                        @endif
                                        <input type="hidden" value="{{ $item['temp_product_id'] }}"
                                            name="detail[{{ $loop->index }}][temp_product_id]">

                                        <input type="hidden" value="{{ $item['temp_product_name'] }}"
                                            name="detail[{{ $loop->index }}][temp_product_name]">

                                        <input type="hidden" value="{{ $item['temp_product_price'] }}"
                                            name="detail[{{ $loop->index }}][temp_product_price]">

                                        <input type="hidden" value="{{ $item['temp_product_image'] }}"
                                            name="detail[{{ $loop->index }}][temp_product_image]">
                                    </td>

                                    <td class="align-middle text-right">

                                        <p>
                                            {{ $cart->quantity }} Pcs x
                                        </p>
                                        <p>
                                            : {{ number_format($cart->price) }}
                                        </p>
                                        <p>
                                            = {{ number_format($cart->getPriceSum()) }}
                                        </p>
                                    </td>

                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4">Sub Total</td>
                                    <td class="text-right">{{ number_format(Cart::getSubTotal()) }}</td>
                                </tr>
                                <tr>
                                    <td class="total-col" colspan="4">
                                        Redem Discount :
                                        {{ Cart::getConditions()->first() ? Cart::getConditions()->first()->getAttributes()['name'] : 'No Voucher' }}
                                    </td>
                                    <td class="text-right">
                                        {{ Cart::getConditions()->first() ? number_format(Cart::getConditions()->first()->getValue()) : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">Grand Total</td>
                                    <td class="text-right">{{ number_format(Cart::getTotal()) }}</td>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="col-md-12 mt-2">
                            <div class="row pull-right">
                                <button class="btn btn-primary pull-right btn-sm" type="submit">Update Cart</button>
                            </div>
                        </div>
                        <div class="clearfix">
                        </div>
                        <hr>


                        {!! Form::close() !!}

                        {!! Form::open(['route' => 'cart', 'class' => 'form-inline pull-right mb-5', 'files' => true])
                        !!}

                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" name="code" placeholder="Enter Promo Code">
                            <div class="input-group-append" id="button-addon4">
                                <button class="btn btn-success" type="submit">Claim</button>
                                <a href="{{ route('checkout') }}" class="btn btn-warning">Checkout</a>
                            </div>
                        </div>

                        {!! Form::close() !!}

                    </div>

                    <div class="row">
                        <div class="">
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


                </div>
            </div>

        </div>
    </div>
</div>
<!-- Product Details Area End -->

@endsection