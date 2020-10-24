<div class="form-group">

    {!! Form::label('name', 'Company', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_quotation_from_id') ? 'has-error' : ''}}">
        {{ Form::select('sales_quotation_from_id', $company, null, ['class'=> 'form-control', 'id' => 'from_id']) }}
        {!! $errors->first('sales_quotation_from_id', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_quotation_from_name') ? 'has-error' : ''}}">
        {!! Form::text('sales_quotation_from_name', null, ['class' => 'form-control', 'id' => 'from_name']) !!}
        {!! $errors->first('sales_quotation_from_name', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">
    {!! Form::label('name', 'Phone', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_quotation_from_phone') ? 'has-error' : ''}}">
        {!! Form::text('sales_quotation_from_phone', null, ['class' => 'form-control', 'id' => 'from_phone']) !!}
        {!! $errors->first('sales_quotation_from_phone', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Email', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_quotation_from_email') ? 'has-error' : ''}}">
        {!! Form::text('sales_quotation_from_email', null, ['class' => 'form-control', 'id' => 'from_email']) !!}
        {!! $errors->first('sales_quotation_from_email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Area', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('sales_quotation_from_area') ? 'has-error' : ''}}">
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-primary from_area" type="button">Select</button>
                <input type="hidden" name="from_area" value="{{ old('from_area') ?? '' }}">
            </span>
            {{ Form::select('sales_quotation_from_area', old('from_area') ? [old('sales_quotation_from_area') => old('from_area')] : $from, null, ['class'=> 'form-control select', 'id' => 'from_area']) }}
            {!! $errors->first('sales_quotation_from_area', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Alamat Lengkap', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('sales_quotation_from_address') ? 'has-error' : ''}}">
        {!! Form::textarea('sales_quotation_from_address', null, ['class' => 'form-control', 'rows' => 3, 'id' =>
        'from_address']) !!}
        {!! $errors->first('sales_quotation_from_address', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<hr>

<div class="form-group">

    {!! Form::label('name', 'Customer', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_quotation_to_id') ? 'has-error' : ''}}">
        {{ Form::select('sales_quotation_to_id', $customers, null, ['class'=> 'form-control', 'id' => 'to_id']) }}
        {!! $errors->first('sales_quotation_to_id', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Nama', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_quotation_to_name') ? 'has-error' : ''}}">
        {!! Form::text('sales_quotation_to_name', null, ['class' => 'form-control', 'id' => 'to_name']) !!}
        {!! $errors->first('sales_quotation_to_name', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">
    {!! Form::label('name', 'Phone', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_quotation_to_phone') ? 'has-error' : ''}}">
        {!! Form::text('sales_quotation_to_phone', null, ['class' => 'form-control', 'id' => 'to_phone']) !!}
        {!! $errors->first('sales_quotation_to_phone', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Email', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_quotation_to_email') ? 'has-error' : ''}}">
        {!! Form::text('sales_quotation_to_email', null, ['class' => 'form-control', 'id' => 'to_email']) !!}
        {!! $errors->first('sales_quotation_to_email', '<p class="help-block">:message</p>') !!}
    </div>

</div>
<div class="form-group">
    {!! Form::label('name', 'Area', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('sales_quotation_to_area') ? 'has-error' : ''}}">
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-primary to_area" type="button">Select</button>
                <input type="hidden" name="to_area" value="{{ old('to_area') ?? '' }}">
            </span>
            {{ Form::select('sales_quotation_to_area', old('to_area') ? [old('sales_quotation_to_area') => old('to_area')] : $to, null, ['class'=> 'form-control select', 'id' => 'to_area']) }}
            {!! $errors->first('sales_quotation_to_area', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'Alamat Lengkap', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('sales_quotation_to_address') ? 'has-error' : ''}}">
        {!! Form::textarea('sales_quotation_to_address', null, ['class' => 'form-control', 'rows' => 3, 'id' =>
        'to_address']) !!}
        {!! $errors->first('sales_quotation_to_address', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<hr>


<div class="form-group">
    {!! Form::label('name', 'Status', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_quotation_status') ? 'has-error' : ''}}">
        {{ Form::select('sales_quotation_status', $status, null, ['class'=> 'form-control', 'id' => 'promo_id']) }}
        {!! $errors->first('sales_quotation_status', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Date', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_quotation_date') ? 'has-error' : ''}}">
        {!! Form::text('sales_quotation_date', $model->sales_quotation_date ?? date('Y-m-d'), ['class' =>
        'form-control date']) !!}
        {!! $errors->first('sales_quotation_date', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Catatan Internal', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('sales_quotation_notes_internal') ? 'has-error' : ''}}">
        {!! Form::textarea('sales_quotation_notes_internal', null, ['class' => 'form-control', 'rows' => 2]) !!}
        {!! $errors->first('sales_quotation_notes_internal', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Deskripsi Penarawan', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('sales_quotation_notes_external') ? 'has-error' : ''}}">
        {!! Form::textarea('sales_quotation_notes_external', null, ['class' => 'form-control editor', 'rows' => 2]) !!}
        {!! $errors->first('sales_quotation_notes_external', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<hr>

<div class="form-group">
    {!! Form::label('name', 'Metode Pembayaran', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_quotation_term_top') ? 'has-error' : ''}}">
        {{ Form::select('sales_quotation_term_top', $tops, null, ['class'=> 'form-control', 'id' => 'top_id']) }}
        {!! $errors->first('sales_quotation_term_top', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Berlaku Sampai', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_quotation_term_valid') ? 'has-error' : ''}}">
        <div class="input-group">
            {!! Form::text('sales_quotation_term_valid', null, ['class' => 'form-control', 'placeholder' => 'Masukan Hari'])
            !!}
            <span class="input-group-addon" id="basic-addon2">Hari</span>
        </div>
        {!! $errors->first('sales_quotation_term_valid', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Term and Condition', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('sales_quotation_term_product') ? 'has-error' : ''}}">
        {!! Form::textarea('sales_quotation_term_product', null, ['class' => 'form-control simple']) !!}
        {!! $errors->first('sales_quotation_term_product', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<hr>

@include($folder.'::page.'.$template.'.sales.detail')
@include($folder.'::page.'.$template.'.sales.script')