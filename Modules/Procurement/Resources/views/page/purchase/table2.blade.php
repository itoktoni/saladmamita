@push('style')
<style>
    .show-table table {
        width: 100%;
    }

    .show-table td[data-title="Action"],
    .show-table #action {
        display: none !important;
    }
</style>
@endpush

<table id="transaction" class="table table-no-more table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-left col-md-1">ID</th>
            <th class="text-left col-md-4">Product Name</th>
            <th class="text-right col-md-1">Price</th>
            <th class="text-right col-md-1">Qty</th>
            <th class="text-right col-md-1">Total</th>
            <th id="action" class="text-center col-md-1">Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td data-title="ID Product">P200517002</td>
            <td data-title="Product">GANTUNGAN KUNCI DANBO</td>
            <td data-title="Price" class="text-right col-lg-1">
            </td>
            <td data-title="Qty" class="text-right col-lg-1">
            </td>
            <td data-title="Total" class="text-right col-lg-1">
            </td>
            <td data-title="Action">
                <button id="delete" value="P200517002" type="button" class="btn btn-danger btn-block">Delete</button>
            </td>
            <input type="hidden" value="P200517002" name="detail1[0][purchase_detail_price_order]">
            <input type="hidden" value="P200517002" name="detail1[0][purchase_detail_qty_order]">
            <input type="hidden" value="P200517002" name="detail1[0][purchase_detail_option]">
            <input type="hidden" value="0" name="detail1[0][purchase_detail_size]">
            <input type="hidden" value="0" name="detail1[0][purchase_detail_color_id]">
            <input type="hidden" value="P200517002" name="detail1[0][purchase_detail_item_product_id]">
        </tr>
        <tr>
            <td data-title="ID Product">P200517002</td>
            <td data-title="Product">GANTUNGAN KUNCI DANBO</td>
            <td data-title="Price" class="text-right col-lg-1">
            </td>
            <td data-title="Qty" class="text-right col-lg-1">
            </td>
            <td data-title="Total" class="text-right col-lg-1">
            </td>
            <td data-title="Action">
                <button id="delete" value="P200517002" type="button" class="btn btn-danger btn-block">Delete</button>
            </td>
            <input type="hidden" value="P200517001" name="detail[0][temp_id]">
            <input type="hidden" value="10" name="detail[0][temp_qty]">
            <input type="hidden" value="P200517002" name="detail[0][temp_value]">
            <input type="hidden" value="0" name="detail[0][temp_size]">
            <input type="hidden" value="0" name="detail[0][temp_color]">
        </tr>
        <tr>
            <td data-title="ID Product">P200517002</td>
            <td data-title="Product">GANTUNGAN KUNCI DANBO</td>
            <td data-title="Price" class="text-right col-lg-1">
            </td>
            <td data-title="Qty" class="text-right col-lg-1">
            </td>
            <td data-title="Total" class="text-right col-lg-1">
            </td>
            <td data-title="Action">
                <button id="delete" value="P200517002" type="button" class="btn btn-danger btn-block">Delete</button>
            </td>
            <input type="hidden" value="P200517002" name="detail[1][temp_id]">
            <input type="hidden" value="10" name="detail[1][temp_qty]">
            <input type="hidden" value="P200517002" name="detail[1][temp_value]">
            <input type="hidden" value="0" name="detail[1][temp_size]">
            <input type="hidden" value="0" name="detail[1][temp_color]">
        </tr>
        
    </tbody>
</table>