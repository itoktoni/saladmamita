<x-date :array="['date']" />

<div class="form-group">

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'name') ? 'has-error' : ''}}">
        {!! Form::text($form.'name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'name', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Tanggal', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'date') ? 'has-error' : ''}}">
        {!! Form::text($form.'date', null, ['class' => 'form-control date']) !!}
        {!! $errors->first($form.'date', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has($form.'description') ? 'has-error' : ''}}">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'description', '<p class="help-block">:message</p>') !!}
    </div>

</div>
