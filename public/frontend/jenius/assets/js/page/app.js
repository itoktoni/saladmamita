function createSlick(){
    $('.slider-nav').slick({
        slidesToShow: 1.5,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        focusOnSelect: true,
        centerMode: true,
        infinite: false,
        dots: true
    });

    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: false,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav',
        infinite: false
    });
}

function destroyCarousel() {
    if ($('.slider-nav').hasClass('slick-initialized')) {
      $('.slider-nav').slick('unslick').slick('reinit');
    } 
    
    if ($('.slider-for').hasClass('slick-initialized')) {
        $('.slider-for').slick('unslick').slick('reinit');
    }
}


function getTutorial(id, key, slug1, $slug2){    
    $.ajax({
        type: "GET",
        url:  $('#base_url').val()+'app_ajax/'+slug1+'/'+$slug2+'/'+id+'/'+key,
        beforeSend: function(){   
            destroyCarousel();
            $('.slider-nav').empty();
            $('.slider-for').empty();
        },
        success: function(response){
            
            var data = JSON.parse(response);
            if(data){
                $.each( data.image, function( key, value ) {
                    $('.slider-nav').append(
                        '<div>'+
                            '<img data-src="'+value+'" alt="">'+
                        '</div>'
                    )
                });

                $.each( data.slider_for.content, function( key, value ) {

                    $('.slider-for').append(
                        '<div>'+
                            '<div class="row">'+
                                '<div class="col-md-6">'+
                                    '<div class="mockup-content">'+
                                        '<h3>'+ $('#langkah_langkah').val() +' '+(key+1)+'</h3>'+
                                        '<p>'+value+'</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-6">'+
                                    '<img data-src="'+data.slider_for.image_with_phone[key]+'" alt="">'+
                                '</div>'+
                            '</div>'+
                        '</div>'
                    )
                });
            }
        },
        complete: function(response){
            createSlick();
            if (lazyLoadInstance) {
                lazyLoadInstance.update();
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(errorThrown);
        }
    });
}

getTutorial($('#id_tutorial').val(), 1, $('#slug1').val(), $('#slug2').val());

$(document).ready(function () {

    $('.tutorial').click(function(e) {
        $('.tutorial.selected').removeClass('selected');
        var $this = $(this);
        if (!$this.hasClass('selected')) {
            $this.addClass('selected');
        }
        e.preventDefault();
    });

    $('.owl-carousel').owlCarousel({
        loop: false,
        margin: 30,
        responsive:{
          0:{
            items: 10
          },
          768:{
              items: 2
          },
          992:{
              items: 3
          }
        }
    });

    var feature_image = {
        container: document.getElementById('AppIndex'),
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: $('#image_json').val()
    };
    
    bodymovin.loadAnimation(feature_image);


    $('.image_json_left').each(function(i){
      var id = $(this).data('id');
      
      var app_image_left = {
          container: document.getElementById('app-anim-left-'+id),
          renderer: 'svg',
          loop: true,
          autoplay: true,
          path: $('#image_json_left_'+id).val()
      };

      bodymovin.loadAnimation(app_image_left);
      
    });
    
    $('.image_json_right').each(function(i){
        var id = $(this).data('id');
        var app_image_right = {
            container: document.getElementById('app-anim-right-'+id),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: $('#image_json_right_'+id).val()
        };

        bodymovin.loadAnimation(app_image_right);
        
      });
    $('.app-feature-box-content').not('.slick-initialized').slick({
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
            dots: true,
            infinite: false,
            }
        }
        ]
    });

    let fcyUrl = base_url + "cards/foreign-currency";
    if (window.location == fcyUrl ) {
        $('.dropdown-menu').css('display', 'none');
        $('.navbar-app a ').css('display', 'none');
        $('.navbar-app img ').css('display', 'none');
    } else {
        $('.dropdown-menu').css('display', 'visible');
        $('.navbar-app a ').css('display', 'visible');
        $('.navbar-app img ').css('display', 'visible');
    }
    console.log(fcyUrl);
    
}); 