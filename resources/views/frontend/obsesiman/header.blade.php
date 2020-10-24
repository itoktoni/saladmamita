 <div class="wrap">
     <div class="container">
         <div class="row justify-content-between">
             <div class="col-md-3 d-flex align-items-center">
                 <a class="navbar-brand" href="index.html">
                     <img class="logo" src="{{ Helper::files('logo/'.config('website.logo')) }}" alt="">
                 </a>
             </div>
             <div class="col-md-7">
                 <div class="row">
                     <div class="col">
                         <div class="top-wrap d-flex">
                             <div class="icon d-flex align-items-center justify-content-center"><span
                                     class="fa fa-location-arrow"></span></div>
                             <div class="text">
                                 <span>Email</span>
                                 <a href="mailto:{{ config('website.email') }}">
                                     <span>{{ config('website.email') }}</span>
                                 </a>
                             </div>
                         </div>
                     </div>
                     <div class="col">
                         <div class="top-wrap d-flex">
                             <div class="icon d-flex align-items-center justify-content-center"><span
                                     class="fa fa-location-arrow"></span></div>
                             <div class="text"><span>Call us</span><span>{{ config('website.phone') }}</span></div>
                         </div>
                     </div>
                     <div class="col-md-3 d-flex justify-content-end align-items-center">
                         <div class="social-media">
                             <p class="mb-0 d-flex">
                                 @foreach($sosmed as $med)
                                 <a href="{{ $med->marketing_sosmed_link }}"
                                     class="d-flex align-items-center justify-content-center">
                                     <span class="fa fa-{{ $med->marketing_sosmed_icon }}"><i
                                             class="sr-only">{{ $med->marketing_sosmed_name }}</i></span>
                                 </a>
                                 @endforeach
                             </p>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
     <div class="container">

         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
             aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
             <span class="fa fa-bars"></span> Menu
         </button>

         <div class="collapse navbar-collapse" id="ftco-nav">
             <ul class="navbar-nav mr-auto">
                 <li class="nav-item active"><a href="index.html" class="nav-link">Home</a></li>
                 <li class="nav-item"><a href="#about" class="nav-link">About</a></li>
                 <li class="nav-item"><a href="#service" class="nav-link">Services</a></li>
                 <li class="nav-item"><a href="#proses" class="nav-link">Proses</a></li>
                 <li class="nav-item"><a href="#testimoni" class="nav-link">Testimoni</a></li>
                 <li class="nav-item"><a href="#contact" class="nav-link">Contact</a></li>
             </ul>
         </div>
     </div>
 </nav>
 <!-- END nav -->