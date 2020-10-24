// Initiate Local Time
var base_url_loc = window.location.protocol + "//" + window.location.host + "/";
var now = new Date();
var hours = now.getHours();
var selectedLabels = [];
var searchKeyword = '';
var myLocation = {lat:-6.229757, lng:106.827432}; //Gedung BPTN
var map;
var iconType = {
   JeniusBooth: { iconMarker: base_url_loc+'assets/img/common/ic_location-blue.svg' },
   JeniusBranch: { iconMarker: base_url_loc+'assets/img/common/ic_location-purple.svg' },
   KantorPusat: { iconMarker: base_url_loc+'assets/img/common/ic_location-orange.svg' }
};
var maps = [];

// Navbar active state
$('#navLocations').addClass('active');

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

// Ready
$(document).ready(function(){
  getNearby();
  getMyLocation();
  locationFilter();
});

function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {
    center: myLocation,
    zoom: 15
  });

  Array.prototype.forEach.call(maps, function(markerElem) {
     var id = markerElem.id;
     var type = markerElem.type;
     var point = new google.maps.LatLng(
         parseFloat(markerElem.lat),
         parseFloat(markerElem.lng));
     var icon = iconType[markerElem.mapsType] || {};
     var marker = new google.maps.Marker({
         icon: icon.iconMarker,
         map: map,
         position: point
     });
   });
}

// Toogle Check
$(".form-check-label").click(function() {
  $(this).toggleClass("active");
  setSelectedLabels($(this).data('label'));
  locationFilter(selectedLabels, searchKeyword);
});

// Toogle Uncheck
$(document).on('click', ".form-uncheck-location", function() {
  const item = $(this).data('label');
  $('.form-check-label[data-label="'+item+'"]').toggleClass("active");
  setSelectedLabels(item);
  locationFilter(selectedLabels, searchKeyword);
});

$("#search-location").keypress(function(e){
 if(e.keyCode == 13){
  locationFilter(selectedLabels, searchKeyword);
 }
});

$("#search-location").keyup(function(e){
 searchKeyword = $(this).val();
});

function getMyLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position){
        myLocation = {lat: position.coords.latitude, lng: position.coords.longitude};
        console.log("Your Location is :", myLocation);
      });
    }else{
      console.log("Geolocation is not supported by this browser.");
    }
}


function locationFilter(labels, keyword){
  $.ajax({
    type: 'POST',
    url: $('#base_url').val()+'locations/get_location_count',
    data: {
      f_keyword: (keyword ? keyword : ''),
      f_labels: (labels ? labels : [])
    },
    beforeSend: function(){
      $('#locations-list').empty();     
    },
    success: function(response){
    },
    complete: function(response){
      var count = $.parseJSON(response.responseText);
      generateResult(count, keyword, labels);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(errorThrown);
    }
  });
}

function getNearby(){
  $.ajax({
    type: 'POST',
    url: $('#base_url').val()+'locations/get_nearby_ajax',
    data: {
      f_lat: myLocation.lat,
      f_lng: myLocation.lng
    },
    beforeSend: function(){
      maps = [];
    },
    success: function(response){
      var filter = $.parseJSON(response);

      filter.map(function(item,key){
        let itemMapsType = null;
        if(item.tag_id.find(function(tag){ return tag == "#JeniusBooth"})){
          itemMapsType = 'JeniusBooth';
        }else if(item.tag_id.find(function(tag) {return tag == "#JeniusBranch"})){
          itemMapsType = 'JeniusBranch';
        }else if(item.tag_id.find(function(tag) {return tag == "#KantorPusat"})){
          itemMapsType = 'KantorPusat';
        }else{
          itemMapsType = 'JeniusBooth';
        }
          maps.push({
            address: item.address,
            lat: item.lat,
            lng: item.lng,
            mapsType: itemMapsType,
            name: item.title
          });
          if(key <3){
            var openId = item.open_id;
            var closedId = item.closed_id;
            var status = hours >= openId && hours <= closedId ? "open" : "closed";
            var point1 = new google.maps.LatLng(parseFloat(myLocation.lat),parseFloat(myLocation.lng));
            var point2 = new google.maps.LatLng(parseFloat(item.lat),parseFloat(item.lng));
            var distance = Math.floor(google.maps.geometry.spherical.computeDistanceBetween(point1, point2));
            var tags = '';
         
            $.each(item.tag_id, function(index, tag){
              switch(tag){
                case "#JeniusBooth": 
                  tag = '<span class="text-primary">'+tag+'</span>';
                break;
                case "#JeniusBranch": 
                  tag = '<span class="text-purple">'+tag+'</span>';
                break;
                case "#KantorPusat": 
                  tag = '<span class="text-orange">'+tag+'</span>';
                break;
                default : 
                  tag = tag;
                break;
              }
              tags += tag+(item.tag_id[index+1] ? ', ' : '');
            });

            $('#nearby-top-tree').append('<div class="location-closest-list">'+
              '<div class="location-closest-item">'+
                '<h5 class="mb-0">'+item.location_title+'</h5>'+
                '<div class="time-label '+status+'">'+openId +' - '+closedId+'</div>'+
                '<span class="travel-distance">Est. '+distance+'m away</span>'+
                '<p class="services-label">'+(tags ? tags : '<br><br>')+'</p>'+
              '</div>'+
            '</div>');
        }
      });
    },
    complete: function(response){
      $('.slider-location-closest').slick({
      slidesToShow: 3,
      dots: false,
      arrow: false,
      infinite: false,
      autoplay: false,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 2,
            arrow: false,
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            arrow: false,
          }
        }
      ]
    });
      initMap();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(errorThrown);
    }
  });
}

function setSelectedLabels(label){
 const isInArray = selectedLabels.find(function(item){return item == label});
 if(isInArray){
   selectedLabels.splice(selectedLabels.indexOf(label), 1 );
 }else{
   selectedLabels.push(label);
 }
 $("#result-lables-container").empty();
 selectedLabels.map(function(item, index){
   $("#result-lables-container").append('<span class="btn btn-label mr-3 form-uncheck-location" data-label="'+item+'" >#'+item+' <i class="fas fa-times" id="filter-close" ></i></span>');
 });
}

function tagId(tag_id){
  var tags = ''
  $.each(tag_id, function(index, tag){
    switch(tag){
      case "#JeniusBooth": 
        tag = '<span class="text-primary">'+tag+'</span>';
      break;
      case "#JeniusBranch": 
        tag = '<span class="text-purple">'+tag+'</span>';
      break;
      case "#KantorPusat": 
        tag = '<span class="text-orange">'+tag+'</span>';
      break;
      default : 
        tag = tag;
      break;
    }
    tags += tag+(tag_id[index+1] ? ', ' : '');
   });

   return tags;
}

function generateResult(totalNumber, keyword, labels){
  if (totalNumber != 0) {
    const dataSourceUrl = $('#base_url').val()+'locations/get_location_ajax?f_keyword='+(keyword ? encodeURIComponent(keyword) : '')+'&f_labels='+(labels ? encodeURIComponent(labels) : []);
    $('#pagination-place').pagination({
      dataSource: dataSourceUrl,
      locator: 'data',
      alias:{
        pageNumber: 'page_num',
        pageSize: 'limit'
      },
      totalNumber: totalNumber,
      pageSize: 12,
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

        $('#locations-list').empty();
        $.each(data, function(index, item){
          var openId = item.open_id;
          var closedId = item.closed_id;
          var status = hours >= openId && hours <= closedId ? "open" : "closed";
          var tags = '';
          
          tags = tagId(item.tag_id);
  
          $('#locations-list').append(' <div class="row">'+
            '<div class="col-md-5">'+
            '<h4 class="location-label">'+item.location_title+'</h4>'+
            '<p class="address">'+item.address_id+'</p>'+
            '</div>'+
            '<div class="col-md-4 wrapper">'+
              '<div class="time-label ' + status +'">'+
                openId +' - '+closedId+
              '</div>'+
            '</div>'+
            '<div class="col-md-3 wrapper">'+
              '<p class="services-label">'+tags+'</p>'+
            '</div>'+
          '</div>');
          });

          if(totalNumber < 12){
            $('#pagination-place').addClass('hidden')
          }else{
            $('#pagination-place').removeClass('hidden')
          }
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
        $(window).scrollTop($('.location-menu').offset().top);
      },
      afterNextOnClick: function(){
        $(window).scrollTop($('.location-menu').offset().top);
      },
      afterPreviousOnClick: function(){
        $(window).scrollTop($('.location-menu').offset().top);
      }
    });
  }else{
    $('#pagination-place').empty();
    $("#locations-list").append('<div class="text-center">'+
      '<p class="text-center my-5">No results found</p>'+
    '</div>');
  }
}