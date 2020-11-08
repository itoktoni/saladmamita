// Animation on load
document.addEventListener("DOMContentLoaded", function(event) {
    $(".loader").fadeOut('slow');
    $(".loader-wrapper").fadeOut("slow");
    // $(".anim-1").addClass("animated fadeInLeft delayp10");
    // $(".anim-2").addClass("animated fadeInUp delayp12");
    // $(".anim-3").addClass("animated fadeInUp delayp14");  
    $('.dropdown-toggle').dropdown();
    });

    // Testimonials
    $(document).ready(function() {
    $('.slider-home-main-banner').not('.slick-initialized').slick({
        slidesToShow: 1,
        dots: true,
        fade: true,
        autoplay: true,
        autoplaySpeed: 6000,
    });

    $('.slider-home').not('.slick-initialized').slick({
        slidesToShow: 1,
        dots: true,
        fade: true,
        autoplay: true,
        autoplaySpeed: 6000,
    });

    $('.testimonials-list').not('.slick-initialized').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
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
    $('.artikel-slide').not('.slick-initialized').slick({
        responsive: [
        {
            breakpoint: 992,
            settings: {
                slidesToShow: 1.2,
                infinite: false,
                dots: false
            }
        }
        ]
    });
    });

    window.FontAwesomeConfig = {
    searchPseudoElements: true
    }
    
    $(".selection-value").click(function(e) {
        
        $('#select-value').html(e.target.dataset.value);
        $('#select-link').attr('href', e.target.dataset.url);
    })