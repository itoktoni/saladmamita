<x-area :selector="['area_contact']" />
<x-area :selector="['area_delivery']" />
<x-area :selector="['area_invoice']" />

<header class="panel-heading mb-sm">
    <h2 class="panel-title text-right">Contact Information</h2>
</header>

<div class="form-group">
    {!! Form::label('name', 'Customer Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('crm_customer_name') ? 'has-error' : ''}}">
        {!! Form::text('crm_customer_name', null, ['class' => 'form-control']) !!}
        {!! $errors->first('crm_customer_name', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Contact Person', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('crm_customer_contact_person') ? 'has-error' : ''}}">
        {!! Form::text('crm_customer_contact_person', null, ['class' => 'form-control']) !!}
        {!! $errors->first('crm_customer_contact_person', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('name', 'Contact Email', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('crm_customer_contact_email') ? 'has-error' : ''}}">
        {!! Form::text('crm_customer_contact_email', null, ['class' => 'form-control']) !!}
        {!! $errors->first('crm_customer_contact_email', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Contact Phone', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('crm_customer_contact_phone') ? 'has-error' : ''}}">
        {!! Form::text('crm_customer_contact_phone', null, ['class' => 'form-control']) !!}
        {!! $errors->first('crm_customer_contact_phone', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('name', 'Contact Address', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('crm_customer_contact_address') ? 'has-error' : ''}}">
        {!! Form::textarea('crm_customer_contact_address', null, ['class' => 'form-control', 'rows' => '3']) !!}
        {!! $errors->first('crm_customer_contact_address', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('crm_customer_contact_description') ? 'has-error' : ''}}">
        {!! Form::textarea('crm_customer_contact_description', null, ['class' => 'form-control', 'rows' => '3']) !!}
        {!! $errors->first('crm_customer_contact_description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'Contact Area', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('crm_customer_contact_rajaongkir_area_id') ? 'has-error' : ''}}">
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-primary area_contact" type="button">Contact</button>
                <input type="hidden" name="area_contact" value="{{ old('area_contact') ?? '' }}">
            </span>
            {{ Form::select('crm_customer_contact_rajaongkir_area_id', old('area_contact') ? [old('crm_customer_contact_rajaongkir_area_id') => old('area_contact')] : $area_contact, null, ['class'=> 'form-control select', 'id' => 'area_contact']) }}
            {!! $errors->first('crm_customer_contact_rajaongkir_area_id', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>


<header class="panel-heading mb-sm">
    <h2 class="panel-title text-right">Delivery Information</h2>
</header>
<hr>


<div class="form-group">
    {!! Form::label('name', 'Delivery Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('crm_customer_delivery_name') ? 'has-error' : ''}}">
        {!! Form::text('crm_customer_delivery_name', null, ['class' => 'form-control']) !!}
        {!! $errors->first('crm_customer_delivery_name', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Delivery Person', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('crm_customer_delivery_person') ? 'has-error' : ''}}">
        {!! Form::text('crm_customer_delivery_person', null, ['class' => 'form-control']) !!}
        {!! $errors->first('crm_customer_delivery_person', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('name', 'Delivery Email', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('crm_customer_delivery_email') ? 'has-error' : ''}}">
        {!! Form::text('crm_customer_delivery_email', null, ['class' => 'form-control']) !!}
        {!! $errors->first('crm_customer_delivery_email', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Delivery Phone', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('crm_customer_delivery_phone') ? 'has-error' : ''}}">
        {!! Form::text('crm_customer_delivery_phone', null, ['class' => 'form-control']) !!}
        {!! $errors->first('crm_customer_delivery_phone', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Delivery Address', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('crm_customer_delivery_address') ? 'has-error' : ''}}">
        {!! Form::textarea('crm_customer_delivery_address', null, ['class' => 'form-control', 'rows' => '3']) !!}
        {!! $errors->first('crm_customer_delivery_address', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('crm_customer_delivery_description') ? 'has-error' : ''}}">
        {!! Form::textarea('crm_customer_delivery_description', null, ['class' => 'form-control', 'rows' => '3']) !!}
        {!! $errors->first('crm_customer_delivery_description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'Delivery Area', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('crm_customer_delivery_rajaongkir_area_id') ? 'has-error' : ''}}">
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-primary area_delivery" type="button">Delivery</button>
                <input type="hidden" name="area_delivery" value="{{ old('area_delivery') ?? '' }}">
            </span>
            {{ Form::select('crm_customer_delivery_rajaongkir_area_id', old('area_delivery') ? [old('crm_customer_delivery_rajaongkir_area_id') => old('area_delivery')] : $area_delivery, null, ['class'=> 'form-control select', 'id' => 'area_delivery']) }}
            {!! $errors->first('crm_customer_delivery_rajaongkir_area_id', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>


<header class="panel-heading mb-sm">
    <h2 class="panel-title text-right">Invoice Information</h2>
</header>

<hr>

<div class="form-group">
    {!! Form::label('name', 'Invoice Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('crm_customer_invoice_name') ? 'has-error' : ''}}">
        {!! Form::text('crm_customer_invoice_name', null, ['class' => 'form-control']) !!}
        {!! $errors->first('crm_customer_invoice_name', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Invoice Person', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('crm_customer_invoice_person') ? 'has-error' : ''}}">
        {!! Form::text('crm_customer_invoice_person', null, ['class' => 'form-control']) !!}
        {!! $errors->first('crm_customer_invoice_person', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('name', 'Invoice Email', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('crm_customer_invoice_email') ? 'has-error' : ''}}">
        {!! Form::text('crm_customer_invoice_email', null, ['class' => 'form-control']) !!}
        {!! $errors->first('crm_customer_invoice_email', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Invoice Phone', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('crm_customer_invoice_phone') ? 'has-error' : ''}}">
        {!! Form::text('crm_customer_invoice_phone', null, ['class' => 'form-control']) !!}
        {!! $errors->first('crm_customer_invoice_phone', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Invoice Address', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('crm_customer_invoice_address') ? 'has-error' : ''}}">
        {!! Form::textarea('crm_customer_invoice_address', null, ['class' => 'form-control', 'rows' => '3']) !!}
        {!! $errors->first('crm_customer_invoice_address', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('crm_customer_invoice_description') ? 'has-error' : ''}}">
        {!! Form::textarea('crm_customer_invoice_description', null, ['class' => 'form-control', 'rows' => '3']) !!}
        {!! $errors->first('crm_customer_invoice_description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'Invoice Area', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('crm_customer_invoice_rajaongkir_area_id') ? 'has-error' : ''}}">
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-primary area_invoice" type="button">Invoice</button>
                <input type="hidden" name="area_invoice" value="{{ old('area_invoice') ?? '' }}">
            </span>
            {{ Form::select('crm_customer_invoice_rajaongkir_area_id', old('area_invoice') ? [old('crm_customer_invoice_rajaongkir_area_id') => old('area_invoice')] : $area_invoice, null, ['class'=> 'form-control select', 'id' => 'area_invoice']) }}
            {!! $errors->first('crm_customer_invoice_rajaongkir_area_id', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>