@extends(Helper::setExtendFrontend())

@push('javascript')
<script>
$(function() {
    $('#carouselExampleIndicators').carousel({
        interval: false
    });
});
</script>
@endpush

@section('content')

<!-- Product Catagories Area Start -->
<div class="container products-catagories-area mb-5 clearfix">

    <div class="col-md-12" style="padding:1vw">

        <div id="carouselExampleIndicators" class="carousel slide mt-5" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach($sliders as $slider)
                <li data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->index }}"
                    class="{{ $loop->first ? 'active' : '' }}"></li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                @foreach($sliders as $slider)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <a
                        href="{{ $slider->marketing_slider_link ? route('single_slider' , ['slug' => $slider->marketing_slider_slug]) : '' }}">
                        <img data-src="{{ Helper::files('slider/'.$slider->marketing_slider_image) }}"
                            class="d-block h-100 w-100"
                            src="{{ Helper::files('slider/'.$slider->marketing_slider_image) }}" alt="First slide">
                    </a>
                </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

    </div>

    <div class="row mt-2">
        <div class="col-md-12 clearfix">
            <div class="row flex justify-content-lg-center">
                @foreach($product->where('item_product_display', 1)->take(3) as $item)
                <!-- Single Catagory -->
                <div class="single-products-catagory-index">
                    <a href="{{ route('product', ['slug' => $item->item_product_slug]) }}">
                        <img data-src="{{ Helper::files('product/'.$item->item_product_image) }}"
                            src="{{ Helper::files('product/'.$item->item_product_image) }}" alt="">
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
    </div>
</div>
<!-- Product Catagories Area End -->

@endsection