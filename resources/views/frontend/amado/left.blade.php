<!-- Mobile Nav (max width 767px)-->
<div class="mobile-nav">
    <!-- Navbar Brand -->
    <div class="amado-navbar-brand">
        <a href="{{ url('/') }}">
            <img class="logo" src="{{ Helper::files('logo/'.config('website.logo')) }}" alt="">
        </a>
    </div>
    <!-- Navbar Toggler -->
    <div class="amado-navbar-toggler">
        <span></span><span></span><span></span>
    </div>
</div>

<!-- Header Area Start -->
<header class="header-area clearfix">
    <!-- Close Icon -->
    <div class="nav-close">
        <i class="fa fa-close" aria-hidden="true"></i>
    </div>
    <!-- Logo -->
    <div class="logo">
        <a href="{{ url('/') }}">
            <img class="logo" src="{{ Helper::files('logo/'.config('website.logo')) }}" alt="">
        </a>
    </div>
    <!-- Amado Nav -->
    <nav class="amado-nav">
        <ul>
            <li class="{{ request()->segment(1) == '' ? 'active' : '' }}"><a href="{{ url('/') }}">Home</a></li>
            <li class="{{ request()->segment(1) == 'product' ? 'active' : '' }} {{ request()->segment(1) == 'jual' ? 'active' : '' }}"><a href="{{ route('shop') }}">Shop</a></li>
            <li class="{{ request()->segment(1) == 'langganan' ? 'active' : '' }} {{ request()->segment(1) == 'langganan' ? 'active' : '' }}"><a href="{{ route('langganan') }}">Berlangganan</a></li>
            <li class="{{ request()->segment(1) == 'confirmation' ? 'active' : '' }}"><a href="{{ route('confirmation') }}">Konfirmasi</a></li>
            <li class="{{ request()->segment(1) == 'branch' ? 'active' : '' }}"><a href="{{ route('branch') }}">Cabang</a></li>
            <li class="{{ request()->segment(1) == 'contact' ? 'active' : '' }}"><a href="{{ route('contact') }}">Contact Us</a></li>
        </ul>
    </nav>

    <hr>
    <!-- Button Group -->
    <div class="amado-btn-group">
        <a href="{{ route('cart') }}" class="btn amado-btn">Cart ( {{ Cart::getTotalQuantity() }} )</a>
        <!-- <a href="#" class="btn amado-btn active search-nav">Search</a> -->
    </div>

    <hr class="">

     <!-- Amado Nav -->
     <nav class="amado-nav">
        <ul>
            @auth
            <li class="{{ request()->segment(1) == 'userprofile' ? 'active' : '' }}"><a href="{{ route('userprofile') }}">Profile</a></li>
            <li class="{{ request()->segment(1) == 'myaccount' ? 'active' : '' }}"><a href="{{ route('myaccount') }}">List Order</a></li>
            <li class="{{ request()->segment(1) == 'logout' ? 'active' : '' }}"><a class="text-danger" href="{{ route('logout') }}">Logout</a></li>
            @else
            <li class="{{ request()->segment(1) == 'login' ? 'active' : '' }}"><a href="{{ route('login') }}">Login</a></li>
            <li class="{{ request()->segment(1) == 'register' ? 'active' : '' }}"><a href="{{ route('register') }}">Register</a></li>

            @endauth
        </ul>
    </nav>

    <hr>


    <!-- Social Button -->
    <div class="social-info d-flex justify-content-between">
        @foreach($sosmed as $social)
        <a target="_blank" href="{{ $social->marketing_sosmed_link }}"><i
                class="fa fa-{{ $social->marketing_sosmed_icon }}" aria-hidden="true"></i></a>
        @endforeach
    </div>

    <hr>


</header>
<!-- Header Area End -->