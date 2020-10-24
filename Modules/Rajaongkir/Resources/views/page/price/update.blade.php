@extends(Helper::setExtendBackend())
@section('content')
<div class="row">

    {!! Form::model($model, ['route'=>[$action_code, 'code' => $model->$key],'class'=>'form-horizontal','files'=>true])
    !!}

    <div class="panel-body">
        <div class="panel panel-default">
            <header class="panel-heading">
                <h2 class="panel-title">Edit Harga</h2>
                </header>

            <div class="panel-body line">
                <div class="col-md-12 col-lg-12">
                    <div class="form-group">

                        {!! Form::label('name', 'Area Asal', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-10 {{ $errors->has($form.'from') ? 'has-error' : ''}}">
                            {{ Form::select($form.'from', $area, null, ['class'=> 'form-control']) }}
                            {!! $errors->first($form.'from', '<p class="help-block">:message</p>') !!}
                        </div>

                    </div>

                    <div class="form-group">
                    
                        {!! Form::label('name', 'Area Tujuan', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-10 {{ $errors->has($form.'to') ? 'has-error' : ''}}">
                            {{ Form::select($form.'to', $area, null, ['class'=> 'form-control']) }}
                            {!! $errors->first($form.'to', '<p class="help-block">:message</p>') !!}
                        </div>
                    
                    </div>
                    <hr>
                    <div class="form-group">

                        {!! Form::label('name', 'Paket', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-2 {{ $errors->has($form.'paket') ? 'has-error' : ''}}">
                            {{ Form::select($form.'paket', $paket, null, ['class'=> 'form-control']) }}
                            {!! $errors->first($form.'paket', '<p class="help-block">:message</p>') !!}
                        </div>

                        {!! Form::label('name', 'Metode Pembayaran', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-2 {{ $errors->has($form.'top') ? 'has-error' : ''}}">
                            {{ Form::select($form.'top', $tops, null, ['class'=> 'form-control']) }}
                            {!! $errors->first($form.'top', '<p class="help-block">:message</p>') !!}
                        </div>

                        {!! Form::label('name', 'Harga', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-2 {{ $errors->has($form.'value') ? 'has-error' : ''}}">
                            {!! Form::text($form.'value', null, ['class' => 'form-control']) !!}
                            {!! $errors->first($form.'value', '<p class="help-block">:message</p>') !!}
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="navbar-fixed-bottom" id="menu_action">
        <div class="text-right" style="padding:5px">
            @include(Helper::setViewCrud())
        </div>
    </div>
    {!! Form::close() !!}
</div>

@endsection