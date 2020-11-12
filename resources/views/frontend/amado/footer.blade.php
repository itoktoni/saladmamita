<!-- ##### Footer Area Start ##### -->
<footer class="footer_area">
    <div class="container" style="color: whitesmoke;">
        <div class="row align-items-center">
            <!-- Single Widget Area -->
            <div class="col-8 col-lg-8">
                <div class="single_widget_area">
                    <!-- Footer Menu -->
                    <div class="footer_menu">
                        {{ config('website.address') }}
                    </div>
                </div>
            </div>
            <div class="col-3 col-lg-3">
                <div class="single_widget_area">
                    <!-- Footer Menu -->
                    <div class="footer_menu">
                        @foreach($page as $p)
                        <ol class="row">
                            <li class="col-md-12">
                                - <a style="color:whitesmoke;font-weight: lighter;" href="{{ route('page', ['slug' => $p->marketing_page_slug]) }}">{{ Ucfirst($p->marketing_page_name) }}</a>
                            </li>
                        </ol>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- ##### Footer Area End ##### -->