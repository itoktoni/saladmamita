<table>
    <thead>
        <tr>
            <td>Delivery Date</td>
            <td>Category Name</td>
            <td>Product Name</td>
            <td>Variant</td>
            <td>Qty Order</td>
        </tr>
    </thead>
    <tbody>
        @foreach($export->groupBy('sales_order_date_order') as $key => $value)
        @foreach($value->groupBy('sales_order_detail_variant_item_variant_id') as $variant_id => $data)
        @if($variant_id)
        <tr>
            <td>{{ Carbon\Carbon::parse($data[0]->sales_order_date_order)->format('d-m-Y') ?? '' }} </td>
            <td>{{ $data[0]->item_category_name ?? '' }} </td>
            <td>{{ $data[0]->item_product_name ?? '' ?? '' }} </td>
            <td>{{ $data[0]->item_variant_name ?? '' }}</td>
            <td>{{ $data->sum('sales_order_detail_variant_qty') ?? '' }}</td>
        </tr>
        @else
        <tr>
            <td>{{ Carbon\Carbon::parse($data[0]->sales_order_date_order)->format('d-m-Y') ?? '' }} </td>
            <td>{{ $data[0]->item_category_name ?? '' }} </td>
            <td>{{ $data[0]->item_product_name ?? '' }} </td>
            <td>DEFAULT</td>
            <td>{{ $data->sum('sales_order_detail_qty') }}</td>
        </tr>
        @endif
        @endforeach
        @endforeach

    </tbody>
</table>