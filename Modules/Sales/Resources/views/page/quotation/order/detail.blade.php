<div id="detail" class="panel-body">
    <div class="panel panel-default">
        <div class="row">
            <div class="col-md-6">
                @if ($model->$key && !old('temp_id'))
                <h2 id="total" class="panel-title text-left">
                    <span id="total_name">Total</span>
                    <span class="money" id="total_value">
                        {{ number_format($model->sales_quotation_sum_total) }}
                    </span>
                    <input type="hidden" id="hidden_total" value="{{ $model->sales_quotation_sum_total }}" name="total">
                </h2>
                @else
                <h2 id="total" class="panel-title text-left">
                    <span id="total_name">{{ old('total') ? 'Total' : '' }}</span>
                    <span class="money" id="total_value">{{ old('total') ? number_format(old('total')) : '' }}</span>
                    <input type="hidden" id="hidden_total" value="{{ old('total') ? old('total') : 0 }}" name="total">
                </h2>
                @endif
            </div>
            <div class="col-md-6">
                <h2 class="panel-title text-right">
                    <span id="add" class="btn btn-primary detail">Add Detail</span>
                </h2>
            </div>
        </div>
        <div class="panel-body line">
            <div class="">
                <div class="form-group {{ $errors->has('detail') ? 'has-error' : ''}}">
                    <label class="col-md-1 control-label" for="inputDefault">Product</label>
                    <div class="col-md-5 {{ $errors->has('product') ? 'has-error' : ''}}">
                        {{ Form::select('', $product, null, ['class'=> 'form-control', 'id' => 'product']) }}
                    </div>

                    <label class="col-md-1 control-label" for="inputDefault">Qty</label>
                    <div class="col-md-2">
                        {!! Form::text('', null, ['id' => 'qty', 'class' => 'number form-control']) !!}
                    </div>

                    <label class="col-md-1 control-label" for="inputDefault">Price</label>
                    <div class="col-md-2">
                        {!! Form::text('', null, ['id' => 'price', 'class' => 'money form-control']) !!}
                    </div>

                    <hr>

                    <label class="col-md-1 control-label" for="inputDefault">Discount</label>
                    <div class="col-md-2">
                        {!! Form::text('', null, ['id' => 'disc', 'placeholder' => 'Hitungan Dlm %' , 'class' => 'number
                        form-control']) !!}
                    </div>

                    <label class="col-md-1 control-label" for="inputDefault">Notes</label>
                    <div class="col-md-5">
                        {!! Form::textarea('', null, ['id' => 'desc', 'class' => 'form-control', 'rows' => 1]) !!}
                    </div>
                    <label class="col-md-1 control-label" for="inputDefault">Total</label>
                    <div class="col-md-2">
                        {!! Form::text('', null, ['id' => 'sub_total', 'readonly', 'class' => 'number form-control'])
                        !!}
                    </div>

                </div>

                <div class="form-group">

                    <label class="col-md-1 control-label" for="inputDefault">Notes</label>
                    <div class="col-md-11">
                        {!! Form::textarea('', null, ['id' => 'notes', 'rows' => 4, 'class' => 'form-control']) !!}
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@include($folder.'::page.'.$template.'.order.table')