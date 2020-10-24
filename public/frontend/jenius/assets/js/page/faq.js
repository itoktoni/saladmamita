$(document).ready(function(){

    $('.accordion-header').each((index, value) => {
        var anchor = $(value).attr("data-anchor");
        var urlParam = decodeURIComponent(window.location.hash.replace('#',''));
        var urlAnchor = urlParam.toLowerCase().split(" ").join("-");
        if (anchor == urlAnchor){
            $('.accordion-body').removeClass('show');
            $('.accordion-body-anchor'+index).addClass('show');

            
            $('.accordion-header').attr("aria-expanded","false");
            $('.accordion-header-anchor'+index).attr("aria-expanded","true");
        }
       
       	$(value).click(function() {
       		$('.accordion-body-anchor' + index).collapse('toggle');
        });
        $('.accordion-body-anchor' + index).on('hidden.bs.collapse', function (){
        	$('.accordion-header-anchor'+index).attr("aria-expanded","false");
        });
        $('.accordion-body-anchor' + index).on('shown.bs.collapse', function (){
        	$('.accordion-header-anchor'+index).attr("aria-expanded","true");
        });
    });
});
