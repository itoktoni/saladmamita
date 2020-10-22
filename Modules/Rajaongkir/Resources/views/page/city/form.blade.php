<div class="form-group">

    {!! Form::label('name', 'Type', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'type') ? 'has-error' : ''}}">
        {{ Form::select($form.'type', ['Kabupaten' => 'Kabupaten', 'Kota' => 'Kota'], null, ['class'=> 'form-control']) }}
        {!! $errors->first($form.'type', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Postcode', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'postal_code') ? 'has-error' : ''}}">
        {!! Form::text($form.'postal_code', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'postal_code', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Province', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'province_id') ? 'has-error' : ''}}">
        {{ Form::select($form.'province_id', $provinces, null, ['class'=> 'form-control']) }}
        {!! $errors->first($form.'province_id', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'name') ? 'has-error' : ''}}">
        {!! Form::text($form.'name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'name', '<p class="help-block">:message</p>') !!}
    </div>

</div>