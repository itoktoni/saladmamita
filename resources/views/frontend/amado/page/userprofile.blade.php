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

                    <div class="row form-group">
                        <div class="col-md-6">
                            <label>Name</label>
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('name', '<p class="text-danger">:message</p>')
                            !!}
                        </div>
                        <div class="col-md-6">
                            <label>Password</label>
                            {!! Form::password('password', ['class' => 'form-control']) !!}
                            {!! $errors->first('password', '<p class="text-danger">:message</p>
                            ') !!}
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
                            {!! Form::email('phone', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('phone', '<p class="text-danger">:message</p>
                            ') !!}
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label>Address</label>
                            {!! Form::textarea('address', null, ['class' => 'form-control',
                            'rows' => '3']) !!}
                            {!! $errors->first('address', '<p class="text-danger">:message
                            </p>
                            ') !!}
                        </div>
                        <div class="col-md-6">
                            <label>Postcode</label>
                            {!! Form::text('postcode', null, ['class' =>'form-control'])!!}
                            {!! $errors->first('postcode', '<p class="text-danger">:message</p>') !!}
                        </div>
                    </div>

                    <hr>

                    <div class="row form-group">
                        <div class="col-md-4">
                            <label>Province</label>
                            {{ Form::select('province', $list_province, $province, ['id' => 'province', 'class'=> ''.($errors->has('province') ? 'error':'')]) }}
                        </div>
                        <div class="col-md-4">
                            <label>Postcode</label>
                            <label>City</label>
                            {{ Form::select('city', $list_city, $city, ['id' => 'city','class'=> 'chosen']) }}
                        </div>
                        <div class="col-md-4">
                            <label>Area</label>
                            {{ Form::select('location', $list_location, $location, ['id' => 'location','class'=> ''.($errors->has('location') ? 'error':'')]) }}
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