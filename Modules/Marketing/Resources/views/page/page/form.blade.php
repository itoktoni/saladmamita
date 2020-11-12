@component('components.editor', ['array' => ['basic']])

@endcomponent

<div class="form-group">

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'name') ? 'has-error' : ''}}">
        {!! Form::text($form.'name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'name', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Metode Delivery', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('marketing_page_status') ? 'has-error' : ''}}">
        {{ Form::select('marketing_page_status', [0 => 'Backend', 1 => 'Frontend'], null, ['class'=> 'form-control']) }}
        {!! $errors->first('marketing_page_status', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">
    {!! Form::label('name', 'Description Page', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control editor', 'rows' => '5']) !!}
    </div>
</div>