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
                                    <th scope="col">Date</th>
                                    <th style="text-align:right" scope="col">Total</th>
                                    <th style="text-align:right" scope="col">Status</th>
                                    <th style="text-align:center" scope="col">Resi</th>
                                    <th style="text-align:center;width:100px;" scope="col">
                                        Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($order as $item)
                                <tr style="position:relative">
                                    <td data-header="Order No.">
                                        <button type="button" class="btn btn-primary btn-block btn-sm"
                                            data-toggle="modal" data-target="#{{ $item->sales_order_id ?? '' }}">
                                            {{ $item->sales_order_id ?? '' }}
                                        </button>
                                    </td>
                                    <td data-header="Order Date">
                                        {{ $item->sales_order_date->format('d M y') }}
                                    </td>
                                    <td data-header="Ongkir">
                                        {{ $item->sales_order_rajaongkir_name ?? '' }}
                                    </td>
                                    <td data-header="Total" align="right">
                                        {{ number_format($item->sales_order_total) ?? '' }}
                                    </td>
                                    <td data-header="Status" align="right">
                                        {{ $status[$item->sales_order_status] ?? '' }}
                                    </td>
                                    <td data-header="Courier" align="center">
                                        {{ strtoupper($item->sales_order_rajaongkir_courier) ?? '' }}
                                    </td>
                                    <td data-header="Detail" align="center">
                                        @if ($item->sales_order_status < 2 || $item->sales_order_status == 0)
                                            <a href="{{ route('confirmation', ['code' => $item->sales_order_id]) }}"
                                                class="btn btn-success btn-sm">
                                                Pay
                                            </a>
                                            @endif
                                            @if ($item->sales_order_rajaongkir_waybill)
                                            <a id="track" target="__blank"
                                                href="{{ route('track', ['code' => $item->sales_order_id]) }}"
                                                class="btn btn-danger btn-sm">
                                                Track
                                            </a>
                                            @endif
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
                                                        {{ $detail->sales_order_detail_item_size ?? '' }}
                                                        {{ $detail->color->item_color_name ?? '' }}
                                                        <br>
                                                        [
                                                        {{ $detail->sales_order_detail_qty_order }}
                                                        pcs *
                                                        {{ number_format($detail->sales_order_detail_price_order) }}
                                                        ]
                                                        @if (config('website.tax'))
                                                        <br>
                                                        VAT
                                                        {{ $detail->sales_order_detail_tax_name }}
                                                        :
                                                        {{ number_format($detail->sales_order_detail_tax_value) }}
                                                        @endif
                                                        <span>{{ number_format($detail->sales_order_detail_total_order) }}</span>
                                                    </li>
                                                    @endforeach
                                                    @endif
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{ $item->sales_order_rajaongkir_service }}
                                                        <span>{{ number_format($item->sales_order_rajaongkir_ongkir) }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <div style="position:absolute;bottom:20px;left:20px;">
                                                        Voucher
                                                        {{ $item->sales_order_marketing_promo_name }}
                                                        :
                                                        -
                                                        {{ number_format($item->sales_order_marketing_promo_value) ?? '' }}
                                                    </div>
                                                    <div class="pull-right" style="margin-left:5px;margin-right:30px;">
                                                        Total :
                                                        {{ number_format($item->sales_order_total) ?? '' }}
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