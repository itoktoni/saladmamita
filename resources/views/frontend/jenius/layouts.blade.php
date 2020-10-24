<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    
    @include(Helper::setExtendFrontend('meta'))
    @include(Helper::setExtendFrontend('css'))

</head>

<body data-hijacking="off" data-animation="none">
    <nav id="mobileNavbar" class="navbar navbar-jenius navbar-absolute fixed-top navbar-expand-lg ">
        <div class="container position-relative">
            <a class="navbar-brand" href="https://www.jenius.com/">
                <img src="https://www.jenius.com/assets/img/brand/logo_jenius-blue.svg" class="logo" alt="Logo">
            </a>
            <button class="navbar-toggler navbar-toggler-left" type="button" data-toggle="collapse"
                data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fal fa-bars"></i>
            </button>
            <a class="search-mobile" href="#modalSearch" data-toggle="modal">
                <i class="icon-search"></i>
            </a>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item " id="navApp">
                        <div class="dropdown clearfix">
                            <a href="https://www.jenius.com/app" class="nav-link animation-underline float-left">
                                App
                            </a>
                            <a href="" class="float-right" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fal fa-angle-down text-primary" id="angle-dropdown"></i>
                            </a>
                            <div class="dropdown-menu animated fadeIn">
                                <a id="hide-menu" class="dropdown-item "
                                    href="https://www.jenius.com/app/currency/foreign-currency" id="navPay">Currency</a>
                                <a id="menu-active" class="dropdown-item " href="https://www.jenius.com/app/pay/pay-me"
                                    id="navPay">Pay</a>
                                <a id="menu-active" class="dropdown-item "
                                    href="https://www.jenius.com/app/save/flexi-saver" id="navPay">Save</a>
                                <a id="menu-active" class="dropdown-item "
                                    href="https://www.jenius.com/app/control/card-center" id="navPay">Control</a>
                                <a id="menu-active" class="dropdown-item "
                                    href="https://www.jenius.com/app/accessibility/jenius-keyboard"
                                    id="navPay">Accessibility</a>
                                <a id="menu-active" class="dropdown-item "
                                    href="https://www.jenius.com/app/fund/flexi-cash" id="navPay">Fund</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item " id="navCard">
                        <a href="https://www.jenius.com/cards" class="nav-link animation-underline">Cards</a> </li>
                    <li class="nav-item " id="navHighlight">
                        <a href="https://www.jenius.com/highlight" class="nav-link animation-underline">Highlight</a>
                    </li>
                    <li class="nav-item " id="navEveryYay">
                        <a href="https://www.jenius.com/everyyay" class="nav-link animation-underline">EveryYay</a>
                    </li>
                    <li class="nav-item " id="navProgram">
                        <a href="https://www.jenius.com/program" class="nav-link animation-underline">Program</a> </li>
                    <li class="nav-item " id="navSupport">
                        <a href="https://www.jenius.com/faq" class="nav-link animation-underline">Support</a> </li>
                </ul>
            </div>

            <div class="navbar-right">
                <ul class="navbar-nav">
                    <li class="navbar-item">
                        <a class="nav-link" href="#modalSearch" data-toggle="modal">
                            <i class="icon-search"></i>
                        </a>
                    </li>
                    <li class="navbar-item ">
                        <a class="nav-link" href="https://www.jenius.com/locations">
                            <i class="icon-locations"></i>
                        </a>
                    </li>
                    <li class="navbar-item">
                        <a class="nav-link" href="https://2secure.jenius.co.id/" target="_blank">
                            <i class="icon-profile"></i>
                        </a>
                    </li>
                    <li class="navbar-item">
                        <div class="lang-list">
                            <div id="lang-inners">
                                <p id="lang-content" class="font-size-md text-white"><a
                                        href="https://www.jenius.com/LanguageSwitcher/switchLang/english/">IND</a></p>

                            </div>
                        </div>
                    </li>
                    <li class="navbar-item">
                        <a href="https://www.jenius.com/getjenius" class="btn btn-primary">Get Jenius</a> </li>
                </ul>
            </div>

        </div>

        <div class="navbar-slide">
            <div class="lang-list">
                <div class="lang-item active">
                    <span><a href="#">IND</a></span>
                </div>
                <div class="lang-item ">
                    <span><a href="https://www.jenius.com/LanguageSwitcher/switchLang/english/">EN</a></span>
                </div>
            </div>
            <div class="navbar-slide-close">
                <span class="icon-bar icon-bar-1"></span>
                <span class="icon-bar icon-bar-2"></span>
                <span class="icon-bar icon-bar-3"></span>
            </div>
            <div class="content">
                <ul class="nav-slide-list">
                    <li class="nav-slide-item" id="navHome">
                        <a class="nav-link" href="https://www.jenius.com/">
                            <img src="https://www.jenius.com/assets/img/navbar/ic_on_home.png" class="img-fluid"
                                alt="Icon Navbar">
                            <span>Home</span>
                        </a>
                    </li>
                    <li class="nav-slide-item " id="navAppMobile">
                        <a class="nav-link" href="https://www.jenius.com/app">
                            <img src="https://www.jenius.com/assets/img/navbar/ic_on_app.png" class="img-fluid"
                                alt="Icon Navbar">
                            <span>App</span>
                        </a>
                    </li>
                    <li class="nav-slide-item " id="navCardMobile">
                        <a class="nav-link" href="https://www.jenius.com/cards">
                            <img src="https://www.jenius.com/assets/img/navbar/ic_on_card.png" class="img-fluid"
                                alt="Icon Navbar">
                            <span>Cards</span>
                        </a>
                    </li>
                    <li class="nav-slide-item " id="navHighlightMobile">
                        <a class="nav-link" href="https://www.jenius.com/highlight">
                            <img src="https://www.jenius.com/assets/img/navbar/ic_on_highlight.png" class="img-fluid"
                                alt="Icon Navbar">
                            <span>Highlight</span>
                        </a>
                    </li>
                    <li class="nav-slide-item " id="navEveryYayMobile">
                        <a class="nav-link" href="https://www.jenius.com/everyyay">
                            <img src="https://www.jenius.com/assets/img/navbar/ic_on_everyay.png" class="img-fluid"
                                alt="Icon Navbar">
                            <span>EveryYay</span>
                        </a>
                    </li>
                    <li class="nav-slide-item " id="navProgramMobile">
                        <a class="nav-link" href="https://www.jenius.com/program">
                            <img src="https://www.jenius.com/assets/img/navbar/ic_on_program.png" class="img-fluid"
                                alt="Icon Navbar">
                            <span>Program</span>
                        </a>
                    </li>
                    <li class="nav-slide-item " id="navSupportMobile">
                        <a class="nav-link" href="https://www.jenius.com/faq">
                            <img src="https://www.jenius.com/assets/img/navbar/ic_on_support.png" class="img-fluid"
                                alt="Icon Navbar">
                            <span>Support</span>
                        </a>
                    </li>
                    <li class="nav-slide-item" id="navGetJenius">
                        <a class="nav-link" href="https://www.jenius.com/getjenius">
                            <img src="https://www.jenius.com/assets/img/navbar/ic_on_jenius.png" class="img-fluid"
                                alt="Icon Navbar">
                            <span>Get Jenius</span>
                        </a>
                    </li>
                </ul>
                <a href="https://www.jenius.com/getjenius" class="btn btn-primary">Belum Punya Jenius?</a>
            </div>
        </div>

    </nav>
    <section id="carouselExampleControls" class="d-none d-lg-block">
        <div class="slide-jenius slider">
            <div class="carousel-item header-wrapper-boarding-mobile homepage-section-new active"
                style="background-image:url('https://assets.jenius.com/assets/2020/01/10100255/BG-Landing-Page2.png');background-color:#e86625;">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="main-slider-banner-homepage">
                                <h1>
                                    <p>Teman yang Memudahkan Setiap Perjalananmu</p>
                                </h1>
                                <div class="description-boarding light">
                                    <p>Traveling ke seluruh dunia lebih mudah dengan Jenius</p>
                                </div>
                                <div class="action-wrapper-button">
                                    <a href="https://www.jenius.com/temantraveling"
                                        class="btn btn-warning purple-button-action" tabindex="0"
                                        style="background-color:#703181;color:#ffffff;">
                                        <span>Cari tau selengkapnya</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="wrapper-image-vector">
                                <img src="https://assets.jenius.com/assets/2020/01/10100911/KV-Teman-Traveling.png"
                                    class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item header-wrapper-boarding-mobile homepage-section-new"
                style="background-image:url('');background-color:#1e73be;">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="main-slider-banner-homepage">
                                <h1>
                                    <p class="animated fadeInUp delayp2">Penawaran Buat Pergi-pergi dari Every Yay!</p>
                                </h1>
                                <div class="description-boarding light">
                                    <p>Spesial di Februari untuk senang-senang<br />
                                        bareng yang tersayang di bulan penuh cinta!</p>
                                </div>
                                <div class="action-wrapper-button">
                                    <a href="https://www.jenius.com/everyyay"
                                        class="btn btn-warning purple-button-action" tabindex="0"
                                        style="background-color:#ef8037;color:#fff;">
                                        <span>Lihat promo lainnya di sini</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="wrapper-image-vector">
                                <img src="https://assets.jenius.com/assets/2020/02/05072252/New-Project-5.png"
                                    class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item header-wrapper-boarding-mobile homepage-section-new"
                style="background-image:url('https://assets.jenius.com/assets/2019/08/28054049/bg_homepage.png');background-color:#33a7d6;">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="main-slider-banner-homepage">
                                <h1>
                                    <p>Menabung, bertransaksi dan atur uang dari aplikasi</p>
                                </h1>
                                <div class="description-boarding light">
                                    <p>Menabung, bertransaksi dan atur uang<br />
                                        dari aplikasi dan Kartu Debit Jenius</p>
                                </div>
                                <div class="action-wrapper-button">
                                    <a data-fancybox="" href="https://www.youtube.com/watch?v=omjlq8ZcE6o"
                                        class="btn btn-warning purple-button-action" tabindex="0"
                                        style="background-color:#6c297f;color:#fff;">
                                        <span>Tonton video Jenius</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="wrapper-image-vector">
                                <img src="https://assets.jenius.com/assets/2019/12/23105759/New-Project-4.png"
                                    class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item header-wrapper-boarding-mobile homepage-section-new"
                style="background-image:url('https://assets.jenius.com/assets/2020/01/09030256/CCW-Background.png');background-color:#000000;">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="main-slider-banner-homepage">
                                <h1>
                                    <p>Jenius Co.Creation<br />
                                        Week 2020</p>
                                </h1>
                                <div class="description-boarding light">
                                    <h4>Reshape</h4>
                                    <p>6-8 Maret 2020</p>
                                </div>
                                <div class="action-wrapper-button">
                                    <a href="https://www.cocreate.id/cocreation-week-2020/"
                                        class="btn btn-warning purple-button-action" tabindex="0"
                                        style="background-color:#dd3333;color:#fff;">
                                        <span>Cari Tau Selengkapnya</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="wrapper-image-vector">
                                <img src="https://assets.jenius.com/assets/2020/01/09025752/Logo-Banner-Jenius-1.png"
                                    class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <section id="carouselExampleControlsMobile" class="carousel slide d-lg-none" data-ride="carousel">
        <div class="slide-jenius slider" role="listbox">
            <div class="carousel-item header-wrapper-boarding-mobile active" style="background-color:#e86625">
                <div class="container text-center">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="main-slider-banner-homepage">
                                <h1 class="mobile-homepage-title-slide">
                                    <p>Teman yang Memudahkan Setiap Perjalananmu</p>
                                </h1>
                                <div class="description-boarding light mobile-description-slider-homepage">
                                    <p>Traveling ke seluruh dunia lebih mudah dengan Jenius</p>
                                </div>
                                <div class="action-wrapper-button mobile-button-wrapper-slider-homepage">
                                    <a href="https://www.jenius.com/temantraveling"
                                        class="btn btn-warning purple-button-action" tabindex="0"
                                        style="background-color:#703181;color:#ffffff;">
                                        <span>Cari tau selengkapnya</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="wrapper-image-vector thumbnail-mobile-wrapper-homepage">
                                <img src="https://assets.jenius.com/assets/2020/01/10100911/KV-Teman-Traveling.png"
                                    class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item header-wrapper-boarding-mobile" style="background-color:#1e73be">
                <div class="container text-center">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="main-slider-banner-homepage">
                                <h1 class="mobile-homepage-title-slide">
                                    <p class="animated fadeInUp delayp2">Penawaran Buat Pergi-pergi dari Every Yay!</p>
                                </h1>
                                <div class="description-boarding light mobile-description-slider-homepage">
                                    <p>Spesial di Februari untuk senang-senang<br />
                                        bareng yang tersayang di bulan penuh cinta!</p>
                                </div>
                                <div class="action-wrapper-button mobile-button-wrapper-slider-homepage">
                                    <a href="https://www.jenius.com/everyyay"
                                        class="btn btn-warning purple-button-action" tabindex="0"
                                        style="background-color:#ef8037;color:#fff;">
                                        <span>Lihat promo lainnya di sini</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="wrapper-image-vector thumbnail-mobile-wrapper-homepage">
                                <img src="https://assets.jenius.com/assets/2020/02/05072252/New-Project-5.png"
                                    class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item header-wrapper-boarding-mobile" style="background-color:#33a7d6">
                <div class="container text-center">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="main-slider-banner-homepage">
                                <h1 class="mobile-homepage-title-slide">
                                    <p>Menabung, bertransaksi dan atur uang dari aplikasi</p>
                                </h1>
                                <div class="description-boarding light mobile-description-slider-homepage">
                                    <p>Menabung, bertransaksi dan atur uang<br />
                                        dari aplikasi dan Kartu Debit Jenius</p>
                                </div>
                                <div class="action-wrapper-button mobile-button-wrapper-slider-homepage">
                                    <a data-fancybox="" href="https://www.youtube.com/watch?v=omjlq8ZcE6o"
                                        class="btn btn-warning purple-button-action" tabindex="0"
                                        style="background-color:#6c297f;color:#fff;">
                                        <span>Tonton video Jenius</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="wrapper-image-vector thumbnail-mobile-wrapper-homepage">
                                <img src="https://assets.jenius.com/assets/2019/12/23105759/New-Project-4.png"
                                    class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item header-wrapper-boarding-mobile" style="background-color:#000000">
                <div class="container text-center">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="main-slider-banner-homepage">
                                <h1 class="mobile-homepage-title-slide">
                                    <p>Jenius Co.Creation<br />
                                        Week 2020</p>
                                </h1>
                                <div class="description-boarding light mobile-description-slider-homepage">
                                    <h4>Reshape</h4>
                                    <p>6-8 Maret 2020</p>
                                </div>
                                <div class="action-wrapper-button mobile-button-wrapper-slider-homepage">
                                    <a href="https://www.cocreate.id/cocreation-week-2020/"
                                        class="btn btn-warning purple-button-action" tabindex="0"
                                        style="background-color:#dd3333;color:#fff;">
                                        <span>Cari Tau Selengkapnya</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="wrapper-image-vector thumbnail-mobile-wrapper-homepage">
                                <img src="https://assets.jenius.com/assets/2020/01/09025752/Logo-Banner-Jenius-1.png"
                                    class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="wrapper-slug-homepage-new grey-section-bg vp-fadein white-slug-homepage">
        <div class="container">
            <div class="row">
                <div class="col-12 d-none d-lg-block text-center">
                    <h2 class="text-center content-slug-desktop-homepage">Cara mudah mengatur kehidupan dan keuangan
                    </h2>
                    <p></p>
                </div>
                <div class="col-12 d-lg-none text-center">
                    <h2 class="text-center slug-mobile-homepage">Cara mudah mengatur kehidupan dan keuangan</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <div class="menu-get-jenius clearfix">
                        <div class="container container-mobile text-center icon-homepage-badge">
                            <div class="footer-download-btn-group" id="apps-link d-lg-none">
                                <a rel="nofollow"
                                    href="https://app.appsflyer.com/id1079340119?pid=jenius.com&c=2018Footer&af_sub1=29249a77-5b83-4a8c-a5d6-b4c679216b11"
                                    target="_blank"><img
                                        src="https://www.jenius.com/assets/img/common/button_appstore.jpg"
                                        width="130"></a>
                                <a rel="nofollow"
                                    href="https://app.appsflyer.com/com.btpn.dc?pid=jenius.com&c=2018Footer&af_sub1=9bcf1489-bed1-4f84-a5b8-ee01468d0337"><img
                                        src="https://www.jenius.com/assets/img/common/button_playstore.jpg"
                                        target="_blank" width="130"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4"></div>
            </div>
        </div>
    </section>
    <section class="wrapper-homepage-feature-icon grey-section-bg d-none d-lg-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="wrapper-thumbnail-feature-homepage text-center vp-fadeinup">
                        <img src="https://assets.jenius.com/assets/2019/08/28054501/first_image.png" class="img-fluid"
                            alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="wrapper-features-homepage-detail vp-fadein" style="padding-left:18%">
                        <div class="wrapper-features-description-icon">
                            <h3>Buka akun tanpa ke bank</h3>
                        </div>
                        <div class="description-icon-features">
                            <p>Mudah registrasi dari aplikasi dan aktivasi lewat <em>video call</em></p>
                        </div>
                        <div class="action-wrapper-button">
                            <a href="https://www.jenius.com/getjenius" class="btn btn-primary homepage-primary-btn">Cari
                                Tau <span class="icon-button-action"><i class="fa fa-chevron-right"></i></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Mobile Section -->
    <section class="wrapper-homepage-feature-icon grey-section-bg d-lg-none">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-6">
                    <div class="wrapper-features-homepage-detail vp-fadein">
                        <div class="wrapper-features-description-icon">
                            <h3>Buka akun tanpa ke bank</h3>
                        </div>
                        <div class="description-icon-features">
                            <p>Mudah registrasi dari aplikasi dan aktivasi lewat <em>video call</em></p>
                        </div>
                        <div class="action-wrapper-button">
                            <a href="https://www.jenius.com/getjenius" class="btn btn-primary homepage-primary-btn">Cari
                                Tau <span class="icon-button-action"><i class="fa fa-chevron-right"></i></span></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="wrapper-thumbnail-feature-homepage text-center vp-fadeinup">
                        <img src="https://assets.jenius.com/assets/2019/08/28054501/first_image.png" class="img-fluid"
                            alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Mobile Section -->
    <section class="wrapper-homepage-feature-icon d-none d-lg-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="wrapper-features-homepage-detail vp-fadein" style="padding-left:18%">
                        <div class="wrapper-features-description-icon">
                            <h3>Bunga tabungan setara deposito</h3>
                        </div>
                        <div class="description-icon-features">
                            <p>Nabung lebih maksimal dengan bunga 4% p.a.</p>
                        </div>
                        <div class="action-wrapper-button">
                            <a href="https://www.jenius.com/app/save/flexi-saver"
                                class="btn btn-primary homepage-primary-btn">Cari Tau <span
                                    class="icon-button-action"><i class="fa fa-chevron-right"></i></span></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="wrapper-thumbnail-feature-homepage text-center vp-fadeinup">
                        <img src="https://assets.jenius.com/assets/2019/08/28054605/seccond.png" class="img-fluid"
                            alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Mobile Section -->
    <section class="wrapper-homepage-feature-icon d-lg-none">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-6">
                    <div class="wrapper-features-homepage-detail vp-fadein">
                        <div class="wrapper-features-description-icon">
                            <h3>Bunga tabungan setara deposito</h3>
                        </div>
                        <div class="description-icon-features">
                            <p>Nabung lebih maksimal dengan bunga 4% p.a.</p>
                        </div>
                        <div class="action-wrapper-button">
                            <a href="https://www.jenius.com/app/save/flexi-saver"
                                class="btn btn-primary homepage-primary-btn">Cari Tau <span
                                    class="icon-button-action"><i class="fa fa-chevron-right"></i></span></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="wrapper-thumbnail-feature-homepage thumbnail-mobile-wrapper-homepage text-center">
                        <img src="https://assets.jenius.com/assets/2019/08/28054605/seccond.png" class="img-fluid"
                            alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Mobile Section -->
    <section class="wrapper-homepage-feature-icon grey-section-bg d-none d-lg-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="wrapper-thumbnail-feature-homepage text-right">
                        <img src="https://assets.jenius.com/assets/2019/08/28054733/third.png" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="wrapper-features-homepage-detail vp-fadein" style="padding-left:18%">
                        <div class="wrapper-features-description-icon">
                            <h3>Praktis <i>top up</i> e-Wallet</h3>
                        </div>
                        <div class="description-icon-features">
                            <p>Isi hingga 10 akun Dana, GoPay, OVO, LinkAja, dan M-Tix dengan nominal fleksibel</p>
                        </div>
                        <div class="action-wrapper-button">
                            <a href="https://www.jenius.com/app/pay/e-wallet"
                                class="btn btn-primary homepage-primary-btn">Cari Tau <span
                                    class="icon-button-action"><i class="fa fa-chevron-right"></i></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- mobile section -->
    <section class="wrapper-homepage-feature-icon grey-section-bg d-lg-none">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-6">
                    <div class="wrapper-features-homepage-detail vp-fadein">
                        <div class="wrapper-features-description-icon">
                            <h3>Praktis <i>top up</i> e-Wallet</h3>
                        </div>
                        <div class="description-icon-features">
                            <p>Isi hingga 10 akun Dana, GoPay, OVO, LinkAja, dan M-Tix dengan nominal fleksibel</p>
                        </div>
                        <div class="action-wrapper-button">
                            <a href="https://www.jenius.com/app/pay/e-wallet"
                                class="btn btn-primary homepage-primary-btn">Cari Tau <span
                                    class="icon-button-action"><i class="fa fa-chevron-right"></i></span></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="wrapper-thumbnail-feature-homepage thumbnail-mobile-wrapper-homepage text-right">
                        <img src="https://assets.jenius.com/assets/2019/08/28054733/third.png" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- mobile section -->
    <section class="wrapper-homepage-feature-icon cards-section-homepage d-none d-lg-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="wrapper-features-homepage-detail vp-fadein" style="padding-left:18%">
                        <div class="wrapper-features-description-icon">
                            <h3>Belanja <i>online</i> pakai kartu debit</h3>
                        </div>
                        <div class="description-icon-features">
                            <p>Transaksi <i>online</i> gak kebablasan dengan<br />
                                kartu debit virtual</p>
                        </div>
                        <div class="action-wrapper-button">
                            <a href="https://www.jenius.com/cards" class="btn btn-primary homepage-primary-btn">Cari Tau
                                <span class="icon-button-action"><i class="fa fa-chevron-right"></i></span></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="wrapper-thumbnail-feature-homepage text-right">
                        <img src="https://assets.jenius.com/assets/2019/08/28054834/ecard.png" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- mobile section -->
    <section class="wrapper-homepage-feature-icon cards-section-homepage d-lg-none">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-6">
                    <div class="wrapper-features-homepage-detail vp-fadein">
                        <div class="wrapper-features-description-icon">
                            <h3>Belanja <i>online</i> pakai kartu debit</h3>
                        </div>
                        <div class="description-icon-features">
                            <p>Transaksi <i>online</i> gak kebablasan dengan<br />
                                kartu debit virtual</p>
                        </div>
                        <div class="action-wrapper-button">
                            <a href="https://www.jenius.com/cards" class="btn btn-primary homepage-primary-btn">Cari Tau
                                <span class="icon-button-action"><i class="fa fa-chevron-right"></i></span></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="wrapper-thumbnail-feature-homepage thumbnail-mobile-wrapper-homepage text-right">
                        <img src="https://assets.jenius.com/assets/2019/08/28054834/ecard.png" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- mobile section -->
    <section class="wrapper-homepage-feature-icon grey-section-bg d-none d-lg-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="wrapper-thumbnail-feature-homepage text-right">
                        <img src="https://assets.jenius.com/assets/2019/08/28054918/Untitled-4.png" class="img-fluid"
                            alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="wrapper-features-homepage-detail vp-fadein" style="padding-left:18%">
                        <div class="wrapper-features-description-icon">
                            <h3>Mudah cairkan dana sesukamu</h3>
                        </div>
                        <div class="description-icon-features">
                            <p>Siap kapan pun untuk kebutuhan apa pun<br />
                                dengan dana siaga yang disiapkan untukmu</p>
                        </div>
                        <div class="action-wrapper-button">
                            <a href="https://www.jenius.com/app/fund/flexi-cash"
                                class="btn btn-primary homepage-primary-btn">Cari Tau <span
                                    class="icon-button-action"><i class="fa fa-chevron-right"></i></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Mobile section -->
    <section class="wrapper-homepage-feature-icon grey-section-bg d-lg-none">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-6">
                    <div class="wrapper-features-homepage-detail vp-fadein">
                        <div class="wrapper-features-description-icon">
                            <h3>Mudah cairkan dana sesukamu</h3>
                        </div>
                        <div class="description-icon-features">
                            <p>Siap kapan pun untuk kebutuhan apa pun<br />
                                dengan dana siaga yang disiapkan untukmu</p>
                        </div>
                        <div class="action-wrapper-button">
                            <a href="https://www.jenius.com/app/fund/flexi-cash"
                                class="btn btn-primary homepage-primary-btn">Cari Tau <span
                                    class="icon-button-action"><i class="fa fa-chevron-right"></i></span></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="wrapper-thumbnail-feature-homepage thumbnail-mobile-wrapper-homepage text-right">
                        <img src="https://assets.jenius.com/assets/2019/08/28054918/Untitled-4.png" class="img-fluid"
                            alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Mobile section -->
    <section class="blue-belt-homepage-section blue-section d-none d-lg-block">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <img src="https://assets.jenius.com/assets/2019/08/27121228/Arrow-Down.png" class="arrow-class-belt"
                        width="35" alt="">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h4 class="light"><a class="white-text" href="https://www.jenius.com/selamatdatang">
                            <p><span style="text-decoration: none !important;">Temukan langkah awal mengatur keuanganmu
                                    dengan Jenius</span></p>
                        </a></h4>
                </div>
            </div>
        </div>
    </section>
    <!-- Mobile section -->
    <section class="blue-belt-homepage-section blue-section d-lg-none">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <img src="https://assets.jenius.com/assets/2019/08/27121228/Arrow-Down.png" class="arrow-class-belt"
                        width="40" alt="">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="mobile-blue-belt-homepage">
                        <h4 class="light"><a class="white-text" href="https://www.jenius.com/selamatdatang">
                                <p><span style="text-decoration: none !important;">Temukan langkah awal mengatur
                                        keuanganmu dengan Jenius</span></p>
                            </a></h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Mobile section -->
    <section class="bottom-purple-section-homepage purple-section d-none d-lg-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-5">
                    <div class="image-thumbnail-botton-homepage">
                        <img src="https://assets.jenius.com/assets/2019/08/28055051/last.png" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="heading-bottom-purple">
                        <h5>
                            <h5 class="text-center">Keamananmu yang utama</h5>
                        </h5>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="wrapper-description-foot">
                        <article class="light">
                            <p>Untuk kenyamanan dan keamananmu<br />
                                Jenius menggunakan sistem enkripsi terbaru dan autentikasi transaksi dua tingkat</p>
                            <p>Jenius merupakan bagian dari PT Bank BTPN Tbk yang terdaftar/diawasi Otoritas Jasa
                                Keuangan (OJK) dan dijamin Lembaga Penjamin Simpanan (LPS)</p>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Mobile section -->
    <section class="bottom-purple-section-homepage purple-section d-lg-none">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="heading-bottom-purple mobile-bottom-title-homepage">
                        <h5>
                            <h5 class="text-center">Keamananmu yang utama</h5>
                        </h5>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5">
                    <div class="image-thumbnail-botton-homepage mobile-thumbnail-bottom-homepage">
                        <img src="https://assets.jenius.com/assets/2019/08/28055051/last.png" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 text-center">
                    <div class="wrapper-description-foot text-center">
                        <article class="light mobile-article-homepage">
                            <p>Untuk kenyamanan dan keamananmu<br />
                                Jenius menggunakan sistem enkripsi terbaru dan autentikasi transaksi dua tingkat</p>
                            <p>Jenius merupakan bagian dari PT Bank BTPN Tbk yang terdaftar/diawasi Otoritas Jasa
                                Keuangan (OJK) dan dijamin Lembaga Penjamin Simpanan (LPS)</p>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="row-top">
            <div class="container container-desktop">
                <div class="row">
                    <div class="col-md-4">
                        <div class="menu-get-jenius clearfix">
                            <div class="container container-mobile">
                                <h3>Get Jenius App </h3>
                                <div class="footer-download-btn-group" id="apps-link">
                                    <a rel="nofollow"
                                        href="https://app.appsflyer.com/id1079340119?pid=jenius.com&c=2018Footer&af_sub1=2ea7c5fd-4df9-4c69-806c-f7f9d3f75b65"
                                        target="_blank"><img
                                            src="https://www.jenius.com/assets/img/common/button_appstore.jpg"
                                            class="img-fluid"></a>
                                    <a rel="nofollow"
                                        href="https://app.appsflyer.com/com.btpn.dc?pid=jenius.com&c=2018Footer&af_sub1=29575cae-f834-497d-8f5c-9ef33ff33deb"><img
                                            src="https://www.jenius.com/assets/img/common/button_playstore.jpg"
                                            target="_blank" class="img-fluid"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="menu-top">
                            <div class="container container-mobile">
                                <div class="row">
                                    <div class="col-6 col-sm-4 col-md-12">
                                        <a href="https://www.jenius.com/locations">Location</a>
                                    </div>
                                    <div class="col-6 col-sm-4 col-md-12" id="navJoinOurTeam">
                                        <a href="https://www.jenius.com/join-our-team">Join Our Team</a>
                                    </div>
                                    <div class="col-6 col-sm-4 col-md-12" id="navRatesLimits">
                                        <a href="https://www.jenius.com/rates-and-limits">Rates & Limits</a>
                                    </div>
                                    <div class="col-6 col-sm-4 col-md-12">
                                        <a href="https://www.jenius.com/dictionary">Dictionary</a>
                                    </div>
                                    <div class="col-6 col-sm-4 col-md-12">
                                        <a href="https://www.cocreate.id/" target="_blank">Co.Create</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row-middle">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="footer-download-btn-group d-none d-md-block">
                            <a rel="nofollow"
                                href="https://app.appsflyer.com/id1079340119?pid=jenius.com&c=2018Footer&af_sub1=fe59a70e-3866-4989-9563-621cdb702862"
                                target="_blank"><img src="https://www.jenius.com/assets/img/common/button_appstore.jpg"
                                    class="img-fluid mb-2"></a>
                            <a rel="nofollow"
                                href="https://app.appsflyer.com/com.btpn.dc?pid=jenius.com&c=2018Footer&af_sub1=e6f93988-79c5-43ab-a01a-4752f89b375d"
                                target="_blank"><img src="https://www.jenius.com/assets/img/common/button_playstore.jpg"
                                    class="img-fluid mb-2"></a>
                            <a rel="nofollow" href="https://2secure.jenius.co.id/" target="_blank"><img
                                    src="https://www.jenius.com/assets/img/common/button_web.png"
                                    class="img-fluid mb-2"></a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="footer-socmed">
                            <a rel="nofollow" href="https://www.facebook.com/Jenius-Connect-1135565789809986/"
                                target="_blank"><i class="fab fa-facebook-f circle-icon mb-2"></i></a>
                            <a rel="nofollow" href="https://twitter.com/JeniusConnect" target="_blank"><i
                                    class="fab fa-twitter circle-icon mb-2"></i></a>
                            <a rel="nofollow" href="https://www.instagram.com/jeniusconnect/" target="_blank"><i
                                    class="fab fa-instagram circle-icon mb-2"></i></a>
                            <a rel="nofollow" href="https://www.youtube.com/channel/UCyvVocpwD4C6yzjmNw4ecSw"
                                target="_blank"><i class="fab fa-youtube circle-icon mb-2"></i></a>
                            <a rel="nofollow" href="tel:1500365" target="_blank"><i
                                    class="icon-telephone circle-icon mb-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row-bottom">
            <div class="container container-desktop">
                <div class="row">
                    <div class="col-md-6 col-lg-7">
                        <div class="footer-credit">
                            <div class="container container-mobile">
                                <div class="row">
                                    <div class="col-3 col-md-3 col-lg-3">
                                        <a rel="nofollow" href="https://www.btpn.com/" target="_blank">
                                            <img src="https://www.jenius.com/assets/img/brand/logo-mobile.png"
                                                class="img-fluid d-block d-md-none" alt="Logo BTPN">
                                            <img src="https://www.jenius.com/assets/img/brand/logo-dekstop.png"
                                                class="img-fluid d-none d-md-block" alt="Logo BTPN">
                                        </a>
                                    </div>
                                    <div class="col-9 col-md-9 col-lg-9">
                                        <p class="p-0">PT Bank BTPN Tbk terdaftar dan diawasi oleh Otoritas Jasa
                                            Keuangan (OJK) serta dijamin oleh Lembaga Penjamin Simpanan (LPS).</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5">
                        <div class="menu-bottom">
                            <div class="container container-mobile">
                                <ul>
                                    <li id="navPrivacyPolicy">
                                        <a href="https://www.jenius.com/privacy-policy">Privacy Policy</a>
                                    </li>
                                    <li id="navTermsandConditions">
                                        <a href="https://www.jenius.com/terms-and-condition">Terms & Conditions</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Search Modal-->
        <input type="hidden" value="https://www.jenius.com/" id="api_url" />
        <div class="modal modal-search fade" id="modalSearch" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div class="form-support-search search-custom">
                            <input type="text" name="" class="form-control" id="search-input"
                                placeholder="Cari Pertanyaanmu disini?" autofocus="autofocus">
                            <button class="ic-search">
                                <i class="far fa-search"></i>
                            </button>
                            <div id="result-content">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div id="jenius-banner" class="fixed-bottom"></div>
    <!--Pop Up-->
    <div class="m-popup-help">
        <a href="javascript:void(0)" class="close-help JS__close-help">
            <i class="fal fa-times"></i>
        </a>
        <div class="section-top">
            <div class="text">
                <p>Get Help</p>
            </div>
            <div class="img">
                <img src="https://assets.jenius.com/assets/2019/02/21123343/bg-help.png" alt="Chat Image">
            </div>
        </div>
        <div class="section-bot">
            <ul>
                <li>
                    <a href="tel:1500365" target="_blank">
                        <i class="icon-telephone"></i>
                        <span>Call Us 1500 365</span>
                    </a>
                </li>
                <li>
                    <a href="mailto:jenius-help@btpn.com" target="_blank">
                        <i class="fal fa-envelope"></i>
                        <span>Email Us</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="setGoogleAnaliticsChatClick();openChat();">
                        <i class="fal fa-comments"></i>
                        <span>Chat Now</span>
                    </a>
                </li>
            </ul>
            <div class="help-connect">
                <h3>Connect with Jenius</h3>
                <div class="help-connect-social">
                    <a href="https://www.facebook.com/Jenius-Connect-1135565789809986/" target="_blank">
                        <span class="fab fa-facebook"></span>
                    </a>
                    <a href="https://twitter.com/JeniusConnect" target="_blank">
                        <span class="fab fa-twitter"></span>
                    </a>
                    <a href="https://www.instagram.com/jeniusconnect/" target="_blank">
                        <span class="fab fa-instagram"></span>
                    </a>
                    <a href="https://www.youtube.com/channel/UCyvVocpwD4C6yzjmNw4ecSw" target="_blank">
                        <span class="fab fa-youtube"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    @include(Helper::setExtendFrontend('js'))
</body>

</html>