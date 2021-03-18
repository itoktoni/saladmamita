<div class="form-group">

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'name') ? 'has-error' : ''}}">
        {!! Form::text($form.'name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'name', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Hari', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'day') ? 'has-error' : ''}}">
        {!! Form::text($form.'day', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'day', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Price', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'price') ? 'has-error' : ''}}">
        {!! Form::text($form.'price', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'price', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'description') ? 'has-error' : ''}}">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control', 'rows' => 3]) !!}
        {!! $errors->first($form.'description', '<p class="help-block">:message</p>') !!}
    </div>

</div>

@if(isset($model))

<div id="detail" class="panel-body">
    <div class="panel panel-default">
        <div class="panel-body line">
            <div class="{{ $errors->has('detail') ? 'has-error' : ''}}">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="inputDefault">Product</label>
                    <div class="col-md-4 {{ $errors->has('product') ? 'has-error' : ''}}">
                        {{ Form::select('', $product, null, ['class'=> 'form-control', 'id' => 'product']) }}
                    </div>

                    <div class="col-md-2">
                        <span id="add" class="btn btn-primary detail btn-block" style="margin-top: 0px;">Add
                            Detail</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<table id="transaction" class="table table-no-more table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-left col-md-1">Product ID</th>
            <th class="text-left col-md-4">Product Name and Description</th>
        </tr>
    </thead>
    <tbody class="markup">
        @if(!empty($detail) || old('detail'))
        @foreach (old('detail') ?? $detail as $item)
        <tr>
            <td data-title="ID Product">
                @if(old('detail'))
                <button id="delete" value="{{ $item['temp_id'] }}" type="button"
                    class="btn btn-danger btn-xs btn-block">{{ $item['temp_id'] }}</button>
                @else
                <a id="delete" value="{{ $item->marketing_langganan_detail_id ?? '' }}"
                    href="{{ route(config('module').'_delete', ['code' => $item->marketing_langganan_detail_langganan_id, 'detail' => $item->marketing_langganan_detail_id ]) }}"
                    class="btn btn-danger btn-xs btn-block delete-{{ $item->marketing_langganan_detail_id }}">
                    {{ $item->marketing_langganan_detail_product_id ?? '' }}
                </a>
                @endif
                <input type="hidden"
                    value="{{ $item->marketing_langganan_detail_product_id ?? $item['temp_id'] ?? '' }}"
                    name="temp_id[]">
                <input type="hidden"
                    value="{{ $item->marketing_langganan_detail_product_id ?? $item['temp_id'] ?? '' }}"
                    name="detail[{{ $loop->index }}][temp_id]">
            </td>
            <td data-title="Product">
                <input type="text" readonly class="form-control input-sm"
                    value="{{ $item->item_product_name ?? $item['temp_product'] ?? '' }}"
                    name="detail[{{ $loop->index }}][temp_product]">
            </td>
        </tr>
        @endforeach
        @endisset
    </tbody>
</table>


@push('javascript')
<script>
$("#add").click(function(e) {
    addDetail(e);
    e.preventDefault();
});

function addDetail(e) {
    var input_product = $('#product option:selected');

    if (input_product.val() == '') {
        new PNotify({
            title: 'Error Select Product',
            text: 'You must select Product',
            addclass: 'notification-danger',
            icon: 'fa fa-bolt'
        });

        return false;
    }

    var product_id = input_product.val();
    var product_name = input_product.text().trim();
    var counter = $(".temp_id").length;

    if (product_id && product_name) {

        var ep = document.getElementsByName('temp_id[]');

        var markup = "<tr>" +
            "<td data-title='ID' class='col-lg-1'><button id='delete' value='" + product_id +
            "' type='button' class='btn btn-danger btn-xs btn-block'>" + product_id + "</button></td>" +
            "<td data-title='Product'>" +
            "<input class='form-control input-sm text-left' readonly name='detail[" + counter +
            "][temp_product]' value='" + product_name + "'>" +
            "</td>" +
            "<input type='hidden' value='" + product_id + "' name='detail[" + counter +
            "][temp_id]'><input type='hidden' value='" + product_id + "' name='temp_id[]'>" +
            "'" +
            "</td></tr>";
        $("#transaction .markup").append(markup);

        return false;

    } else {
        new PNotify({
            title: 'Error Data',
            text: 'Please Input Price & Quantity !',
            addclass: 'notification-danger',
            icon: 'fa fa-bolt'
        });
    }
}

$(document).on('click', '#delete', function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    var id = $(this).attr('value');

    $.alertable.confirm('Are You sure to delete ?').then(function(e) {
        if (typeof url !== typeof undefined && url !== false) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                success: function() {
                    $('.delete-' + id).closest("tr").remove();
                }
            });
        } else {
            $('button[value="' + id + '"]').parents("tr").remove();
        }
        $("#product").val('');
        $("#product").trigger("chosen:updated");
    }, function(x) {
        console.log('Confirmation canceled');
    });
});
</script>
@endpush

@endif