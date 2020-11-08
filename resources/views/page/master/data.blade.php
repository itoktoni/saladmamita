@extends(Helper::setExtendBackend())
@component('components.responsive', ['array' => $fields])
@endcomponent
@component('components.datatables',['array' => $fields])@endcomponent
@section('content')
<div class="row">
    <div class="panel-body">
        {!! Form::open(['route' => $action_code, 'id' => 'search-form', 'files' => true]) !!}
        <div id="action-master" class="form-inline">
            <div class="row">
                <div class="col-md-2">
                    <div class="row">
                        <select name="code" class="form-control">
                            <option value="">@lang('pages.search')</option>
                            @foreach($fields as $item => $value)
                            <option value="{{ $item }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="row">
                        <select name="aggregate" class="form-control">
                            <option value="">@lang('pages.search_name')</option>
                            <option value="=">@lang('pages.equal')</option>
                            <option value="!=">@lang('pages.notequal')</option>
                            <option value="like">@lang('pages.contains')</option>
                            <option value="not like">@lang('pages.notcontains')</option>
                            <option value=">">@lang('pages.more')</option>
                            <option value="<">@lang('pages.less')</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="input-group">
                            <input autofocus name="search" class="form-control" placeholder="@lang('pages.search')"
                                type="text">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary">@lang('pages.search_button')</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="clearfix"></div>
        {!! Form::close() !!}
        {!! Form::open(['route' => $module.'_delete', 'id' => '', 'files' => true]) !!}
        <header class="panel-heading">
            <h2 class="panel-title text-right">
                @lang('pages.data') {{ ucwords(str_replace('_',' ',$template)) }}
            </h2>
        </header>
        <div id="selection" class="row">
            <div class="col-xs-12 visible-xs">
                <button type="button" class="btn btn-default">
                    <input type="checkbox" id="checkAll" onClick="toggle(this)" class="selectall" />
                </button>
            </div>
        </div>
        <div class="panel-body line">
            <div class="table-control">
                <div>
                    <table id="datatable" class="responsive table-striped table-condensed table-bordered table-hover">
                        <thead>
                            <tr>
                                @php
                                $status = [
                                'Images',
                                'Active',
                                'Default',
                                'Status',
                                'Paid',
                                'Visible',
                                'Homepage',
                                'Total',
                                'Price',
                                ];
                                $sort = [
                                'Sort',
                                'Qty',
                                'Size',
                                'Stock',
                                ];
                                @endphp
                                @foreach($fields as $item => $value)<th {!! strpos($value, 'Description' ) !==false
                                    ? ' id="description"' : '' !!} {!! in_array($value, $sort) ? ' id="sort"' : '' !!}
                                    {!! $value=='Type' ? ' id="type"' : '' !!} {!! $value=='Ongkir' ? ' id="ongkir"'
                                    : '' !!} {!! $value=='Full Name' ? ' id="fullname"' : '' !!} {!! in_array($value,
                                    $status) ? ' id="status"' : '' !!}>
                                    <strong>{{ $value }}</strong></th>
                                @endforeach
                                <th width="5" class="center"><input id="checkAll" class="selectall"
                                        onclick="toggle(this)" type="checkbox"></th>
                                @php
                                $button = '100';
                                if(session()->has('button')){
                                $button = session('button') > 4 ? '150' : '100';
                                }
                                @endphp
                                <th style="width: {{ $button }}px !important;" class="text-center">
                                    @if($actions->count() > 0 ) <strong>Actions</strong> @endif</th>
                            </tr>
                        </thead>
                    </table>
                </diV>
            </div>
        </div>
        @include($template_action)
        {!! Form::close() !!}
    </div>
</div>
@endsection