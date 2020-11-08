@extends(Helper::setExtendFrontend())

<x-date :array="['date']" />
<x-mask :array="['number', 'money']" />

@section('content')
<!-- Product Details Area Start -->
<div class="single-product-area clearfix">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mt-50">
                        <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- checkout section  -->
        <section class="row">
            <div class="container">

                <div class="single_product_desc">
                    <!-- Product Meta Data -->
                    <div class="product-meta-data">
                        <div class="line"></div>
                        <a chref="{{ route('branch') }}">
                            <h6>Personal Data [ {{ Auth::user()->username ?? '' }} ]</h6>
                        </a>
                    </div>

                    <hr>
                </div>

                <div style="border-bottom:1px solid lightgrey;background-color:white">
                    {!! Form::model($model, ['route' => 'userprofile', 'class' =>
                    'form-horizontal', 'files' => true]) !!}

                    <div class="row">
                        <div class="col-md-12">
                            @if ($errors)
                            @foreach ($errors->all() as $error)
                            <div class="alert alert-sm alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{ $error }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-6">
                            <label>Name</label>
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('name', '<p class="text-danger">:message</p>')
                            !!}
                        </div>
                        <div class="col-md-6">
                            <label>Username</label>
                            {!! Form::text('username', null, ['class' =>'form-control'])!!}
                            {!! $errors->first('username', '<p class="text-danger">:message</p>') !!}
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label>Email</label>
                            {!! Form::text('email', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('email', '<p class="text-danger">:message</p>')
                            !!}
                        </div>
                        <div class="col-md-6">
                            <label>Phone</label>
                            {!! Form::text('phone', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('phone', '<p class="text-danger">:message</p>
                            ') !!}
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label>Password</label>
                            {!! Form::password('password', ['class' => 'form-control']) !!}
                            {!! $errors->first('password', '<p class="text-danger">:message</p>
                            ') !!}
                        </div>

                        <div class="col-md-6">
                            <label>Address</label>
                            {!! Form::textarea('address', null, ['class' => 'form-control',
                            'rows' => '3']) !!}
                            {!! $errors->first('address', '<p class="text-danger">:message
                            </p>
                            ') !!}
                        </div>
                    </div>

                    <hr>

                    <div class="row form-group">
                        <div class="col-md-4">
                            <label>Province</label>
                            {{ Form::select('province', $list_province, $province, ['id' => 'province', 'class'=> 'form-control form-control-sm']) }}
                        </div>
                        <div class="col-md-4">
                            <label>Postcode</label>
                            <label>City</label>
                            {{ Form::select('city', $list_city, $city, ['id' => 'city', 'class'=> 'form-control form-control-sm']) }}
                        </div>
                        <div class="col-md-4">
                            <label>Area</label>
                            {{ Form::select('area', $list_area, $area, ['id' => 'location','class'=> 'form-control form-control-sm']) }}
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary btn-sm">Save
                                    Data</button>
                            </div>
                        </div>
                    </div>

                    {!! Form::close() !!}

                </div>

            </div>
        </section>
        <!-- checkout section end -->
    </div>
</div>
@endsection


@push('javascript')
<script>
$(document).ready(function() {

    $('#province').change(function() { // Jika Select Box id provinsi dipilih
        var data = $("#province option:selected");
        var province = data.val(); // Ciptakan variabel provinsi
        var city = $('#city');
        $.ajax({
            type: 'GET', // Metode pengiriman data menggunakan POST
            url: '{{ route("city") }}',
            data: 'province=' + province, // Data yang akan dikirim ke file pemroses
            success: function(response) { // Jika berhasil
                city.empty();
                city.append('<option value="">-- Select City --</option>');
                $.each(response, function(idx, obj) {
                    city.append('<option postcode="' + obj
                        .rajaongkir_city_postal_code + '" value="' + obj
                        .rajaongkir_city_id + '">' + obj.rajaongkir_city_type+ ' ' + obj.rajaongkir_city_name +
                        '</option>');
                });
                city.trigger("chosen:updated");
            }
        });
    });

    $('#city').change(function() { // Jika Select Box id provinsi dipilih
        var data = $("#city option:selected");
        var city = data.val(); // Ciptakan variabel provinsi
        // var postcode = data.attr('postcode');
        var location = $('#location');
        // $('#postcode').val(postcode);
        $.ajax({
            type: 'GET', // Metode pengiriman data menggunakan POST
            url: '{{ route("location") }}',
            data: 'city=' + city, // Data yang akan dikirim ke file pemroses
            success: function(response) { // Jika berhasil
                location.empty();
                location.append('<option value="">-- Select Location --</option>');
                $.each(response, function(idx, obj) {
                    location.append('<option value="' + obj.rajaongkir_area_id +
                        '">' + obj.rajaongkir_area_name + '</option>');
                });
                $("#location").trigger("chosen:updated");
            }
        });
    });

    $('#location').change(function() {
        var data = $("#location option:selected").text();
        $('#area_name').val(data);
    });

});
</script>
@endpush