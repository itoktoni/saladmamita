
<div class="form-group">
    {!! Form::label('name', 'Product Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'name') ? 'has-error' : ''}}">
        {!! Form::text($form.'name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'name', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Slug', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'slug') ? 'has-error' : ''}}">
        {!! Form::text($form.'slug', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'slug', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'SKU', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'sku') ? 'has-error' : ''}}">
        {!! Form::text($form.'sku', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'sku', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Group Product', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'group') ? 'has-error' : ''}}">
        {{ Form::select($form.'group', $product, null, ['class'=> 'form-control ']) }}
        {!! $errors->first($form.'group', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group">

    {!! Form::label('name', 'Category', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'item_category_id') ? 'has-error' : ''}}">
        {{ Form::select($form.'item_category_id', $category, null, ['class'=> 'form-control ', 'data-plugin-selectTwo']) }}
        {!! $errors->first($form.'item_category_id', '<p class="help-block">:message</p>') !!}
    </div>


    {!! Form::label('name', 'Main Image', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'image') ? 'has-error' : ''}}">
        <input type="file" name="{{ $form.'file' }}"
            class="{{ $errors->has($form.'file') ? 'has-error' : ''}} btn btn-default btn-sm btn-block">
        {!! $errors->first($form.'image', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Tag', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has($form.'item_tag_json') ? 'has-error' : ''}}">
        {{ Form::select($form.'item_tag_json[]', $tag, json_decode($form.'item_tag_json'), ['class'=> 'form-control ', 'multiple']) }}
        {!! $errors->first($form.'item_tag_json', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'Active', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'status') ? 'has-error' : ''}}">
        {{ Form::select($form.'status', ['1' => 'Yes', '0' => 'No'], null, ['class'=> 'form-control ']) }}
        {!! $errors->first($form.'status', '<p class="help-block">:message</p>') !!}
    </div>
    {!! Form::label('name', 'Display Frontpage', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'display') ? 'has-error' : ''}}">
        {{ Form::select($form.'display', ['1' => 'Yes', '0' => 'No'], null, ['class'=> 'form-control']) }}
        {!! $errors->first($form.'display', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group">

    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-{{ isset($model->item_product_image) && !empty($model->item_product_image) ? '8' : '10' }}">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control editor', 'id' => '', 'rows' => '5']) !!}
    </div>

    <div class="col-md-2">
        @isset ($model->item_product_image)
        <img width="100%" class="img-thumbnail"
            src="{{ Helper::files($template.'/thumbnail_'.$model->item_product_image) }}" alt="">
        @endisset
    </div>
</div>

<hr>
<div class="form-group">
    {!! Form::label('name', 'Buying Price', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'buy') ? 'has-error' : ''}}">
        {!! Form::number($form.'buy', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'buy', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Selling Price', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'sell') ? 'has-error' : ''}}">
        {!! Form::number($form.'sell', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'sell', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Minimal', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'min') ? 'has-error' : ''}}">
        {!! Form::number($form.'min', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'min', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Maximal', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'max') ? 'has-error' : ''}}">
        {!! Form::number($form.'max', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'max', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'Brand', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'item_brand_id') ? 'has-error' : ''}}">
        {{ Form::select($form.'item_brand_id', $brand, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
        {!! $errors->first($form.'item_brand_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'Calculate Stock', ['class' => 'col-md-2 control-label']) !!}
     <div class="col-md-4 {{ $errors->has($form.'stock') ? 'has-error' : ''}}">
        {{ Form::select($form.'stock', ['1' => 'Yes', '0' => 'No'], null, ['class'=> 'form-control']) }}
        {!! $errors->first($form.'stock', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Weight / Gram', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'gram') ? 'has-error' : ''}}">
        {!! Form::number($form.'gram', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'gram', '<p class="help-block">:message</p>') !!}
    </div>

</div>
