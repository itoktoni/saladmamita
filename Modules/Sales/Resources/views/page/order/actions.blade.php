<div class="action text-center">
    @if (isset($actions['update']))
    <a id="linkMenu" href="{{ route($module.'_update', ['code' => $model->{$model->getKeyName()}]) }}"
        class="btn btn-xs btn-primary">@lang('pages.update')</a>
    @endif

    <a id="linkMenu" target="_blank" href="{{ route($module.'_print_order', ['code' => $model->{$model->getKeyName()}]) }}"
        class="btn btn-xs btn-danger">Print
    </a>
</div>