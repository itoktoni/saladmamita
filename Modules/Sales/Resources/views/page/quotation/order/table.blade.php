<table id="transaction" class="table table-no-more table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-left col-md-1">ID</th>
            <th class="text-left col-md-4">Product Name and Description</th>
            <th class="text-right col-md-1">Qty / Disc</th>
            <th class="text-right col-md-2">Price</th>
            <th class="text-right col-md-2">Total</th>
        </tr>
    </thead>
    <tbody class="markup">
        @if(!empty($detail) || old('detail'))
        @foreach (old('detail') ?? $detail as $item)
        <tr>
            <td data-title="ID Product">
                @if(old('detail'))
                <button id="delete" value="{{ $item['temp_id'] }}" type="button" class="btn btn-danger btn-xs btn-block">{{ $item['temp_id'] }}</button>
                @else
                <a id="delete" value="{{ $item->sales_quotation_detail_item_product_id }}"
                    href="{{ route(config('module').'_delete', ['code' => $item->sales_quotation_detail_id, 'detail' => $item->sales_quotation_detail_item_product_id ]) }}"
                    class="btn btn-danger btn-xs btn-block delete-{{ $item->sales_quotation_detail_item_product_id }}">
                    {{ $item->sales_quotation_detail_item_product_id }}
                </a>
                @endif
                <input type="hidden" value="{{ $item['temp_id'] ?? $item->sales_quotation_detail_item_product_id }}" name="temp_id[]">
                <input type="hidden" value="{{ $item['temp_id'] ?? $item->sales_quotation_detail_item_product_id }}"
                    name="detail[{{ $loop->index }}][temp_id]">
            </td>
            <td data-title="Product">
                <input type="text" readonly class="form-control input-sm"
                    value="{{ $item['temp_product'] ?? $item->product->item_product_name }}" name="detail[{{ $loop->index }}][temp_product]">

                <div class="input-group input-group-sm">
                    <input type="text" tabindex="{{ $loop->iteration }}3" name="detail[{{ $loop->index }}][temp_desc]" value="{{ $item['temp_desc'] ?? $item->sales_quotation_detail_discount_name }}" class="form-control">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">disc</button>
                    </span>
                </div>

                <textarea placeholder="notes" rows="4" tabindex="{{ $loop->iteration }}5" class="form-control temp_notes simple" name="detail[{{ $loop->index }}][temp_notes]">{{ $item['temp_notes'] ?? $item->sales_quotation_detail_item_product_description }}</textarea>
            </td>
            <td data-title="Qty" class="text-right col-lg-1">
                <input type="text" tabindex="{{ $loop->iteration }}1" name="detail[{{ $loop->index }}][temp_qty]"
                    class="form-control input-sm text-right number temp_qty"
                    value="{{ $item['temp_qty'] ?? $item->sales_quotation_detail_qty }}">

                <input type="text" tabindex="{{ $loop->iteration }}4" name="detail[{{ $loop->index }}][temp_disc]" class="form-control input-sm text-right number temp_disc"
                    value="{{ $item['temp_disc'] ?? $item->sales_quotation_detail_discount_percent }}">
            </td>
            <td data-title="Price" class="text-right col-lg-1">
                <input type="text" tabindex="{{ $loop->iteration }}2"  name="detail[{{ $loop->index }}][temp_price]"
                    class="form-control input-sm text-right number temp_price"
                    value="{{ $item['temp_price'] ?? $item->sales_quotation_detail_price }}">

                <input type="text" name="detail[{{ $loop->index }}][temp_potongan]"
                    class="form-control input-sm text-right number temp_potongan"
                    value="{{ $item['temp_potongan'] ?? $item->sales_quotation_detail_discount_value }}">
            </td>
            <td data-title="Total" class="text-right col-lg-1">
                <input type="text" readonly name="detail[{{ $loop->index }}][temp_total]"
                    class="form-control input-sm text-right number temp_total"
                    value="{{ $item['temp_total'] ?? $item->sales_quotation_detail_total }}">
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
                {!! Form::text('sales_order_sum_product', $model->sales_quotation_sum_product, ['id' => 'before_discount',
                'readonly', 'class' => 'number form-control text-right']) !!}
            </td>
        </tr>
        <tr style="margin-bottom: 20px;">
            <td data-title="" class="text-left col-md-1 hide-xs">
                <button value="Discount" type="button" class="btn btn-xs btn-success btn-block">Discount</button>
            </td>
            <td data-title="Description" class="text-left col-md-4">
                {!! Form::textarea('sales_order_discount_name', $model->sales_quotation_discount_name, ['id' => 'grand_discount_description', 'class' =>
                'form-control', 'rows' => 2, 'tabindex' => 500]) !!}
            </td>
            <td data-title="Value" class="text-right col-md-1">
                {!! Form::text('sales_order_discount_percent', $model->sales_quotation_discount_percent, ['id' => 'grand_discount_value', 'placeholder' =>
                'Dalam %' ,'class' => 'number form-control text-right', 'tabindex' => 501]) !!}
            </td>
            <td data-title="Price" class="text-right col-md-1">
                {!! Form::text('sales_order_discount_value', $model->sales_quotation_discount_value, ['id' => 'grand_discount_price',
                'readonly', 'class' => 'number form-control text-right', 'tabindex' => 502]) !!}
            </td>
            <td data-title="Total" class="text-right col-md-1">
                {!! Form::text('sales_order_sum_discount', $model->sales_quotation_sum_discount, ['id' => 'grand_discount_total',
                'readonly', 'class' => 'number form-control text-right']) !!}
            </td>
        </tr>
        <tr style="margin-bottom: 20px;">
            <td data-title="" class="text-left col-md-1 hide-xs">
                <button value="Tax" type="button" class="btn btn-xs btn-primary btn-block">Tax</button>
            </td>
            <td data-title="Description" class="text-left col-md-4">
                {{ Form::select('sales_order_tax_id', $tax, $model->sales_quotation_tax_id, ['class'=> 'form-control', 'id' => 'grand_tax_id', 'tabindex' => 503]) }}
            </td>
            <td data-title="Value" class="text-right col-md-1">
                {!! Form::text('sales_order_tax_percent', $model->sales_quotation_tax_percent, ['id' => 'grand_tax_value', 'placeholder' => 'Dalam %'
                ,'class' => 'number form-control text-right', 'tabindex' => 504]) !!}
            </td>
            <td data-title="Price" class="text-right col-md-1">
                {!! Form::text('sales_order_tax_value', $model->sales_quotation_tax_value, ['id' => 'grand_tax_price',
                'readonly', 'class' => 'number form-control text-right']) !!}
            </td>
            <td data-title="Total" class="text-right col-md-1">
                {!! Form::text('sales_order_sum_tax', $model->sales_quotation_sum_tax, ['id' => 'grand_tax_total',
                'readonly', 'class' => 'number form-control text-right']) !!}
            </td>
        </tr>
        <tr>
            <td data-title="GRAND TOTAL" colspan="4" class="text-right">
                <strong>Total Setelah Discount + Tax</strong>
            </td>
            <td data-title="" class="text-right">
                {!! Form::text('sales_order_sum_total', $model->sales_quotation_sum_total, ['id' => 'grand_total',
                'readonly', 'class' => 'number form-control text-right']) !!}
            </td>
        </tr>
    </tbody>
</table>