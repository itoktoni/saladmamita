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

    <div class="col-md-12">

        <div id="carouselExampleIndicators" class="carousel slide mt-4" data-ride="carousel">
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

</div>
<!-- Product Catagories Area End -->

@endsection