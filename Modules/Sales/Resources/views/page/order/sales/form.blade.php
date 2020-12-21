<!-- <div class="form-group">

    {!! Form::label('name', 'Quotation', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_order_code_quotation') ? 'has-error' : ''}}">
        {!! Form::text('sales_order_code_quotation', null, ['class' => 'form-control']) !!}
        {!! $errors->first('sales_order_code_quotation', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Purchase Order (PO)', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_order_code_po') ? 'has-error' : ''}}">
        {!! Form::text('sales_order_code_po', null, ['class' => 'form-control']) !!}
        {!! $errors->first('sales_order_code_po', '<p class="help-block">:message</p>') !!}
    </div>

</div>
<hr>
-->

<div class="form-group">

    {!! Form::label('name', 'Customer', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_order_to_id') ? 'has-error' : ''}}">
        {{ Form::select('sales_order_to_id', $customers, null, ['class'=> 'form-control', 'id' => 'to_id']) }}
        {!! $errors->first('sales_order_to_id', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_order_to_name') ? 'has-error' : ''}}">
        {!! Form::text('sales_order_to_name', null, ['class' => 'form-control', 'id' => 'to_name']) !!}
        {!! $errors->first('sales_order_to_name', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">
    {!! Form::label('name', 'Phone', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_order_to_phone') ? 'has-error' : ''}}">
        {!! Form::text('sales_order_to_phone', null, ['class' => 'form-control', 'id' => 'to_phone']) !!}
        {!! $errors->first('sales_order_to_phone', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Email', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_order_to_email') ? 'has-error' : ''}}">
        {!! Form::text('sales_order_to_email', null, ['class' => 'form-control', 'id' => 'to_email']) !!}
        {!! $errors->first('sales_order_to_email', '<p class="help-block">:message</p>') !!}
    </div>

</div>
<div class="form-group">
    {!! Form::label('name', 'Area', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('sales_order_to_area') ? 'has-error' : ''}}">
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-primary to_area" type="button">Select</button>
                <input type="hidden" name="to_area" value="{{ old('to_area') ?? '' }}">
            </span>
            {{ Form::select('sales_order_to_area', old('to_area') ? [old('sales_order_to_area') => old('to_area')] : $to, null, ['class'=> 'form-control select', 'id' => 'to_area']) }}
            {!! $errors->first('sales_order_to_area', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'Alamat Lengkap', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('sales_order_to_address') ? 'has-error' : ''}}">
        {!! Form::textarea('sales_order_to_address', null, ['class' => 'form-control', 'rows' => 3, 'id' =>
        'to_address']) !!}
        {!! $errors->first('sales_order_to_address', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<hr>

<div class="form-group">

    {!! Form::label('name', 'Location Pickup', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_order_from_id') ? 'has-error' : ''}}">
        {{ Form::select('sales_order_from_id', $branch, null, ['class'=> 'form-control', 'id' => 'from_id']) }}
        {!! $errors->first('sales_order_from_id', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_order_from_name') ? 'has-error' : ''}}">
        {!! Form::text('sales_order_from_name', null, ['class' => 'form-control', 'id' => 'from_name']) !!}
        {!! $errors->first('sales_order_from_name', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">
    {!! Form::label('name', 'Phone', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_order_from_phone') ? 'has-error' : ''}}">
        {!! Form::text('sales_order_from_phone', null, ['class' => 'form-control', 'id' => 'from_phone']) !!}
        {!! $errors->first('sales_order_from_phone', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Email', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_order_from_email') ? 'has-error' : ''}}">
        {!! Form::text('sales_order_from_email', null, ['class' => 'form-control', 'id' => 'from_email']) !!}
        {!! $errors->first('sales_order_from_email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Area', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('sales_order_from_area') ? 'has-error' : ''}}">
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-primary from_area" type="button">Select</button>
                <input type="hidden" name="from_area" value="{{ old('from_area') ?? '' }}">
            </span>
            {{ Form::select('sales_order_from_area', old('from_area') ? [old('sales_order_from_area') => old('from_area')] : $from, null, ['class'=> 'form-control select', 'id' => 'from_area']) }}
            {!! $errors->first('sales_order_from_area', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Alamat Lengkap', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('sales_order_from_address') ? 'has-error' : ''}}">
        {!! Form::textarea('sales_order_from_address', null, ['class' => 'form-control', 'rows' => 3, 'id' =>
        'from_address']) !!}
        {!! $errors->first('sales_order_from_address', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<hr>

<div class="form-group">
    {!! Form::label('name', 'Status', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_order_status') ? 'has-error' : ''}}">
        {{ Form::select('sales_order_status', $status, null, ['class'=> 'form-control', 'id' => 'promo_id']) }}
        {!! $errors->first('sales_order_status', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Delivery Date', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_order_date_order') ? 'has-error' : ''}}">
        {!! Form::text('sales_order_date_order', $model->sales_order_date_order ?? date('Y-m-d'), ['class' =>
        'form-control date']) !!}
        {!! $errors->first('sales_order_date_order', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'Catatan Internal', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_order_notes_internal') ? 'has-error' : ''}}">
        {!! Form::textarea('sales_order_notes_internal', null, ['class' => 'form-control', 'rows' => 3]) !!}
        {!! $errors->first('sales_order_notes_internal', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Catatan Customer', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_order_notes_external') ? 'has-error' : ''}}">
        {!! Form::textarea('sales_order_notes_external', null, ['class' => 'form-control', 'rows' => 3]) !!}
        {!! $errors->first('sales_order_notes_external', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<hr>

<div class="form-group">
    {!! Form::label('name', 'Tanggal Pembayaran', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_order_payment_date') ? 'has-error' : ''}}">
        <div class="input-group">
            {!! Form::text('sales_order_payment_date', null, ['class'=>'form-control date']) !!}
            <span class="input-group-btn">
                <a class="btn btn-danger" target="_blank" download=""
                    href="{{ Helper::files('public/'.$model->sales_order_payment_file) }}">Download</a>
            </span>
            {!! $errors->first('sales_order_payment_date', '<p class="help-block">:message</p>') !!}
        </div>
        {!! $errors->first('sales_order_payment_date', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Nama Pengirim', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_order_payment_person') ? 'has-error' : ''}}">
        {!! Form::text('sales_order_payment_person', null, ['class' =>
        'form-control']) !!}
        {!! $errors->first('sales_order_payment_person', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'Catatan Pembayaran', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_order_payment_notes') ? 'has-error' : ''}}">
        {!! Form::textarea('sales_order_payment_notes', null, ['class' => 'form-control', 'rows' => 3]) !!}
        {!! $errors->first('sales_order_payment_notes', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Berlangganan', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_order_code_reference') ? 'has-error' : ''}}">
        <div class="input-group">
            {!! Form::text('sales_order_code_reference', null, ['class'=>'form-control', 'readonly']) !!}
            <span class="input-group-btn">
                <a class="btn btn-primary" target="_blank"
                    href="{{ $model->sales_order_code_reference ? route('sales_subscribe_update', ['code' => $model->sales_order_code_reference]) : '' }}">Link</a>
            </span>
            {!! $errors->first('sales_order_code_reference', '<p class="help-block">:message</p>') !!}
        </div>
        {!! $errors->first('sales_order_code_reference', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">
    {!! Form::label('name', 'Metode Pembayaran', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_order_term_top') ? 'has-error' : ''}}">
        {{ Form::select('sales_order_term_top', $tops, null, ['class'=> 'form-control']) }}
        {!! $errors->first('sales_order_term_top', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Masuk Rekening', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_order_payment_bank_to_id') ? 'has-error' : ''}}">
        {{ Form::select('sales_order_payment_bank_to_id', $bank, null, ['class'=> 'form-control']) }}
        {!! $errors->first('sales_order_payment_bank_to_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Metode Delivery', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_order_delivery_type') ? 'has-error' : ''}}">
        {{ Form::select('sales_order_delivery_type', $delivery, null, ['class'=> 'form-control']) }}
        {!! $errors->first('sales_order_delivery_type', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Description Ongkir', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_order_delivery_name') ? 'has-error' : ''}}">
        {!! Form::text('sales_order_delivery_name', null, ['class' => 'form-control']) !!}
        {!! $errors->first('sales_order_delivery_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<hr>

@include($folder.'::page.'.$template.'.sales.detail')
@include($folder.'::page.'.$template.'.sales.script')