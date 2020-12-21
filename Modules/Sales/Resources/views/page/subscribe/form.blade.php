<x-area :selector="['from_area', 'to_area']" />
<x-date :array="['date']" />

<div class="form-group">

    {!! Form::label('name', 'Customer', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_langganan_to_id') ? 'has-error' : ''}}">
        {{ Form::select('sales_langganan_to_id', $customers, null, ['class'=> 'form-control', 'id' => 'to_id']) }}
        {!! $errors->first('sales_langganan_to_id', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_langganan_to_name') ? 'has-error' : ''}}">
        {!! Form::text('sales_langganan_to_name', null, ['class' => 'form-control', 'id' => 'to_name']) !!}
        {!! $errors->first('sales_langganan_to_name', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">
    {!! Form::label('name', 'Phone', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_langganan_to_phone') ? 'has-error' : ''}}">
        {!! Form::text('sales_langganan_to_phone', null, ['class' => 'form-control', 'id' => 'to_phone']) !!}
        {!! $errors->first('sales_langganan_to_phone', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Email', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_langganan_to_email') ? 'has-error' : ''}}">
        {!! Form::text('sales_langganan_to_email', null, ['class' => 'form-control', 'id' => 'to_email']) !!}
        {!! $errors->first('sales_langganan_to_email', '<p class="help-block">:message</p>') !!}
    </div>

</div>
<div class="form-group">
    {!! Form::label('name', 'Area', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('sales_langganan_to_area') ? 'has-error' : ''}}">
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-primary to_area" type="button">Select</button>
                <input type="hidden" name="to_area" value="{{ old('to_area') ?? '' }}">
            </span>
            {{ Form::select('sales_langganan_to_area', old('to_area') ? [old('sales_langganan_to_area') => old('to_area')] : $to, null, ['class'=> 'form-control select', 'id' => 'to_area']) }}
            {!! $errors->first('sales_langganan_to_area', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'Alamat Lengkap', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('sales_langganan_to_address') ? 'has-error' : ''}}">
        {!! Form::textarea('sales_langganan_to_address', null, ['class' => 'form-control', 'rows' => 3, 'id' =>
        'to_address']) !!}
        {!! $errors->first('sales_langganan_to_address', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<hr>

<div class="form-group">

    {!! Form::label('name', 'Location Pickup', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_langganan_from_id') ? 'has-error' : ''}}">
        {{ Form::select('sales_langganan_from_id', $branch, null, ['class'=> 'form-control', 'id' => 'from_id']) }}
        {!! $errors->first('sales_langganan_from_id', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_langganan_from_name') ? 'has-error' : ''}}">
        {!! Form::text('sales_langganan_from_name', null, ['class' => 'form-control', 'id' => 'from_name']) !!}
        {!! $errors->first('sales_langganan_from_name', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">
    {!! Form::label('name', 'Phone', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_langganan_from_phone') ? 'has-error' : ''}}">
        {!! Form::text('sales_langganan_from_phone', null, ['class' => 'form-control', 'id' => 'from_phone']) !!}
        {!! $errors->first('sales_langganan_from_phone', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Email', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_langganan_from_email') ? 'has-error' : ''}}">
        {!! Form::text('sales_langganan_from_email', null, ['class' => 'form-control', 'id' => 'from_email']) !!}
        {!! $errors->first('sales_langganan_from_email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Area', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('sales_langganan_from_area') ? 'has-error' : ''}}">
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-primary from_area" type="button">Select</button>
                <input type="hidden" name="from_area" value="{{ old('from_area') ?? '' }}">
            </span>
            {{ Form::select('sales_langganan_from_area', old('from_area') ? [old('sales_langganan_from_area') => old('from_area')] : $from, null, ['class'=> 'form-control select', 'id' => 'from_area']) }}
            {!! $errors->first('sales_langganan_from_area', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Alamat Lengkap', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('sales_langganan_from_address') ? 'has-error' : ''}}">
        {!! Form::textarea('sales_langganan_from_address', null, ['class' => 'form-control', 'rows' => 3, 'id' =>
        'from_address']) !!}
        {!! $errors->first('sales_langganan_from_address', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<hr>

<div class="form-group">
    {!! Form::label('name', 'Status', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_langganan_status') ? 'has-error' : ''}}">
        {{ Form::select('sales_langganan_status', $status, null, ['class'=> 'form-control', 'id' => 'promo_id']) }}
        {!! $errors->first('sales_langganan_status', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Delivery Date', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_langganan_date_order') ? 'has-error' : ''}}">
        {!! Form::text('sales_langganan_date_order', $model->sales_langganan_date_order ?? date('Y-m-d'), ['class' =>
        'form-control date']) !!}
        {!! $errors->first('sales_langganan_date_order', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'Catatan Internal', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_langganan_notes_internal') ? 'has-error' : ''}}">
        {!! Form::textarea('sales_langganan_notes_internal', null, ['class' => 'form-control', 'rows' => 3]) !!}
        {!! $errors->first('sales_langganan_notes_internal', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Catatan Customer', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_langganan_notes_external') ? 'has-error' : ''}}">
        {!! Form::textarea('sales_langganan_notes_external', null, ['class' => 'form-control', 'rows' => 3]) !!}
        {!! $errors->first('sales_langganan_notes_external', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<hr>

<div class="form-group">
    {!! Form::label('name', 'Tanggal Pembayaran', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_langganan_payment_date') ? 'has-error' : ''}}">
        <div class="input-group">
            {!! Form::text('sales_langganan_payment_date', null, ['class'=>'form-control date']) !!}
            <span class="input-group-btn">
                <a class="btn btn-danger" target="_blank" download=""
                    href="{{ Helper::files('public/'.$model->sales_langganan_payment_file) }}">Download</a>
            </span>
            {!! $errors->first('sales_langganan_payment_date', '<p class="help-block">:message</p>') !!}
        </div>
        {!! $errors->first('sales_langganan_payment_date', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Nama Pengirim', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_langganan_payment_person') ? 'has-error' : ''}}">
        {!! Form::text('sales_langganan_payment_person', null, ['class' =>
        'form-control']) !!}
        {!! $errors->first('sales_langganan_payment_person', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'Catatan Pembayaran', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('sales_langganan_payment_notes') ? 'has-error' : ''}}">
        {!! Form::textarea('sales_langganan_payment_notes', null, ['class' => 'form-control', 'rows' => 3]) !!}
        {!! $errors->first('sales_langganan_payment_notes', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">
    {!! Form::label('name', 'Metode Pembayaran', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_langganan_term_top') ? 'has-error' : ''}}">
        {{ Form::select('sales_langganan_term_top', $tops, null, ['class'=> 'form-control']) }}
        {!! $errors->first('sales_langganan_term_top', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Masuk Rekening', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_langganan_payment_bank_to_id') ? 'has-error' : ''}}">
        {{ Form::select('sales_langganan_payment_bank_to_id', $bank, null, ['class'=> 'form-control']) }}
        {!! $errors->first('sales_langganan_payment_bank_to_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Metode Delivery', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_langganan_delivery_type') ? 'has-error' : ''}}">
        {{ Form::select('sales_langganan_delivery_type', $delivery, null, ['class'=> 'form-control']) }}
        {!! $errors->first('sales_langganan_delivery_type', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Description Ongkir', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_langganan_delivery_name') ? 'has-error' : ''}}">
        {!! Form::text('sales_langganan_delivery_name', null, ['class' => 'form-control']) !!}
        {!! $errors->first('sales_langganan_delivery_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<hr>

<div class="col-md-12">
    @if(!empty($detail))
    @foreach ($detail as $order)
    @php
    $date = $order->sales_order_date_order;
    $i = $loop->iteration;
    @endphp

    <table class="table table-bordered table-responsive">
        <thead>
            <tr style="background-color: whitesmoke;">
                <td colspan="2" width="100%" class="align-middle align-items-center">
                    Hari ke {{ $i }} - {{ $order->sales_order_id }} | Tanggal :
                    {{ $order->sales_order_date_order->format('d-m-Y') }}
                </td>
            </tr>
        </thead>
        <tbody>
            @foreach($order->detail as $item)
            <tr>
                <td class="align-middle">
                    {{ $item->product->item_product_name }}
                    ( Harga : {{ Helper::createRupiah($item->sales_order_detail_price) }} )
                </td>

                <td class="align-middle align-items-center">
                    @if($item->variant($item->sales_order_detail_item_product_id)->count() > 0)
                    @foreach($item->variant($item->sales_order_detail_item_product_id)->get() as $var)

                    @if($var->sales_order_detail_variant_qty > 0)
                    <small>({{ $var->sales_order_detail_variant_qty }})
                        {{ $var->variant->item_variant_name ?? '' }}</small>
                    <br>
                    @endif

                    @endforeach
                    @else

                    <small>({{ $item->sales_order_detail_qty }})
                        {{ $item->product->item_product_name ?? '' }}</small>
                    <br>

                    @endif

                </td>

            </tr>
            @endforeach
        </tbody>

    </table>

    @endforeach
    @endif

    <div class="row form-group">
        <div class="col-md-12">
            <p class="text-right">
                <a target="_blank" href="{{ route('langganan', ['token' => $model->sales_langganan_token]) }}" class="btn btn-danger btn-sm">
                    Print Order
                </a>
            </p>
        </div>
    </div>
</div>