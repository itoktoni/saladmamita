$(document).ready(function() {
    var $window = $(window);  
    var $sidebar = $(".social-media-fixed"); 
    var $sidebarHeight = $sidebar.innerHeight();   
    var $footerOffsetTop = $("footer").offset().top; 
    var $sidebarOffset = $sidebar.offset();

    $window.scroll(function() {
        if($window.scrollTop() > $sidebarOffset.top) {
        $sidebar.addClass("fixed");   
        } else {
        $sidebar.removeClass("fixed");   
        }    
        if($window.scrollTop() + $sidebarHeight > $footerOffsetTop) {
        $sidebar.css({"top" : -($window.scrollTop() + $sidebarHeight - $footerOffsetTop)});        
        } else {
        $sidebar.css({"top": "0",});  
        }    
    });
    $('.slider-highlight').slick({
        dots: false,
        arrow: true,
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
          {
            breakpoint: 1025,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 1,
              dots: true,
              arrows: false,
            }
          },
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1,
              dots: true,
            }
          },
          {
            breakpoint: 750,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              dots: true,
            }
          }
        ],
        init: function(){
          if (a2a) {
            a2a.init_all();
          }
        }
    });
});