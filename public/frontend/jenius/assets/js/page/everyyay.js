//filter function
var selectedLabels = [];
var searchKeyword = '';

$(document).ready(function() {
  //Fire it when the page first loads:
  navTransparent();

  everyyayGet();

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
  });
});

$(window).resize(function(){
  navTransparent();
});

// Toogle Check
$(".form-check-label").click(function() {
  $(this).toggleClass("active");  
  setSelectedLabels($(this).data('label'));
  everyyayGet(searchKeyword,selectedLabels);
});

// Toogle Uncheck
$(document).on('click', ".form-uncheck-location", function() {
  const item = $(this).data('label');
  $('.form-check-label[data-label="'+item+'"]').toggleClass("active");
  setSelectedLabels(item);
  everyyayGet(searchKeyword,selectedLabels);
});

$("#search-everyyay").keypress(function(e){
  if(e.keyCode == 13){
    everyyayGet(searchKeyword,selectedLabels);
  }
});

$("#search-everyyay").keyup(function(e){
  searchKeyword = $(this).val();
});

function setSelectedLabels(label){
  const isInArray = selectedLabels.find(function(item){return item == label});
  if(isInArray){
    selectedLabels.splice( selectedLabels.indexOf(label), 1 );
  }else{
    selectedLabels.push(label);
  }
  $("#result-lables-container").empty();
  selectedLabels.map(function(item, index){
    $("#result-lables-container").append('<span class="btn btn-label mr-3 form-uncheck-location" data-label="'+item+'" >#'+item+' <i class="fas fa-times" id="filter-close" ></i></span>');
  });
}

var navTransparent = function() {
  var windowWidth = document.body.clientWidth;
  if (windowWidth < 520 && !$('.navbar-jenius').hasClass('navbar-transparent')) {
    $('.navbar-jenius').addClass('navbar-transparent');
    $('.navbar .logo').attr('src',$('#base_url').val()+'assets/img/brand/logo_jenius-white.svg');
  }
};

function everyyayFilter(keyword, labels){
  $.ajax({
    type: "POST",
    url:  $('#base_url').val()+'everyyay/get_everyyay_ajax',
    data: {
      f_lang : $('#lang').val(),
      f_keyword: (keyword ? keyword : ''),
      f_labels: (labels ? labels : [])
    },
    beforeSend: function(){   
      $("#everyyay-list").empty();
    },
    success: function(response){
    },
    complete: function(response){
      var filter = JSON.parse(response.responseText);
      
      if(filter.post_count != 0){
        filter.sort(function(index){
          if (index.archived != 'on') {
            return -1;
          }else{
            return 1;
          }
          
        });
        
        everyyayGet(filter);
      }else{
        generateResultNull();
      }
      
      
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(errorThrown);
    }
  });
}

function generateResultNull(){
  $('#pagination-place').empty();
  $("#everyyay-list").html('<div class="w-100 text-center">No Result Found</div>');
}

function everyyayGet(keyword, labels){
  $.ajax({
    type: "POST",
    url:  $('#base_url').val()+'everyyay/get_everyyay_count/',
    data: {
      f_lang : $('#lang').val(),
      f_keyword: (keyword ? keyword : ''),
      f_labels: (labels ? labels : [])
    },
    beforeSend: function(){   
      $('#everyyay-list').empty();
    },
    success: function(response){
        // generateResult(response);
    },
    complete: function(response){
      var count = JSON.parse(response.responseText);
      
      generateResult(count, keyword, labels);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(errorThrown);
    }
  });
}

function generateResult(totalNumber, keyword, labels){
  if(totalNumber != 0) {
    const dataSourceUrl = $('#base_url').val()+'everyyay/get_everyyay_ajax?lang='+$('#lang').val()+'&keyword='+(keyword ? encodeURIComponent(keyword) : '')+'&labels='+(labels ? encodeURIComponent(labels) : []);
    $('#pagination-place').pagination({
      dataSource: dataSourceUrl ,
      locator: 'data',
      alias:{
        pageNumber: 'page_num',
        pageSize: 'limit'
      },
      totalNumber: totalNumber,
      pageSize: 12,
      pageRange: 1,
      showPrevious: true,
      showNext: true,
      inlineStyle: false,
      classPrefix :'page-item active',
      className: 'pagination-container clearfix',
      ulClassName: 'pagination vp-fadeinup visible animated fadeInUp full-visible',
      activeClassName: 'active',
      prevText :'<i class="fal fa-angle-left"></i>',
      nextText :'<i class="fal fa-angle-right"></i>',
      callback: function(data, pagination) {
        $('#everyyay-list').empty();
        
        if(totalNumber < 12){
          $('#pagination-place').addClass('hidden')
        }else{
          $('#pagination-place').removeClass('hidden')
        }
        data.map(function(item, key){
          if(item.archived != 'Yes'){
            $("#everyyay-list").append('<div class="col-12 col-md-4 col-xl-4 everyyay-list">'+
              '<a href="'+$('#base_url').val()+'everyyay/details/'+item.slug+'" class="promo-item animated fadeInUp" style="background: '+item.background_color+';">'+
                '<div class="row row-0">'+
                    '<div class="col-5 col-md-12">'+
                        '<div class="promo-img">'+
                          '<img data-src="'+item.image+'" class="img-fluid" style="width: 100%;" alt="Promo Every Yay">'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-7 col-md-12">'+
                        '<div class="promo-content">'+
                          '<h4>'+item.title+'</h4>'+
                          '<p>'+item.description+'</p>'+
                          '<p class="d-none">'+item.days_category.join(", ")+'</p>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
              '</a>'+
            '</div>');
          }else{
            $("#everyyay-list").append('<div class="col-12 col-md-4 col-xl-4 everyyay-list">'+
              '<a class="promo-item animated fadeInUp" style="background: '+item.background_color+';">'+
                '<div class="row row-0">'+
                    '<div class="col-5 col-md-12">'+
                        '<div class="promo-img">'+
                          '<img data-src="'+item.image+'" class="img-fluid" style="width: 100%;" alt="Promo Every Yay">'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-7 col-md-12">'+
                        '<div class="promo-content">'+
                          '<h4>'+item.title+'</h4>'+
                          '<p>'+item.description+'</p>'+
                          '<p class="d-none">'+item.days_category.join(", ")+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="promo-archived">'+
                      '<span>Archived</span>'+
                    '</div>'+
                '</div>'+
              '</a>'+
            '</div>');
          }
          if (lazyLoadInstance) {
            lazyLoadInstance.update();
          }
        });  
      },
      afterInit: function(){
        if (a2a) {
          a2a.init_all();
        }
        
      },
      afterPaging: function(){
        if (a2a) {
          a2a.init_all();
        }
      },
      afterPageOnClick: function(){
        $(window).scrollTop($('.cover').height());
      },
      afterNextOnClick: function(){
        $(window).scrollTop($('.cover').height());
      },
      afterPreviousOnClick: function(){
        $(window).scrollTop($('.cover').height());
      }
    });
  } else {
    $('#pagination-place').empty();
    $("#everyyay-list").append('<div class="col-12">'+
      '<p class="text-center my-5">No results found</p>'+
    '</div>');
  }
  
}

//hide megamenu
$('#dropdown-megamenu').click(function(){
  $('#megamenu').toggle();
});

$(document).click(function(e){
  e.stopPropagation();
    var container = $('#megamenu');
    if (!container.is(e.target) && container.has(e.target).length === 0 && e.target.id != 'dropdown-megamenu') {
        container.hide();
    }
 });