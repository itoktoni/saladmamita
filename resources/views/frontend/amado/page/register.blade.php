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
                        <li class="breadcrumb-item active" aria-current="page">Register</li>
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
                            <h6>Register</h6>
                        </a>
                    </div>

                    <hr>
                </div>

                <div>
                    {!! Form::open(['route' => 'register', 'class' =>
                    'form-horizontal', 'files' => true]) !!}

                    <div class="row form-group">
                        <div class="col-md-6">
                            <label>Username</label>
                            {!! Form::text('username', null, ['class' =>'form-control'])!!}
                            {!! $errors->first('username', '<p class="text-danger">:message</p>') !!}
                        </div>

                        <div class="col-md-6">
                            <label>Name</label>
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('name', '<p class="text-danger">:message</p>')
                            !!}
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
                            <label>Confirm Password</label>
                            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                            {!! $errors->first('password_confirmation', '<p class="text-danger">:message</p>
                            ') !!}
                        </div>
                    </div>

                    <hr>

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
