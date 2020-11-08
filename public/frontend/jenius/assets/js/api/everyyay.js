// App Feature Box
$(document).ready(function() {
    $('.module-benefit').slick({
      dots: false,
      infinite: true,
      slidesToShow: 3,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      responsive: [
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: true
          }
        }
      ]
    });
    
    $('.container > ul > li > .nav-link').click(function() {
        $('.nav-link-li').removeClass('active');
        $(this).parent().addClass('active');
    });

    $('.dropdown-menu-jenius > .dropdown-item > .nav-link').click(function(){
      $('.dropdown-item').removeClass('active');
      $(this).parent().addClass('active');
      $('#select-value').html($(this).text());
    });
    
    $('.nav-link').on('click',function(e){
    $('.dropdown-menu-jenius').hide();
    
    var str = $(this).text();
    var search = 'SEARCH / * WHERE(LCASE(promo_id) like "%'+str.toLowerCase()+'%") \
                RETURN(title, date, slug, promo_id, description_id, image_id, content_id, valid_id, background_color_id) \
                FROM ?';
                
    $.get( API_URL+'?url=everyyay', function( data ) {
        
        var datas = JSON.parse(data);
        var id = datas.id;
        
        var res = alasql(search, [id]);
        
        var limit = 12;
 
        var qty_pages = Math.ceil(res / limit);
        
        $('#pagination-control').empty();

        if(str == 'All Promo'){
        window.location.reload();
        }
        
        $('.everyyay-list').remove();
        if(res.length > 0){
        if(qty_pages){
            $('#pagination-control').append('<li class="page-item"><a class="page-link page-link-angle angle-left" href="/everyyay/index.php?page='+(i-1)+'"><i class="fal fa-angle-left"></i></a></li>');
            for(var i=1 ; i <= qty_pages; i++){
                $('#pagination-control').append('<li class="page-item '+(i === 0 ? 'active' : '' )+'"><a href="/everyyay/index.php?page='+i+'" class="page-link">'+i+'</a></li>');
            };+
            $('#pagination-control').append('<li class="page-item"><a class="page-link page-link-angle angle-right" href="/everyyay/index.php?page='+(i+1)+'"><i class="fal fa-angle-right"></i></a></li>');
        }   
        
        res.map((everyyay, index)=>{  
            e.stopPropagation();
            $('.everyyay-row').append(
            '<div class="col-12 col-md-4 col-xl-4 everyyay-list">'+
                '<a href="/everyyay/details?p='+everyyay.slug+'" class="promo-item animated fadeInUp" style="background: '+everyyay.background_color_id+'">'+
                '<div class="row row-0">'+
                    '<div class="col-5 col-md-12">'+
                    '<div class="promo-img">'+
                        '<img src="'+everyyay.image_id+'" class="img-fluid" style="width: 100%;" alt="Promo Every Yay">'+
                    '</div>'+
                    '</div>'+
                    '<div class="col-7 col-md-12">'+
                    '<div class="promo-content">'+
                        '<h4>'+everyyay.promo_id+': '+everyyay.title+'</h4>'+
                        '<p>'+everyyay.description_id+'</p>'+
                    '</div>'+
                    '</div>'+
                '</div>'+
                '</a>'+
            '</div>'
            );
            
        })
        }else{
        $('.everyyay-row').html('&nbsp;');
        }
    });
    });
    
  });
