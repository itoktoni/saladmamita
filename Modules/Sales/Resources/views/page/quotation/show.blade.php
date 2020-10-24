@extends(Helper::setExtendBackend())
@section('content')
<div class="row">
     <div class="panel-body">
         <div class="panel panel-default">
            <header class="panel-heading">
                <h2 class="panel-title">{{ ucwords(str_replace('_',' ',$template)) }} : {{ $model->$key }}</h2>
            </header>

            <div class="panel-body line">
                <div class="show">
                    <table class="table table-table table-bordered table-striped table-hover mb-none">
                        <tbody>

                            @foreach($fields as $item => $value)
                            <tr>
                                <th class="col-lg-2">{{ $value }}</th>
                                <td>{{ $model->$item }}</td>
                            </tr>
                            @endforeach

                            <tr>
                                <th class="col-lg-2">Total Pembayaran</th>
                                <td>{{ number_format($model->sales_order_total) }}</td>
                            </tr>
                        </tbody>
                    </table>

                    @include($folder.'::page.'.$template.'.payment')
                    @include($folder.'::page.'.$template.'.table')
                </div>
            </div>

            @include($folder.'::page.'.$template.'.action')

        </div>
     </div>
    
</div>

@endsection