@component('components.mask', ['array' => ['money', 'number']])
@endcomponent

<div class="form-group">

    {!! Form::label('name', 'Kota Asal', ['class' => 'col-md-3 control-label']) !!}
    <div class="col-md-9 {{ $errors->has('from') ? 'has-error' : ''}}">
        {{ Form::select('from', $cities, null, ['class'=> 'form-control']) }}
        {!! $errors->first('from', '<p class="help-block">:message</p>') !!}
    </div>

</div>
<div class="form-group">

    {!! Form::label('name', 'Kota Tujuan', ['class' => 'col-md-3 control-label']) !!}
    <div class="col-md-9 {{ $errors->has('to') ? 'has-error' : ''}}">
        {{ Form::select('to', $cities, null, ['class'=> 'form-control']) }}
        {!! $errors->first('to', '<p class="help-block">:message</p>') !!}
    </div>

</div>
<hr>
<div class="form-group">

    {!! Form::label('name', 'Metode', ['class' => 'col-md-3 control-label']) !!}
    <div class="col-md-9 {{ $errors->has('metode') ? 'has-error' : ''}}">
        {{ Form::select('metode', ['save' => 'Save', 'update' => 'Update'], null, ['class'=> 'form-control']) }}
        {!! $errors->first('metode', '<p class="help-block">:message</p>') !!}
    </div>

</div>
<hr>
@foreach ($paket as $kpaket => $vpaket)
<div class="form-group">
    <input type="hidden" name="packages[{{ $loop->index }}][paket]" value="{{ $kpaket }}">
    @foreach ($tops as $key => $top)

    {!! Form::label('name', 'Paket '. $vpaket , ['class' => 'col-md-3 control-label']) !!}

    <div class="col-md-9 {{ $errors->has('price.*') ? 'has-error' : ''}}">

        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">{{ $top }}</span>
            <input type="text" name="price[{{ $loop->index }}][{{ $kpaket }}][harga]" class="form-control number" id="">
            <input type="hidden" name="price[{{ $loop->index }}][{{ $kpaket }}][top]" value="{{ $key }}">
        </div>

        {!! $errors->first('top*', '<p class="help-block">:message</p>') !!}
    </div>

    @endforeach

</div>
@endforeach