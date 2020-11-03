@extends(Helper::setExtendFrontend())

@section('content')

<!-- Product Details Area Start -->
<div class="single-product-area clearfix mb-15">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mt-50">
                        <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ $item->category->item_category_name ?? '' }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $item->item_product_name ?? '' }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-6 col-lg-7">
                <div class="single_product_thumb">
                    <div id="product_details_slider" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li class="active" data-target="#product_details_slider" data-slide-to="0"
                                style="background-image: url({{ Helper::files('product/'.$item->item_product_image) }});">
                            </li>
                            @foreach($images as $image)
                            <li data-target="#product_details_slider" data-slide-to="{{ $loop->iteration }}"
                                style="background-image: url({{ Helper::files('product_detail/thumbnail_'.$image->item_product_image_file) }});">
                            </li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <a class="gallery_img" href="{{ Helper::files('product/'.$item->item_product_image) }}">
                                    <img class="d-block w-100"
                                        src="{{ Helper::files('product/'.$item->item_product_image) }}">
                                </a>
                            </div>
                            @foreach($images as $image)
                            <div class="carousel-item">
                                <a class="gallery_img"
                                    href="{{ Helper::files('product_detail/'.$image->item_product_image_file) }}">
                                    <img class="d-block w-100"
                                        src="{{ Helper::files('product_detail/'.$image->item_product_image_file) }}"
                                        alt="">
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5 mb-5">
                <div class="single_product_desc">
                    <!-- Product Meta Data -->
                    <div class="product-meta-data">
                        <div class="line"></div>
                        <p class="product-price">Harga {{ Helper::createRupiah($item->item_product_sell) }},-</p>
                        <a href="{{ route('product', ['slug' => $item->item_product_slug]) }}">
                            <h6>{{ $item->item_product_name }}</h6>
                        </a>

                        <!-- Avaiable -->
                        <p class="avaibility"><i class="fa fa-circle"></i> In Stock</p>
                    </div>

                    <div class="short_overview my-2">
                        {!! $item->item_product_description !!}
                    </div>

                    @if ($errors)
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ $error }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    @endforeach
                    @endif

                    <!-- Add to Cart Form -->
                    {!! Form::model($item, ['route'=> ['product', 'slug' =>
                    $item->item_product_slug],'class'=>'form-horizontal','files'=>true])
                    !!}
                    <table id="variant" class="table table-stripe table-sm">
                        <thead>
                            <tr>
                                <td>Variant Name</td>
                                <td class="text-right">Qty</td>
                                <input type="hidden" value="{{ $item->item_product_id }}"
                                    name="detail[temp_product_id]">

                                <input type="hidden" value="{{ $item->item_product_name }}"
                                    name="detail[temp_product_name]">

                                <input type="hidden" value="{{ $item->item_product_sell }}"
                                    name="detail[temp_product_price]">

                                <input type="hidden" value="{{ $item->item_product_image }}"
                                    name="detail[temp_product_image]">
                            </tr>
                        </thead>
                        <tbody>

                            @php
                            $cart = Cart::getContent()->where('id', $item->item_product_id)->first()->attributes ??
                            false;
                            $detail_variant = $item->variant($item->item_product_id);
                            @endphp
                            @if($detail_variant->count() > 1)
                            @foreach($detail_variant as $variant)
                            <tr>
                                <td class="align-middle" width="75%">{{ $variant->item_variant_name }}</td>
                                <td class="align-right align-middle">
                                    <input type="hidden" value="{{ $variant->item_variant_id }}"
                                        name="variant[{{ $variant->item_variant_id }}][temp_variant_id]">

                                    <input type="hidden" value="{{ $variant->item_variant_name }}"
                                        name="variant[{{ $variant->item_variant_id }}][temp_variant_name]">

                                    <input placeholder="Qty" type="text" class="form-control form-control-sm text-right"
                                        value="{{ $cart['variant'][$variant->item_variant_id]['temp_variant_qty'] ?? null }}"
                                        name="variant[{{ $variant->item_variant_id }}][temp_variant_qty]">

                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="2" class="align-middle" width="100%">

                                    <input type="hidden" value="{{ $item->item_product_id }}"
                                        name="detail[temp_product_id]">

                                    <input type="hidden" value="{{ $item->item_product_name }}"
                                        name="detail[temp_product_name]">

                                    <input type="hidden" value="{{ $item->item_product_sell }}"
                                        name="detail[temp_product_price]">

                                    <input type="hidden" value="{{ $item->item_product_image }}"
                                        name="detail[temp_product_image]">

                                    <input placeholder="Input Quantity" type="text"
                                        value="{{ $cart['detail']['temp_product_qty'] ?? null }}"
                                        class="form-control form-control-sm text-right" name="detail[temp_product_qty]">

                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="2">
                                    <textarea name="detail[temp_product_notes]" placeholder="Catatan"
                                        class="form-control form-control-sm"
                                        rows="3">{{ $cart['detail']['temp_product_notes'] ?? null }}</textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-right">
                        <button class="btn btn-primary btn-sm" type="submit">Add Cart</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product Details Area End -->

@endsection