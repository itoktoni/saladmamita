function startSlick() {  
    $('.slider').slick({
        slidesToShow: 1,
        dots: true,
        fade: true,
        autoplay: true,
        autoplaySpeed: 6000,
    });
}

function startTestimonialSlick(){
    $('.testimonials-list > .row').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        // autoplay: true,
        // autoplaySpeed: 2000,
        dots: false,
        responsive: [
            {
            breakpoint: 992,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true,
                dots: true
            }
            }
        ]
    });
}

$(document).ready(function() {

    var settings = {
      "async": true,
      "crossDomain": true,
      "url": API_URL+'/home',
      "method": "GET",
      "headers": {}
    }

    $.ajax(settings).done(function (response) {
        console.log(JSON.parse(response));
        data = JSON.parse(response);
        
        //home banner id
        data.main_banner.id.map((data, index)=>{
            $('#home_banner').append(
                '<div>'+
                    '<div class="container">'+
                        '<div class="row row-3 cover-home-content">'+
                        '<div class="col-md-6 col-lg-7 order-md-last">'+
                            '<div class="heading">'+
                            '<h2 class="cover-title animated fadeInUp delayp2">'+data.title_id+'</h2>'+
                            '<p class="cover-text mb-3 animated fadeInUp delayp3">'+data.subtitle_id+'</p>'+
                            '</div>'+
                            '<div class="home-download-btn-group animated fadeInUp delayp4 clearfix">'+        
                            '<a href="'+data.apple_store_id+'">'+
                                '<img src="assets/img/common/button_appstore.jpg" class="img-fluid app-store float-left mr-3" alt="App Store" />'+
                            '</a>'+
                            '<a href="'+data.google_play_id+'">'+
                                '<img src="assets/img/common/button_playstore.jpg" class="img-fluid google-store float-left" alt="Google Play Store"/>'+
                            '</a>'+
                            '</div>'+  
                            '<div class="home-action-btn-group animated fadeInUp delayp5">'+
                            '<a data-fancybox href="'+data.video_link_id+'" class="btn btn-video clearfix">'+
                                '<img src="assets/img/common/ic_circle-play.svg" alt="Icon Play">'+
                                '<span>Cari tahu lebih lanjut</span>'+
                            '</a>'+
                            '<a href="#" class="btn-home-ribbon clearfix animated fadeInRight delayp6">'+
                                '<img src="assets/img/common/ic_idea.svg" alt="Icon">'+
                                '<span>Ingin tau cara buat akun jenius?</span>'+
                                '<img src="assets/img/common/ic_arrow-right.svg" class="img-home-arrow" alt="Icon Play">'+
                            '</a>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-6 col-lg-5 order-md-first">'+
                            '<div class="cover-home-img animated fadeInUp">'+
                            '<img src="'+data.image_id+'" class="img-fluid" alt="Banner Image"/>'+
                            '</div>'+
                        '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>'
            );
        });

        //Home Headline
        data.main_headlines.id.map((data, index)=>{
            $('#home_headlines').append(
                '<div>'+
                    '<h4 class="animated fadeInUp">Dengan Jenius, sekarang kamu bisa</h4>'+
                    '<h2 class="animated fadeInUp">'+data.title_id+'</h2>'+
                    '<a href="'+data.url_id+'" class="btn btn-link-w-chevron mt-3 animated fadeInUp delayp3">Cari Tau Lebih Lanjut <i class="fal fa-angle-right"></i></a>'+
                '</div>'
            );
        });

        //Home Middle Banner
        data.middle_banners.id.map((data, index)=>{
            $('#carousel_indicator').append(
                '<li data-target="#carouselCover" data-slide-to="'+index+'" class="'+(index == 0 ? 'active': '')+'">'+data.subtitle_id+'</li>'
            );

            $('#middle_banners').append(
                '<div class="carousel-item '+(index == 0 ? 'active': '')+'" style="background: '+data.background_color_id+';">'+
                    '<div class="container justify-content-center">'+
                    '<div class="w-100">'+
                        '<div class="row">'+
                        '<div class="col-md-6 text-center">'+
                            '<img src="'+data.image_id+'" class="img-fluid animated fadeInUp delayp1" alt="'+data.title_id+'">'+
                        '</div>'+
                        '<div class="col-md-6 content-container">'+
                            '<div class="content">'+
                            '<h2 class="animated fadeInUp delayp2">'+data.title_id+'</h2>'+
                            '<p class="animated fadeInUp delayp3">'+data.content_id+'</p>'+
                            '<a href="'+data.url_id+'" class="btn-circle-chevron-w-link animated fadeInUp delayp4">'+
                                '<div>'+
                                '<i class="fal fa-angle-right"></i>'+
                                '</div> Lebih Lanjut'+
                            '</a>'+
                            '</div>'+
                        '</div>'+
                        '</div>'+
                    '</div>'+
                    '</div>'+
                '</div>'
            )
        });

        //Home Testimonial
        data.testimonials.id.map((data, index)=>{
            var rating = data.rating_id;
            var star;
            if(rating == "5"){
                star = '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
            }else if(rating == "4"){
                star = '<i class="fas fa-star""></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>';
            }else if(rating == "3"){
                star = '<i class="fas fa-star""></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
            }else if(rating == "2"){
                star = '<i class="fas fa-star""></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
            }else if(rating == "1"){
                star = '<i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
            }

            $('#testimonial').append(
                '<div class="col-lg-4">'+
                    '<div class="testimonials-item vp-fadeinup">'+
                        '<!--Testimonial Mobile (Copy)-->'+
                        '<div class="testimonials-content d-block d-lg-none">'+
                            '<div class="testimonials-header">'+
                                '<div class="testimonials-img"><img src="'+data.image_id+'" class="img-fluid" alt="Testimonial Image"></div>'+
                                    '<p class="testimonial-name">'+data.name_id+'</p>'+
                                    '<small class="testimonial-username">'+data.username_id+'</small>'+
                                    '<div class="rating">'+
                                        star+
                                    '</div>'+
                                '</div>'+
                            '<div class="testimonials-footer">'+
                                '<p class="testimonial-text">'+data.text_id+'</p>'+
                            '</div>'+
                        '</div>'+
                        '<!--Testimonial Desktop (Copy)-->'+
                        '<div class="testimonials-content d-none d-lg-flex">'+
                            '<div class="testimonials-header">'+
                                '<div class="testimonials-img">'+
                                    '<img src="'+data.image_id+'" class="img-fluid" alt="Testimonial Image">'+
                                '</div>'+
                                '<p class="testimonial-text">'+data.text_id+'</p>'+
                            '</div>'+
                            '<div class="testimonials-footer">'+
                                '<div class="rating">'+
                                    star+
                                '</div>'+
                                '<p class="testimonial-name">'+data.name_id+'</p>'+
                                '<small class="testimonial-username">'+data.username_id+'</small>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>'
            )
        });

        //bottom navigator
        data.bottom_navigator.id.map((data, index)=>{
            $('#bottom-navigator').append(
                '<div class="selection-value-'+index+' dropdown-item" data-url="'+data.url_id+'">'+data.title_id+'</div>'
            );

            if(index == 0){
                //$('.selection-value-0').load(function(e){
                    $('#select-link').attr('href', data.url_id);
                //});
            }

            $('.selection-value-'+index).click(function(e){
                $('#select-value').html(data.title_id);
                $('#select-link').attr('href', e.target.dataset.url);
            })
        });

        $('.vp-fadeinup').viewportChecker({
            classToAdd: 'visible animated fadeInUp',
            offset: 100
        });

        startSlick();
        startTestimonialSlick();
    });
});