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
        @if(isset($model->detail))
        @foreach ($model->detail as $product)
        <tr>
            <td data-title="ID Product">{{ $product['temp_product'] }}</td>
            <td data-title="Product">
                {{ $product['temp_name'] }}
                <input type="hidden" name="detail[{{ $loop->index }}][temp_name]" value="{{ $product['temp_name'] }}">
            </td>
            <td data-title="Price" class="text-right col-lg-1">
                <input type="text" name="detail[{{ $loop->index }}][temp_price]"
                    class="form-control text-right number temp_price"
                    value="{{ !empty($product['temp_price']) ? $product['temp_price'] : 0 }}">
            </td>
            <td data-title="Qty" class="text-right col-lg-1">
                <input type="text" name="detail[{{ $loop->index }}][temp_qty]" class="form-control text-right number temp_qty"
                    value="{{ $product['temp_qty'] }}">
            </td>
            <td data-title="Total" class="text-right col-lg-1">
                <input type="text" readonly name="detail[{{ $loop->index }}][temp_total]"
                    class="form-control text-right number temp_total" value="{{ $product['temp_total'] }}">
            </td>
            <td data-title="Action">
                <input type="hidden" value="{{ $product['temp_id'] }}" name="temp_id[]">
                <input type="hidden" value="{{ $product['temp_id'] }}" name="detail[{{ $loop->index }}][temp_id]">
                <input type="hidden" value="{{ $product['temp_product'] }}" name="detail[{{ $loop->index }}][temp_product]">
                <input type="hidden" value="{{ $product['temp_color'] }}" name="detail[{{ $loop->index }}][temp_color]">
                <input type="hidden" value="{{ $product['temp_size'] }}" name="detail[{{ $loop->index }}][temp_size]">
                <button id="delete" value="{{ $product['temp_id'] }}" type="button"
                    class="btn btn-danger btn-xs btn-block">Delete</button>
                {{-- @if ($model->$key && $detail->contains('item_product_id', $product))
                        <a id="delete"
                            href="{{ route(config('module').'_delete', ['code' => $model->procurement_vendor_id, 'detail' => $product ]) }}"
                class="btn btn-danger btn-xs btn-block">Delete</a>
                @else
                <button id="delete" value="{{ $product }}" type="button" class="btn btn-danger btn-xs btn-block">Delete</button>
                @endif --}}
            </td>
        </tr>
        @endforeach
        @endif
        @if(old('detail'))
        @foreach (old('detail') as $product)
        <tr>
            <td data-title="ID Product">{{ $product['temp_product'] }}</td>
            <td data-title="Product">
                {{ $product['temp_name'] }}
                <input type="hidden" name="detail[{{ $loop->index }}][temp_name]" value="{{ $product['temp_name'] }}">
            </td>
            <td data-title="Price" class="text-right col-lg-1">
                <input type="text" name="detail[{{ $loop->index }}][temp_price]" class="form-control text-right number temp_price"
                    value="{{ !empty($product['temp_price']) ? $product['temp_price'] : 0 }}">
            </td>
            <td data-title="Qty" class="text-right col-lg-1">
                <input type="text" name="detail[{{ $loop->index }}][temp_qty]" class="form-control text-right number temp_qty"
                    value="{{ $product['temp_qty'] }}">
            </td>
            <td data-title="Total" class="text-right col-lg-1">
                <input type="text" readonly name="detail[{{ $loop->index }}][temp_total]" class="form-control text-right number temp_total"
                    value="{{ $product['temp_total'] }}">
            </td>
            <td data-title="Action">
                <input type="hidden" value="{{ $product['temp_id'] }}" name="temp_id[]">
                <input type="hidden" value="{{ $product['temp_id'] }}" name="detail[{{ $loop->index }}][temp_id]">
                <input type="hidden" value="{{ $product['temp_product'] }}" name="detail[{{ $loop->index }}][temp_product]">
                <input type="hidden" value="{{ $product['temp_color'] }}" name="detail[{{ $loop->index }}][temp_color]">
                <input type="hidden" value="{{ $product['temp_size'] }}" name="detail[{{ $loop->index }}][temp_size]">
                <button id="delete" value="{{ $product['temp_id'] }}" type="button" class="btn btn-danger btn-xs btn-block">Delete</button>
                {{-- @if ($model->$key && $detail->contains('item_product_id', $product))
                <a id="delete"
                    href="{{ route(config('module').'_delete', ['code' => $model->procurement_vendor_id, 'detail' => $product ]) }}"
                    class="btn btn-danger btn-xs btn-block">Delete</a>
                @else
                <button id="delete" value="{{ $product }}" type="button"
                    class="btn btn-danger btn-xs btn-block">Delete</button>
                @endif --}}
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
<input type="hidden" value="0" id="temp_counter" name="temp_counter">