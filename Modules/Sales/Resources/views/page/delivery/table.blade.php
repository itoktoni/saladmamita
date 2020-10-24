<table id="transaction" class="table table-no-more table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-left col-md-2">Product Name</th>
            <th class="text-left col-md-2">Description</th>
            <th class="text-right col-md-1">Order</th>
            <th class="text-right col-md-1">Send</th>
        </tr>
    </thead>
    <tbody class="markup">
        @if(!empty($detail) || old('detail'))
        @foreach (old('detail') ?? $detail as $item)
        <tr>
            <td data-title="Product">
                <input type="hidden" value="{{ $item['temp_id'] ?? $item->product->item_product_id ?? '' }}"
                    name="detail[{{ $loop->index }}][temp_id]">

                <button type="button" class="btn btn-primary btn-xs">
                    Code : {{ $item['temp_product'] ?? $item->product->item_product_id ?? '' }}
                </button>

                <input type="text" readonly class="form-control input-sm"
                    value="{{ $item['temp_product'] ?? $item->product->item_product_name ?? old('temp_id') }}"
                    name="detail[{{ $loop->index }}][temp_product]">

            </td>
            <td data-title="Description">
                <textarea placeholder="notes" tabindex="{{ $loop->iteration }}5" class="form-control temp_notes"
                    rows="4"
                    name="detail[{{ $loop->index }}][temp_notes]">{{ $item['temp_notes'] ?? $item->sales_delivery_detail_notes }}</textarea>

            </td>
            <td data-title="Qty" class="text-right col-lg-1">
                <input type="text" tabindex="{{ $loop->iteration }}1" name="detail[{{ $loop->index }}][temp_qty]"
                    class="form-control input-sm text-right number" readonly
                    value="{{ $item['temp_qty'] ?? $item->sales_delivery_detail_qty }}">
            </td>
            <td data-title="Send" class="text-right col-lg-1">
                <input type="text" tabindex="{{ $loop->iteration }}2" name="detail[{{ $loop->index }}][temp_out]"
                    class="form-control input-sm text-right money"
                    value="{{ $item['temp_qty'] ?? $item->sales_delivery_detail_out }}">

            </td>
        </tr>
        @endforeach
        @endisset
    </tbody>

</table>