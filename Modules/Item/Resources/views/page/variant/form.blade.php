<x-mask :array="['number', 'money']" />
<div class="form-group">

    {!! Form::label('name', 'Category', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'item_category_id') ? 'has-error' : ''}}">
        {{ Form::select($form.'item_category_id', $category, null, ['class'=> 'form-control ', 'data-plugin-selectTwo']) }}
        {!! $errors->first($form.'item_category_id', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'name') ? 'has-error' : ''}}">
        {!! Form::text($form.'name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'name', '<p class="help-block">:message</p>') !!}
    </div>

</div>
<div class="form-group">

    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'description') ? 'has-error' : ''}}">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control', 'rows' => '3']) !!}
        {!! $errors->first($form.'description', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Main Image', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-3 {{ $errors->has($form.'image') ? 'has-error' : ''}}">
        <input type="file" name="{{ $form.'file' }}"
            class="{{ $errors->has($form.'file') ? 'has-error' : ''}} btn btn-default btn-sm btn-block">
        {!! $errors->first($form.'image', '<p class="help-block">:message</p>') !!}
    </div>
    @isset ($model->item_variant_image)
    <div class="col-md-1">
        <img width="100%" class="img-thumbnail"
            src="{{ Helper::files($template.'/thumbnail_'.$model->item_variant_image) }}" alt="">
    </div>
    @endisset

</div>
