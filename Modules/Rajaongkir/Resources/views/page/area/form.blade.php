<div class="form-group">

    {!! Form::label('name', 'City', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has($form.'city_id') ? 'has-error' : ''}}">
        {{ Form::select($form.'city_id', $cities, null, ['class'=> 'form-control']) }}
        {!! $errors->first($form.'city_id', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'name') ? 'has-error' : ''}}">
        {!! Form::text($form.'name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'name', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Postcode', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'postcode') ? 'has-error' : ''}}">
        {!! Form::text($form.'postcode', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'postcode', '<p class="help-block">:message</p>') !!}
    </div>

</div>