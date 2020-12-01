@extends(Helper::setExtendFrontend())

@push('css')
<style>
.main-content-wrapper .single-product-area .single_product_desc .product-meta-data a {
    display: unset
}

.dataTables_paginate {
    margin-top: 10px
}

.modal-backdrop.show{
    z-index: 0 !important;
    background-color: #fff;
}
</style>
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
                        <li class="breadcrumb-item active" aria-current="page">My Order</li>
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
                            <h6>List Order</h6>
                        </a>

                        <table id="table" class="table table-table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">No. Order</th>
                                    <th scope="col">Create</th>
                                    <th scope="col">Sent</th>
                                    <th style="text-align:right" scope="col">Delivery From</th>
                                    <th style="text-align:center" scope="col">Status</th>
                                    <th style="text-align:center;width:100px;" scope="col">
                                        Detail
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($order as $item)
                                <tr style="position:relative">
                                    <td data-header="Order No.">
                                        {{ $item->sales_order_id ?? '' }}
                                    </td>
                                    <td data-header="Order Date">
                                        {{ $item->sales_order_created_at ? $item->sales_order_created_at->format('d M Y') : '' }}
                                    </td>
                                    <td data-header="Order Date">
                                        {{ $item->sales_order_date_order ? $item->sales_order_date_order->format('d M Y') : '' }}
                                    </td>
                                    <td data-header="Ongkir">
                                        {{ $item->sales_order_from_name ?? '' }}
                                    </td>
                                    <td data-header="Status" align="center">
                                        {{ $status[$item->sales_order_status] ?? '' }}
                                    </td>

                                    <td data-header="Detail" align="center">
                                        <button type="button" class="btn btn-primary btn-sm"
                                            data-toggle="modal" data-target="#{{ $item->sales_order_id ?? '' }}">
                                            Show
                                        </button>
                                        <a target="_blank" style="padding:7.5px 11px" class="btn btn-danger btn-sm" href="{{ route('checkout', ['token' => $item->sales_order_token]) }}">Print</a>
                                    </td>

                                </tr>
                                
                                <!-- Modal Order -->
                                <div class="modal fade" id="{{ $item->sales_order_id ?? '' }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">No.
                                                    Order :
                                                    {{ $item->sales_order_id ?? '' }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <ul class="list-group">
                                                    @if ($item->detail->count() > 0)
                                                    @foreach ($item->detail as $detail)
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">

                                                        {{ $detail->product->item_product_name }}
                                                        <br>
                                                        [
                                                        {{ $detail->sales_order_detail_qty }}
                                                        pcs *
                                                        {{ number_format($detail->sales_order_detail_price) }}
                                                        ]
                                                        <span>{{ number_format($detail->sales_order_detail_total) }}</span>
                                                    </li>
                                                    @endforeach
                                                    @endif
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span>{{ $item->sales_order_sum_ongkir ?? '' }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <div style="position:absolute;bottom:20px;left:20px;">
                                                        Voucher
                                                        {{ $item->sales_order_discount_name ?? '' }}
                                                        :
                                                        -
                                                        {{ $item->sales_order_discount_value ?? '' }}
                                                    </div>
                                                    <div class="pull-right" style="margin-left:5px;margin-right:30px;">
                                                        Total :
                                                        {{ $item->sales_order_sum_total ?? '' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end modal order -->

                                @empty
                                <tr>
                                    <td colspan="7" data-header="Empty Order">
                                        Empty Order
                                    </td>
                                </tr>
                                @endforelse
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