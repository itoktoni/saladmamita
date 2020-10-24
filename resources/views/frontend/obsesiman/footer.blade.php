 <footer id="contact" class="footer ftco-section ftco-no-pb">
     <div class="container ">
         <div class="row mb-5 pb-1">
             <div class="col-md-6 col-lg ">
                 <div class="ftco-footer-widget mb-4 ">
                     <h2 class="logo ">
                         <a href="{{ config('app.url') }}">
                             <img class="logo" src="{{ Helper::files('logo/'.config('website.logo')) }}" alt="">
                         </a>
                     </h2>
                     <p>
                         {{ config('website.description') }}
                     </p>
                     <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-4 ">
                         @foreach($sosmed as $sos)
                         <li class="ftco-animate ">
                             <a target="_blank" href="{{ $sos->marketing_sosmed_link }}">
                                 <span class="fa fa-{{ $sos->marketing_sosmed_icon }} "></span>
                             </a>
                         </li>
                         @endforeach
                     </ul>
                 </div>
             </div>
             <div class="col-md-6 col-lg ">
                 <div class="ftco-footer-widget mb-4 ml-md-5 ">
                     <h2 class="ftco-heading-2 ">Services</h2>
                     <ul class="list-unstyled ">
                         @foreach($service as $sec)
                         <li>
                             <a href="# " class="py-1 d-block ">
                                 <span class="fa fa-check mr-3 "></span>
                                 {{ $sec->marketing_service_name }}
                             </a>
                         </li>
                         @endforeach
                     </ul>
                 </div>
             </div>
             
             <div class="col-md-6 col-lg ">
                 <div class="ftco-footer-widget mb-4 ">
                     <h2 class="ftco-heading-2 ">Business Address</h2>
                     <div class="opening-hours ">
                         <h4>Opening Days:</h4>
                         <p class="pl-3 ">
                             <span>Monday – Friday : 9am to 20 pm</span>
                         </p>
                         <h4>Address:</h4>
                         <p class="pl-3 ">
                             <span>{{ config('website.address') }}</span>
                             <br>
                             Phone : <span>{{ config('website.phone') }}</span>
                             <br>
                             Email : <span>{{ config('website.email') }}</span>
                             <br>

                         </p>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </footer>