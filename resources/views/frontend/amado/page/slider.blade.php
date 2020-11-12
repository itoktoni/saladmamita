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
                        <li class="breadcrumb-item active" aria-current="page">Page Description</li>
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
                            <h6>{{ $data->marketing_slider_name ?? '' }}</h6>
                        </a>
                        {{ $data->marketing_slider_description ?? '' }}
                    </div>

                    <hr>
                </div>

                <div style="border-bottom:1px solid lightgrey;background-color:white">
                    {!! $data->marketing_slider_page ?? '' !!}
                </div>

            </div>
        </section>
        <!-- checkout section end -->
    </div>
</div>
@endsection