@extends(Helper::setExtendFrontend())

@push('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
@endpush

@push('js')
<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#table').DataTable();
});
</script>
@endpush

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
                            <h6>List Cabang</h6>
                        </a>

                        <hr>
                        <div class="row">
                            <div class="col-md-8">
                                <p class="product-price">Alamat</p>

                                <p>
                                    {{ config('website.address') }}
                                </p>

                            </div>
                            <div class="col-md-4">
                                <p class="product-price">Contact</p>

                                <p>
                                    Phone : {{ config('website.phone') }}
                                </p>

                            </div>
                        </div>


                        <hr>

                        <table id="table" class="table stripe table-sm table-responsive">
                            <thead>
                                <tr>
                                    <td width="25%">Nama Cabang</td>
                                    <td width="15%">Contact</td>
                                    <td width="60%">Alamat</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($branchs as $branch)
                                <tr>
                                    <td>{{ $branch->branch_name }}</td>
                                    <td>{{ $branch->branch_phone }}</td>
                                    <td>{{ $branch->branch_address }} -
                                        {{ Helper::getSingleArea($branch->branch_rajaongkir_area_id, true) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>



                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- Product Details Area End -->

@endsection