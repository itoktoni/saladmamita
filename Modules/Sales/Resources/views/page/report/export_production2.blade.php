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
        @foreach($value->groupBy('sales_order_detail_variant_item_variant_id') as $data)
        @if($data->sales_order_detail_variant_qty > 0)
        @foreach($data->where('sales_order_detail_variant_qty', '>', 0)->groupBy('sales_order_detail_variant_item_variant_id', '') as $variant)
        <tr>
            <td>{{ str_replace(' 00:00:00', '', $data[0]->sales_order_date_order) ?? '' }} </td>
            <td>{{ $data[0]->item_category_name ?? '' }} </td>
            <td>{{ $data[0]->item_product_name ?? '' ?? '' }} </td>
            <td>{{ $variant[0]->variant->item_variant_name ?? '' }}</td>
            <td>{{ $variant->sum('sales_order_detail_variant_qty') ?? '' }}</td>
        </tr>
        @endforeach
        @else
        <tr>
            <td>{{ str_replace(' 00:00:00', '', $data[0]->sales_order_date_order) ?? '' }} </td>
            <td>{{ $data[0]->item_category_name ?? '' }} </td>
            <td>{{ $data[0]->item_product_name ?? '' }} </td>
            <td>Default</td>
            <td>{{ $data->sum('sales_order_detail_qty') }}</td>
        </tr>
        @endif

        @endforeach
        @endforeach

    </tbody>
</table>