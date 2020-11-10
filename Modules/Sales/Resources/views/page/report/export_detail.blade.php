<table>
    <thead>
        <tr>
            <td>Sales ID</td>
            <td>Create Date</td>
            <td>Delivery Date</td>
            <td>Customer</td>
            <td>Email</td>
            <td>Phone</td>
            <td>Status</td>
            <td>Branch</td>
            <td>Delivery</td>
            <td>Delivery Notes</td>
            <td>Total Order</td>
            <td>Discount Name</td>
            <td>Discount</td>
            <td>Total Ongkir</td>
            <td>Grand Total</td>
            <td>Waybill</td>
            <td>Category Name</td>
            <td>Product ID</td>
            <td>Product Name</td>
            <td>Qty Order</td>
            <td>Price Order</td>
            <td>Total Order</td>
            <td>Note</td>
        </tr>
    </thead>
    <tbody>
        @foreach($export as $data)
        <tr>
            <td>{{ $data->sales_order_id }} </td>
            <td>{{ $data->sales_order_created_at ? $data->sales_order_created_at->format('d-m-Y') : '' }} </td>
            <td>{{ $data->sales_order_date_order ? $data->sales_order_date_order->format('d-m-Y') : '' }} </td>
            <td>{{ $data->sales_order_to_name }} </td>
            <td>{{ $data->sales_order_to_email }} </td>
            <td>{{ $data->sales_order_to_phone }} </td>
            <td>{{ $data->status[$data->sales_order_status][0] ?? '' }} </td>
            <td>{{ $data->branch_name }} </td>
            <td>{{ $data->rajaongkir_delivery_name }} </td>
            <td>{{ $data->sales_order_delivery_name }} </td>
            <td>{{ $data->sales_order_sum_product }} </td>
            <td>{{ $data->sales_order_discount_name  }} </td>
            <td>{{ $data->sales_order_discount_value }} </td>
            <td>{{ $data->sales_order_sum_ongkir }} </td>
            <td>{{ $data->sales_order_sum_total }} </td>
            <td>{{ $data->sales_order_delivery_name }} </td>
            <td>{{ $data->item_category_name }} </td>
            <td>{{ $data->item_product_id }} </td>
            <td>{{ $data->item_product_name }} </td>
            <td>{{ $data->sales_order_detail_qty }} </td>
            <td>{{ $data->sales_order_detail_price }} </td>
            <td>{{ $data->sales_order_detail_total }} </td>
            <td>{{ $data->sales_order_detail_notes }} </td>
            </tr>
            @endforeach
    </tbody>
</table>