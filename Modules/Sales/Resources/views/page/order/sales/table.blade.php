<table id="transaction" class="table table-no-more table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-left col-md-1">Product ID</th>
            <th class="text-left col-md-4">Product Name and Description</th>
            <th class="text-right col-md-1">Qty</th>
            <th class="text-right col-md-1">Price</th>
            <th class="text-right col-md-1">Total</th>
        </tr>
    </thead>
    <tbody class="markup">
        @if(!empty($detail) || old('detail'))
        @foreach (old('detail') ?? $detail as $item)
        <tr>
            <td data-title="ID Product">
                @if(old('detail'))
                <button id="delete" value="{{ $item['temp_id'] }}" type="button"
                    class="btn btn-danger btn-xs btn-block">{{ $item['temp_id'] }}</button>
                @else
                <a id="delete" value="{{ $item->sales_order_detail_item_product_id }}"
                    href="{{ route(config('module').'_delete', ['code' => $item->sales_order_detail_id, 'detail' => $item->sales_order_detail_item_product_id ]) }}"
                    class="btn btn-danger btn-xs btn-block delete-{{ $item->sales_order_detail_item_product_id }}">
                    {{ $item->sales_order_detail_item_product_id }}
                </a>
                @endif
                <input type="hidden" value="{{ $item['temp_id'] ?? $item->sales_order_detail_item_product_id }}"
                    name="temp_id[]">
                <input type="hidden" value="{{ $item['temp_id'] ?? $item->sales_order_detail_item_product_id }}"
                    name="detail[{{ $loop->index }}][temp_id]">
            </td>
            <td data-title="Product">
                <input type="text" readonly class="form-control input-sm"
                    value="{{ $item['temp_product'] ?? $item->product->item_product_name }}"
                    name="detail[{{ $loop->index }}][temp_product]">

                <textarea rows="2" placeholder="notes" tabindex="{{ $loop->iteration }}5"
                    class="form-control temp_notes"
                    name="detail[{{ $loop->index }}][temp_notes]">{{ $item['temp_notes'] ?? $item->sales_order_detail_notes }}</textarea>
                <br>
                @if($item->variant()->get()->count() > 0)
                @foreach($item->variant()->get() as $variant)
                <div class="col-md-6 mt-sm">
                    <p class="text-right">
                        {{ $variant->variant->item_variant_name }}
                    </p>
                    <input type="hidden" value="{{ $variant->sales_order_detail_variant_order_id }}"
                        name="detail[{{$loop->parent->index}}][variant][{{ $loop->index }}][sales_order_detail_variant_order_id]">
                    
                    <input type="hidden" value="{{ $variant->sales_order_detail_variant_item_product_id }}"
                        name="detail[{{$loop->parent->index}}][variant][{{ $loop->index }}][sales_order_detail_variant_item_product_id]">
                    
                    <input type="hidden" value="{{ $variant->sales_order_detail_variant_item_variant_id }}"
                        name="detail[{{$loop->parent->index}}][variant][{{ $loop->index }}][sales_order_detail_variant_item_variant_id]">
                    
                    <input type="number" value="{{ $variant->sales_order_detail_variant_qty }}" placeholder="INPUT QTY"
                        name="detail[{{$loop->parent->index}}][variant][{{ $loop->index }}][sales_order_detail_variant_qty]"
                        class="form-control input-sm">
                    
                    <input type="hidden" value="{{ $variant->sales_order_detail_variant_order_detail_id }}"
                        name="detail[{{$loop->parent->index}}][variant][{{ $loop->index }}][sales_order_detail_variant_order_detail_id]">
                    
                </div>
                @endforeach
                @endif
            </td>
            <td data-title="Qty" class="text-right col-lg-1">
                <input type="text" tabindex="{{ $loop->iteration }}1" name="detail[{{ $loop->index }}][temp_qty]"
                    class="form-control input-sm text-right number temp_qty"
                    value="{{ $item['temp_qty'] ?? $item->sales_order_detail_qty }}">
            </td>
            <td data-title="Price" class="text-right col-lg-1">
                <input type="text" tabindex="{{ $loop->iteration }}2" name="detail[{{ $loop->index }}][temp_price]"
                    class="form-control input-sm text-right money temp_price"
                    value="{{ $item['temp_price'] ?? $item->sales_order_detail_price }}">
            </td>
            <td data-title="Total" class="text-right col-lg-1">
                <input type="text" readonly name="detail[{{ $loop->index }}][temp_total]"
                    class="form-control input-sm text-right number temp_total"
                    value="{{ $item['temp_total'] ?? $item->sales_order_detail_total }}">
            </td>
        </tr>
        @endforeach
        @endisset
    </tbody>

    <tbody>
        <tr>
            <td data-title="Sebelum Discount" colspan="4" class="text-right">
                <strong>Total Sebelum Discount</strong>
            </td>
            <td data-title="" class="text-right">
                {!! Form::text('sales_order_sum_product', null, ['id' => 'before_discount',
                'readonly', 'class' => 'number form-control text-right']) !!}
            </td>
        </tr>
        <tr style="margin-bottom: 20px;">
            <td data-title="" class="text-left col-md-1 hide-xs">
                <button value="Discount" type="button" class="btn btn-xs btn-success btn-block">Discount</button>
            </td>
            <td data-title="Description" class="text-left col-md-4">
                {!! Form::textarea('sales_order_discount_name', null, ['id' => 'grand_discount_description', 'class' =>
                'form-control', 'rows' => 1, 'tabindex' => 500]) !!}
            </td>
            <td data-title="Value" class="text-right col-md-1">
                {!! Form::text('sales_order_discount_value', null, ['id' => 'grand_discount_value', 'placeholder' =>
                '- Value' ,'class' => 'number form-control text-right', 'tabindex' => 501]) !!}
            </td>
            <td data-title="Price" class="text-right col-md-1">
                {!! Form::text('sales_order_discount_value', null, ['id' => 'grand_discount_price',
                'readonly', 'class' => 'number form-control text-right', 'tabindex' => 502]) !!}
            </td>
            <td data-title="Total" class="text-right col-md-1">
                {!! Form::text('sales_order_sum_discount', null, ['id' => 'grand_discount_total',
                'readonly', 'class' => 'number form-control text-right']) !!}
            </td>
        </tr>
        <tr>
            <td data-title="ONGKIR" colspan="4" class="text-right">
                <strong>Ongkir</strong>
            </td>
            <td data-title="" class="text-right">
                {!! Form::text('sales_order_sum_ongkir', null, ['id' => 'ongkirs',
                'class' => 'number form-control text-right']) !!}
            </td>
        </tr>
        <tr>
            <td data-title="GRAND TOTAL" colspan="4" class="text-right">
                <strong>Total Setelah Discount</strong>
            </td>
            <td data-title="" class="text-right">
                {!! Form::text('sales_order_sum_total', null, ['id' => 'grand_total',
                'readonly', 'class' => 'number form-control text-right']) !!}
            </td>
        </tr>
    </tbody>
</table>