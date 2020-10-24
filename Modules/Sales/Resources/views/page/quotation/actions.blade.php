<div class="action text-center">
    @if (isset($actions['update']))
    <a id="linkMenu" href="{{ route($module.'_update', ['code' => $model->{$model->getKeyName()}]) }}"
        class="btn btn-xs btn-primary">@lang('pages.update')</a>
    @endif
   
    @if (isset($actions['show']))
    <a id="linkMenu" href="{{ route($module.'_show',['code' => $model->{$model->getKeyName()}]) }}"
        class="btn btn-xs btn-success">@lang('pages.show')</a>
    @endif

    @if (isset($actions['order']))
    <a id="linkMenu" href="{{ route($module.'_order', ['code' => $model->{$model->getKeyName()}]) }}"
        class="btn btn-xs btn-danger">Create Order
    </a>
    @endif
</div>