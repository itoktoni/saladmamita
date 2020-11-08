<x-area :selector="['from_area', 'to_area']"/>
<x-date :array="['date']"/>
<x-mask :array="['number', 'money']"/>
<x-editor/>

<div class="form-group">

    {!! Form::hidden('sales_delivery_sales_order_id', $model->sales_delivery_sales_order_id) !!}

    {!! Form::label('name', 'Delivery From', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_delivery_from_name') ? 'has-error' : ''}}">
        {!! Form::text('sales_delivery_from_name', $model->company->company_delivery_name ?? '', ['class' =>
        'form-control']) !!}
        {!! Form::hidden('sales_delivery_from_id', $model->sales_order_from_id) !!}
        {!! $errors->first('sales_delivery_from_name', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_delivery_from_person') ? 'has-error' : ''}}">
        {!! Form::text('sales_delivery_from_person', $model->company->company_delivery_person ?? '', ['class' =>
        'form-control', 'id' => 'from_name']) !!}
        {!! $errors->first('sales_delivery_from_person', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">
    {!! Form::label('name', 'Phone', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_delivery_from_phone') ? 'has-error' : ''}}">
        {!! Form::text('sales_delivery_from_phone', $model->company->company_delivery_phone ?? '', ['class' =>
        'form-control', 'id' => 'from_phone']) !!}
        {!! $errors->first('sales_delivery_from_phone', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Email', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_delivery_from_email') ? 'has-error' : ''}}">
        {!! Form::text('sales_delivery_from_email', $model->company->company_delivery_email ?? '', ['class' =>
        'form-control', 'id' => 'from_email']) !!}
        {!! $errors->first('sales_delivery_from_email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Area', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('sales_delivery_from_area') ? 'has-error' : ''}}">
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-primary from_area" type="button">Select</button>
                <input type="hidden" name="from_area" value="{{ old('from_area') ?? '' }}">
            </span>
            {{ Form::select('sales_delivery_from_area', old('from_area') ? [old('sales_delivery_from_area') => old('from_area')] : $from, null, ['class'=> 'form-control select', 'id' => 'from_area']) }}
            {!! $errors->first('sales_delivery_from_area', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Alamat Lengkap', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('sales_delivery_from_address') ? 'has-error' : ''}}">
        {!! Form::textarea('sales_delivery_from_address', $model->company->company_delivery_address ?? '', ['class' =>
        'form-control', 'rows' => 3, 'id' =>
        'from_address']) !!}
        {!! $errors->first('sales_delivery_from_address', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<hr>

<div class="form-group">

    {!! Form::label('name', 'Customer', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_delivery_to_name') ? 'has-error' : ''}}">
        {!! Form::text('sales_delivery_to_name', $model->customer->crm_customer_delivery_name ?? '', ['class' =>
        'form-control']) !!}
        {!! $errors->first('sales_delivery_to_name', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Nama', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_delivery_to_person') ? 'has-error' : ''}}">
        {!! Form::text('sales_delivery_to_person', $model->customer->crm_customer_delivery_person ?? '', ['class' =>
        'form-control']) !!}
        {!! $errors->first('sales_delivery_to_person', '<p class="help-block">:message</p>') !!}
    </div>
    {!! Form::hidden('sales_delivery_to_id', $model->sales_order_to_id) !!}
</div>

<div class="form-group">
    {!! Form::label('name', 'Phone', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_delivery_to_phone') ? 'has-error' : ''}}">
        {!! Form::text('sales_delivery_to_phone', $model->customer->crm_customer_delivery_phone ?? '', ['class' =>
        'form-control', 'id' => 'to_phone']) !!}
        {!! $errors->first('sales_delivery_to_phone', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Email', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_delivery_to_email') ? 'has-error' : ''}}">
        {!! Form::text('sales_delivery_to_email', $model->customer->crm_customer_delivery_email ?? '', ['class' =>
        'form-control', 'id' => 'to_email']) !!}
        {!! $errors->first('sales_delivery_to_email', '<p class="help-block">:message</p>') !!}
    </div>

</div>
<div class="form-group">
    {!! Form::label('name', 'Area', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('sales_delivery_to_area') ? 'has-error' : ''}}">
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-primary to_area" type="button">Select</button>
                <input type="hidden" name="to_area" value="{{ old('to_area') ?? '' }}">
            </span>
            {{ Form::select('sales_delivery_to_area', old('to_area') ? [old('sales_delivery_to_area') => old('to_area')] : $to, null, ['class'=> 'form-control select', 'id' => 'to_area']) }}
            {!! $errors->first('sales_delivery_to_area', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'Alamat Lengkap', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('sales_delivery_to_address') ? 'has-error' : ''}}">
        {!! Form::textarea('sales_delivery_to_address', $model->customer->crm_customer_delivery_address ?? '', ['class' =>
        'form-control', 'rows' => 3, 'id' =>
        'to_address']) !!}
        {!! $errors->first('sales_delivery_to_address', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<hr>


<div class="form-group">
    {!! Form::label('name', 'Status', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_delivery_status') ? 'has-error' : ''}}">
        {{ Form::select('sales_delivery_status', $status, null, ['class'=> 'form-control', 'id' => 'promo_id']) }}
        {!! $errors->first('sales_delivery_status', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Date', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_delivery_date_order') ? 'has-error' : ''}}">
        {!! Form::text('sales_delivery_date_order', $model->sales_delivery_date_order ?? date('Y-m-d'), ['class' =>
        'form-control date']) !!}
        {!! $errors->first('sales_delivery_date_order', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Catatan Internal', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('sales_delivery_notes_internal') ? 'has-error' : ''}}">
        {!! Form::textarea('sales_delivery_notes_internal', null, ['class' => 'form-control', 'rows' => 2]) !!}
        {!! $errors->first('sales_delivery_notes_internal', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Catatan Pengiriman', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('sales_delivery_notes_external') ? 'has-error' : ''}}">
        {!! Form::textarea('sales_delivery_notes_external', null, ['class' => 'form-control editor', 'rows' => 2]) !!}
        {!! $errors->first('sales_delivery_notes_external', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<hr>

@include($folder.'::page.'.$template.'.table')