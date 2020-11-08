@extends(Helper::setExtendBackend())
@section('content')
<div class="row">
    <div class="panel-body">
        @isset($model->$key)
        {!! Form::model($model, ['route'=>[$action_code, 'code' => $model->$key],'class'=>'form-horizontal
        ','files'=>true])
        !!}
        @else
        {!! Form::open(['route' => $action_code, 'class' => 'form-horizontal', 'files' => true]) !!}
        @endisset
        <div class="panel panel-default">

            <header class="panel-heading">
                @isset($model->$key)
                <h2 class="panel-title">Edit {{ ucwords(str_replace('_',' ',$template)) }} : {{ $model->$key }}</h2>
                @else
                <h2 class="panel-title">Create {{ ucwords(str_replace('_',' ',$template)) }}</h2>
                @endisset
            </header>

            <div class="panel-body line">
                <div class="">
                    @includeIf(Helper::includeForm($template, 'form'))
                </div>
            </div>
            <div class="navbar-fixed-bottom" id="menu_action">
                <div class="text-right" style="padding:5px">
                    @if($model->sales_delivery_status == 1)
                    <a target="__blank" href="{!! route($module.'_print_invoice', ['code'=> $model->{$key}]) !!}"
                        class="btn btn-danger">Invoice</a>
                    @endif
                    <a id="linkMenu" href="{!! route($module.'_data') !!}" class="btn btn-warning">Back</a>
                    @if($model->sales_delivery_status == 1)
                    <a target="__blank" href="{!! route($module.'_print_do', ['code'=> $model->{$key}]) !!}"
                        class="btn btn-danger">DO</a>
                    @else
                    <button type="submit" class="btn btn-primary">Save</button>
                    @endif

                </div>
            </div>

        </div>
        {!! Form::close() !!}

    </div>
</div>

@endsection