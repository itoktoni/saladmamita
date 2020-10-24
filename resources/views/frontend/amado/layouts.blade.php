<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>{{ config('website.name') }}</title>

    <!-- Favicon  -->
    <link
        href="{{ config('website.favicon') ? Helper::files('logo/'.config('website.favicon')) : Avatar::create(config('website.name'))->setShape('square')->setBackground(config('website.color')) }}"
        rel="shortcut icon">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="{{ Helper::frontend('scss/style.css') }}">

</head>

<body>
   
    @include(Helper::setExtendFrontend('search'))

    <!-- ##### Main Content Wrapper Start ##### -->
    <div class="main-content-wrapper d-flex clearfix">

        @include(Helper::setExtendFrontend('left'))

        @yield('content')

    </div>
    <!-- ##### Main Content Wrapper End ##### -->

    @include(Helper::setExtendFrontend('footer'))
    @include(Helper::setExtendFrontend('js'))

</body>

</html>