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
                        <li class="breadcrumb-item">
                            <a href="{{ url('') }}">
                                <h2>Pilihan Product</h2>
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- checkout section  -->
        <section class="row" style="margin-top: -20px;">
            <div class="d-flex justify-content-center">

                @foreach($product as $category)
                <div class="col-md-6">
                    <a href="{{ route('shop', ['type' => $category->item_category_slug]) }}">
                        <img class="img-fluid" src="{{ Helper::files('category/'.$category->item_category_image) }}"
                            alt="">
                        <h4 class="text-center mt-3">{{ $category->item_category_name ?? '' }}</h4>
                    </a>
                </div>
                @endforeach

            </div>
        </section>
        <!-- checkout section end -->
    </div>
</div>
@endsection