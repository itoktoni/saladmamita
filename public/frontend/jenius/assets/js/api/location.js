//hide megamenu
$('#megamenu-locations').hide();
$('#dropdown-megamenu-location').click(function(){
  $('#megamenu-locations').toggle();
});

$('#exampleCheck1').click(function(){
  if($(this).prop('checked')){
    $('#tes1').addClass('active');
  }
  else {
    $('#tes1').removeClass('active');
  }
});

$(document).ready(function(){
  $('#search-location').on('keyup', function(){
    var str = $('#search-location').val();

    var search = 'SEARCH / * WHERE(LCASE(location_title) like "%'+str.toLowerCase()+'%") \
              RETURN(location_title, location_date, address_id, open_id, closed_id, tag_id) \
              FROM ?';
    
    $.get( API_URL+'?url=location', function( data ) {
        var datas = JSON.parse(data);
        var locations = datas.location;

        var res = alasql(search, [locations]);
   
        
        if(res && (str != '')){
            $('#location-list').empty();
           
            res.map((location, index)=>{
                var openId = location.open_id ? location.open_id:'';
                var closedId = location.closed_id ? location.closed_id:'';
                $('#location-list').append(
                    '<div class="row">'+
                        '<div class="col-md-5">'+
                            '<h4 class="location-label">'+location.location_title+'</h4>'+
                            '<p class="address">'+location.address_id+'</p>'+
                        '</div>'+
                        '<div class="col-md-4 wrapper">'+
                            '<div class="time-label open">'+
                            openId +' - '+ closedId+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-3 wrapper">'+
                            '<p class="services-label">'+
                            location.tag_id+
                            '</p>'+
                        '</div>'+
                    '</div>'
                )
            });

        }
    });
  })
});