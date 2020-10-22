/*
* search.js
* 
*/

$("#search-input").keydown(function(e){
	if ( e.which == 13 ) {
		e.preventDefault();
		doSearch();
	}
});

// $("#search-button").click(fucntion(e){
// 	e.preventDefault();
// 	doSearch();
// });

function doSearch(){
	const searchVal = $("#search-input").val();
	$.ajax({
		method: "GET",
		dataType: "json",
	  	url: API_URL+'?url=search&keyword='+searchVal,
	   	beforeSend: function(data){
	     	console.log("before: ",data);
	     	$("#result-content").empty();
	   	},
	   	success: function(data){
	   		console.log(data);
	   		data.everyyay.map(function(item, key){
	   			$("#result-content").append('<div class="result-inner-content">'+
			      			'<a href="/everyyay/details?p='+item.slug+'">'+
			      				'<div class="row">'+
				      				'<div class="col-4 col-md-2">'+
				      					'<small class="search-result-tag text-uppercase font-weight-bold font-size-xs text-gray-300">Everyyay</small>'+
				      				'</div>'+
				      				'<div class="col-8 col-md-10">'+
				      					'<p class="text-gray-500 mb-0 font-weight-normal">'+item.title+'</p>'+
				      				'</div>'+
				      			'</div>'+
			      			'</a>'+
			      		'</div>');
	   		});
	   		data.post.map(function(item, key){
	   			$("#result-content").append('<div class="result-inner-content">'+
			      			'<a href="highlight/details?s='+item.slug+'">'+
			      				'<div class="row">'+
				      				'<div class="col-4 col-md-2">'+
				      					'<small class="search-result-tag text-uppercase font-weight-bold font-size-xs text-gray-300">Highlight</small>'+
				      				'</div>'+
				      				'<div class="col-8 col-md-10">'+
				      					'<p class="text-gray-500 mb-0 font-weight-normal">'+item.title+'</p>'+
				      				'</div>'+
				      			'</div>'+
			      			'</a>'+
			      		'</div>');
	   		});
	   		data.tnc.map(function(item, key){
	   			$("#result-content").append('<div class="result-inner-content">'+
			      			'<a href="">'+
			      				'<div class="row">'+
				      				'<div class="col-4 col-md-2">'+
				      					'<small class="search-result-tag text-uppercase font-weight-bold font-size-xs text-gray-300">Tearm and Condition</small>'+
				      				'</div>'+
				      				'<div class="col-8 col-md-10">'+
				      					'<p class="text-gray-500 mb-0 font-weight-normal">'+item.title_id+'</p>'+
				      				'</div>'+
				      			'</div>'+
			      			'</a>'+
			      		'</div>');
	   		});
	   		data.privacy.map(function(item, key){
	   			$("#result-content").append('<div class="result-inner-content">'+
			      			'<a href="">'+
			      				'<div class="row">'+
				      				'<div class="col-4 col-md-2">'+
				      					'<small class="search-result-tag text-uppercase font-weight-bold font-size-xs text-gray-300">Privacy Policy</small>'+
				      				'</div>'+
				      				'<div class="col-8 col-md-10">'+
				      					'<p class="text-gray-500 mb-0 font-weight-normal">'+item.title_id+'</p>'+
				      				'</div>'+
				      			'</div>'+
			      			'</a>'+
			      		'</div>');
	   		});
	   		data.location.map(function(item, key){
	   			$("#result-content").append('<div class="result-inner-content">'+
			      			'<a href="">'+
			      				'<div class="row">'+
				      				'<div class="col-4 col-md-2">'+
				      					'<small class="search-result-tag text-uppercase font-weight-bold font-size-xs text-gray-300">Location</small>'+
				      				'</div>'+
				      				'<div class="col-8 col-md-10">'+
				      					'<p class="text-gray-500 mb-0 font-weight-normal">'+item.title+'</p>'+
				      				'</div>'+
				      			'</div>'+
			      			'</a>'+
			      		'</div>');
	   		});
	   	},
	   	complete: function(data){
	     	console.log("Complete: ",data);
	   	},
	   	error: function (xhr, ajaxOptions, thrownError) {
	        console.log(xhr.status);
	        console.log(thrownError);
        }
	   // ......
	});
}