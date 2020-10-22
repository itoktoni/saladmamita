@component('components.popup')
@endcomponent

<div class="form-group">

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('branch_name') ? 'has-error' : ''}}">
        {!! Form::text('branch_name', null, ['class' => 'form-control']) !!}
        {!! $errors->first('branch_name', '<p class="help-block">:message</p>') !!}
    </div>


    {!! Form::label('name', 'Company', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('company') ? 'has-error' : ''}}">
        {{ Form::select('branch_company_id', $company, null, ['class'=> 'form-control ']) }}
        {!! $errors->first('company', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('Area', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('branch_rajaongkir_area_id') ? 'has-error' : ''}}">
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-primary area" type="button">Select</button>
            </span>
            {{ Form::select('branch_rajaongkir_area_id', ['Please Select Area'], null, ['class'=> 'form-control select', 'id' => 'area']) }}
        </div>
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
        {!! Form::textarea('branch_description', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>

</div>

<div class="modal fade" id="ModalArea" role="dialog">
    <div class="modal-dialog">
        <div id="popup" class="modal-content">
        </div>
    </div>
</div>