<title>{{ config('website.name') }} | eCommerce </title>
<meta charset="UTF-8">
<meta name="description" content="{{ config('website.description') }}">
<meta name="keywords" content="{{ config('website.description') }}">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
<!-- Favicon -->
<link href="{{ config('website.favicon') ? Helper::files('logo/'.config('website.favicon')) : Avatar::create(config('website.name'))->setShape('square')->setBackground(config('website.color')) }}" rel="shortcut icon">

<!-- Google Font -->

@include(Helper::setExtendFrontend('css'))

<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->