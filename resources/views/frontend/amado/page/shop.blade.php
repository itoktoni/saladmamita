@extends(Helper::setExtendFrontend())

@section('content')

<!-- Product Catagories Area Start -->
<div class="container products-catagories-area mb-5 clearfix">

    <div class="amado-pro-catagory clearfix">
        @foreach($product->where('item_product_display', 1) as $item)
        <!-- Single Catagory -->
        <div class="single-products-catagory clearfix">
            <a href="{{ route('product', ['slug' => $item->item_product_slug]) }}">
                <img src="{{ Helper::files('product/'.$item->item_product_image) }}" alt="">
                <!-- Hover Content -->
                <div class="hover-content">
                    <div class="line"></div>
                    <p>Harga {{ Helper::createRupiah($item->item_product_sell) }}</p>
                    <h4>{{ $item->item_product_name }}</h4>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
<!-- Product Catagories Area End -->

@endsection