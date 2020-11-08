@extends(Helper::setExtendFrontend())

@section('content')

<!-- Product Details Area Start -->
<div class="single-product-area clearfix mt-50">
    <div class="container-fluid">

        <div class="row">
            <div class="col-6 col-lg-7">
                <div class="single_product_thumb">
                    {!! $branch->branch_map !!}
                </div>
            </div>

            <div class="col-12 col-lg-5">
                <div class="single_product_desc">
                    <!-- Product Meta Data -->
                    <div class="product-meta-data">
                        <div class="line"></div>
                        <a href="product-details.html">
                            <h6>About Us</h6>
                        </a>

                        <div class="short_overview">
                        {!! config('website.description') !!}
                        </div>

                        <p class="product-price">Alamat</p>

                        <p>
                            {{ config('website.address') }}
                        </p>

                        <p class="product-price">Contact</p>

                        <p>
                            Phone : {{ config('website.phone') }}
                            <br>
                            Email : {{ config('website.email') }}


                        </p>
                    </div>

                </div>
            </div>

        </div>


    </div>
</div>
<!-- Product Details Area End -->

@endsection