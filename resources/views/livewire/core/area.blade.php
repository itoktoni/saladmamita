<div class="form-group">
   <label class="col-md-2 control-label">Branch</label>
    <div class="col-md-10 {{ $errors->has('branch_rajaongkir_area_id') ? 'has-error' : ''}}">
        <select name="branch_rajaongkir_area_id" id="chosen" class="form-control">
            <option value="{{ $model->rajaongkir_area_id ?? '' }}">
                {{ isset($model->rajaongkir_area_id) ? $model->area->rajaongkir_area_province_name.' - '.$model->area->rajaongkir_area_city_name.' - '.$model->area->rajaongkir_area_name : 'Please Search Area' }}
            </option>
        </select>
        {!! $errors->first('branch_rajaongkir_area_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>