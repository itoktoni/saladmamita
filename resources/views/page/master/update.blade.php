@extends(Helper::setExtendBackend())
@section('content')
<div class="row">
    <div class="panel-body">
        {!! Form::model($model, ['route'=>[$action_code, 'code' => $model->$key],'class'=>'form-horizontal','files'=>true]) !!}
        <div class="panel panel-default">
            <header class="panel-heading">
                <h2 class="panel-title">@lang('pages.update') {{ ucwords(str_replace('_',' ',$template)) }} {{ $model->$key }}</h2>
            </header>
            <div class="panel-body line">
                <div class="">
                    @includeIf(Helper::include($template))
                </div>
            </div>
        </div>
         @include($template_action)
        {!! Form::close() !!}
    </div>
</div>
@endsection