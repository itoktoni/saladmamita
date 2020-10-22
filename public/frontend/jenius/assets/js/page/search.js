/*
* search.js
* 
*/
var searchAction, searchTemplate, constant;

$('#search-input-support').keyup(function(e) {
	if (e.keyCode == 13) {
		location.href = $('#base_url').val() + 'search/?keyword=' + e.target.value;
	}
});

$('#search-input-support-FaqSearch').keyup(function(e) {
	if (e.keyCode == 13) {
		location.href = $('#base_url').val() + 'search/FaqSearch/?keyword=' + e.target.value;
	}
});
$('#search-input').keyup(function(e) {
	if (e.keyCode == 13) {
		location.href = $('#base_url').val() + 'search/?keyword=' + e.target.value;
	} else {
		hotSearch(e.target.value);
	}
});

$('#search-input-result').keypress(function(e) {
	if (e.keyCode == 13) {
		console.log('Searching...');
		e.preventDefault();
		search($(this).val());
	}
});

$('#search-input-result-faq').keypress(function (e) {
	if (e.keyCode == 13) {
		console.log('Searching...');
		e.preventDefault();
		Faqsearch($(this).val());
	}
});

$(document).ready(function() {
	search($('#search-input-result').val());
	Faqsearch($('#search-input-result-faq').val());
});

function getConstant(keyword) {
	const searchVal = keyword;
	const base_url = $('#base_url').val();
	const url_object = new URL(base_url);
	const truncated_base_url = url_object.origin + '/';
	const hostname = url_object.pathname == '/en/' ? url_object.hostname + '/en/' : url_object.hostname + '/';
	const lang = url_object.pathname == '/en/' ? 'en' : 'id'; 

  	return {
		searchVal: searchVal,
		base_url: base_url,
		url_object: url_object,
		truncated_base_url: truncated_base_url,
		hostname: hostname,
		lang: lang
  	};
}

function hotSearch(keyword) {
	constant = getConstant(keyword);

	if(searchAction){
		searchAction.abort();
	}

	searchAction = $.ajax({
		method: 'GET',
		dataType: 'json',
		url: $('#api_url').val() + 'search/result/' + constant.lang + '?keyword=' + constant.searchVal,
		beforeSend: function(data) {
			$('#result-content').empty();
		},
		success: function(data) {
			data.jeniusdictionary.map(function(item, key) {
				$('#result-content').append(
					searchTemplate.hotSearch.jeniusdictionary(item)
				);
			});
			data.faq.map(function(item, key) {
				$('#result-content').append(
					searchTemplate.hotSearch.faq(item, constant.base_url)
				);
			});
			data.post.map(function(item, key) {
				$('#result-content').append(
					searchTemplate.hotSearch.post(item, constant.base_url)					
				);
			});
			data.location.map(function(item, key) {
				$('#result-content').append(
					searchTemplate.hotSearch.location(item, constant.base_url)
				);
			});
			data.everyyay.map(function(item, key) {
				$('#result-content').append(
					searchTemplate.hotSearch.everyyay(item, constant.base_url)
				);
			});
		},
		error: function(xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		}
	});
}

function search(keyword) {
	constant = getConstant(keyword);

	if(!keyword) {
		$('#search-result-content').empty();
		return;
	}

	$.ajax({
		method: 'GET',
		dataType: 'json',
		url: $('#api_url').val() + 'search/result/' + constant.lang + '?keyword=' + constant.searchVal,
		beforeSend: function(data) {
			$('#search-result-content').empty();
		},
		success: function(data) {
			if(data.everyyay.length < 1 && 
				data.post.length < 1 &&
				data.location.length < 1 &&
				data.jeniusdictionary.length < 1 &&
				data.faq.length < 1)
			{	
				$('#search-result-content').append(
					searchTemplate.search.noresult()
				);
			}
			data.jeniusdictionary.map(function(item, key) {
				$('#search-result-content').append(
					searchTemplate.search.jeniusdictionary(item, constant.truncated_base_url)
				);
			});
			data.faq.map(function(item, key) {
				$('#search-result-content').append(
					searchTemplate.search.faq(item, constant.base_url, constant.hostname)					
				);
			});
			data.post.map(function(item, key) {
				$('#search-result-content').append(
					searchTemplate.search.post(item, constant.base_url, constant.hostname)
				);
			});
			data.location.map(function(item, key) {
				$('#search-result-content').append(
					searchTemplate.search.location(item, constant.base_url, constant.hostname)
				);
			});
			data.everyyay.map(function(item, key) {
				$('#search-result-content').append(
					searchTemplate.search.everyyay(item, constant.base_url, constant.hostname)
				);
			});
		},
		error: function(xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		}
	});
}

function Faqsearch(keyword) {
	constant = getConstant(keyword);

	if (!keyword) {
		$('#search-result-content-faq').empty();
		return;
	}

	$.ajax({
		method: 'GET',
		dataType: 'json',
		url: $('#api_url').val() + 'search/result/' + constant.lang + '?keyword=' + constant.searchVal,
		beforeSend: function (data) {
			$('#search-result-content-faq').empty();
		},
		success: function (data) {
			console.log(data)
			if (data.faq.length < 1) {
				$('#search-result-content-faq').append(
					searchTemplate.search.noresult()
				);
			}
			data.faq.map(function (item, key) {
				$('#search-result-content-faq').append(
					searchTemplate.search.faq(item, constant.base_url, constant.hostname)
				);
			});
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		}
	});
}

searchTemplate = {

  hotSearch:{
    jeniusdictionary : function( item ){
      	var template = '<div class="result-inner-content">' +
                        '<a href="' + item['url_'+item.lang] + '">' +
                        '<div class="row">' +
                          '<div class="col-4 col-md-2">' +
                            '<small class="search-result-tag text-uppercase font-weight-bold font-size-xs text-gray-300">Jenius Dictionary</small>' +
                          '</div>' +
                          '<div class="col-8 col-md-10">' +
                            '<p class="text-gray-500 mb-0 font-weight-normal">' +
                              item['text_read_' + item.lang] +
                            '</p>' +
                          '</div>' +
                        '</div>' +
                        '</a>' +
                      '</div>';
      return template;
    },
    faq : function( item, base_url ){
      var template = '<div class="result-inner-content">' +
                        '<a href="' + base_url + 'faq">' +
                          '<div class="row">' +
                            '<div class="col-4 col-md-2">' +
                              '<small class="search-result-tag text-uppercase font-weight-bold font-size-xs text-gray-300">FAQ</small>' +
                            '</div>' +
                            '<div class="col-8 col-md-10">' +
                              '<p class="text-gray-500 mb-0 font-weight-normal">' +
                                item.faq_title +
                              '</p>' +
                            '</div>' +
                          '</div>' +
                        '</a>' +
                      '</div>';
      return template;
    },
    post : function( item, base_url ){
      var template = '<div class="result-inner-content">' +
						'<a href="' + base_url + 'highlight/detail/' + item.slug + '">' +
							'<div class="row">' +
								'<div class="col-4 col-md-2">' +
									'<small class="search-result-tag text-uppercase font-weight-bold font-size-xs text-gray-300">Highlight</small>' +
								'</div>' +
								'<div class="col-8 col-md-10">' +
									'<p class="text-gray-500 mb-0 font-weight-normal">' + item.title + '</p>' +
								'</div>' +
							'</div>' +
						'</a>' +
					 '</div>';
      return template;
    },
    location : function( item, base_url ){
      var template = '<div class="result-inner-content">' +
						'<a href="' + base_url + 'locations">' +
							'<div class="row">' +
								'<div class="col-4 col-md-2">' +
									'<small class="search-result-tag text-uppercase font-weight-bold font-size-xs text-gray-300">Location</small>' +
								'</div>' +
								'<div class="col-8 col-md-10">' +
									'<p class="text-gray-500 mb-0 font-weight-normal">' + item.location_title + '</p>' +
								'</div>' +
							'</div>' +
						'</a>' +
					 '</div>';
      return template;
    },
    everyyay : function( item, base_url ){
      var template = '<div class="result-inner-content">' +
						'<a href="' + base_url + 'everyyay/details/' + item.slug + '">' +
							'<div class="row">' +
								'<div class="col-4 col-md-2">' +
									'<small class="search-result-tag text-uppercase font-weight-bold font-size-xs text-gray-300">Everyyay</small>' +
								'</div>' +
								'<div class="col-8 col-md-10">' +
									'<p class="text-gray-500 mb-0 font-weight-normal">' + item.title + '</p>' +
								'</div>' +
							'</div>' +
						'</a>' +
					 '</div>';
      return template;
    }
  },

  search:{
    noresult : function (){
        var template = "<p class='text-center my-5'>No Results Found</p>";
        return template;
    },
    jeniusdictionary : function ( item, truncated_base_url ){
    	var buttonText = 'Lebih Lanjut ';
    	if(item.lang == 'en') {
    		buttonText = 'View More '
    	}
        var template = `<div class="search-result-header py-4 px-2 animated fadeInUp delayp2">
				            <div class="container">
				              <div class="row row-3">
				                <div class="col-md-1 col-xl-1 icon-result">
				                  <img src="${truncated_base_url}assets/img/common/ic_idea.svg" alt="Icon">
				                </div>
				                <div class="col-md-2 col-xl-2">
				                  <h5 class="text-primary font-weight-normal mb-2">${item['text_read_' + item.lang]}</h5>
				                </div>
				                <div class="col-md-9 col-xl-9">
				                  <p class="text-gray-200 font-size-md mb-3">${item['content_'+item.lang]}</p>
				                  <div>
				                    <div class="float-left">
				                      <a href="${item['url_'+item.lang]}" class="btn btn-link-w-chevron py-0">${buttonText} <i class="fal fa-angle-right"></i></a>
				                    </div>
				                    <div class="float-right">
				                      <small class="search-result-tag text-uppercase">Jenius Dictionary</small>
				                    </div>
				                    <div class="cleafix"></div>
				                  </div>
				                </div>
				              </div>
				            </div>
				          </div>
			          	`;
        return template;
    },
    faq : function( item, base_url, hostname ){
        var template = ' <div class="search-result-col">' +
							'<div class="container-sm ml-auto mr-auto">' +
								'<div class="row">' +
									'<div class="col-xl-1">' +
										'<small class="search-result-tag text-uppercase text-gray-300">FAQ</small>' +
									'</div>' +
									'<div class="col-xl-11">' +
										'<a href="' + base_url + 'faq/' + item.faq_slug + '/#' + item.faq_anchor + '">' +
											'<h4 class="text-gray-600">' +
												item.faq_title +
											'</h4>' +
										'</a>' +
										'<div>' +
										'<p class="text-gray-600">' +
											item['faq_content'] +
										'</p>' +
										'</div>' +
										'<a href="' + base_url + 'faq/' + item.faq_slug + '/#' + item.faq_anchor + '">' +
											'<p>' +
												hostname + 'faq/' + item.faq_slug + '/#' + item.faq_anchor +
											'</p>'+
										'</a>' +
									'</div>' +
								'</div>' +
							'</div>' +
						'</div>';
        return template;
    },
    post : function( item, base_url, hostname ){
        var template = '<div class="search-result-col">' +
							'<div class="container-sm ml-auto mr-auto">' +
								'<div class="row">' +
									'<div class="col-xl-1">' +
										'<small class="search-result-tag text-uppercase text-gray-300">Highlight</small>' +
									'</div>' +
									'<div class="col-xl-11">' +
										'<a href="' + base_url + 'highlight/detail/' + item.slug + '">' +
											'<h4 class="text-gray-600">' + item.title + '</h4>' +
										'</a>'+
										'<p class="text-gray-600 text-truncate-multiline line-clamp line-clamp-3">' + item.content + '</p>' +
										'<a href="' + base_url + 'highlight/detail/' + item.slug +'">' +
											'<p>' + hostname + 'highlight/detail/' + item.slug + '</p>' +
										'</a>' +
									'</div>' +
								'</div>' +
							'</div>' +
					   '</div>';
        return template;
    },
    location : function( item, base_url, hostname ){
        var template = ' <div class="search-result-col">' +
							'<div class="container-sm ml-auto mr-auto">' +
								'<div class="row">' +
									'<div class="col-xl-1">' +
										'<small class="search-result-tag text-uppercase text-gray-300">Location</small>' +
									'</div>' +
									'<div class="col-xl-11">' +
										'<a href="' + base_url + 'locations">' +
											'<h4 class="text-gray-600">' + item.location_title + '</h4>' +
										'</a>' +
										'<p class="">' + item.address_id + '</p>' +
										'<a href="' + base_url + 'locations">' + hostname + 'locations' + '</a>' +
									'</div>' +
								'</div>' +
							'</div>' +
				       '</div>';
        return template;
    },
    everyyay : function( item, base_url, hostname ){
        var template =  '<div class="search-result-col">' +
							'<div class="container-sm ml-auto mr-auto">' +
								'<div class="row">' +
									'<div class="col-xl-1">' +
										'<small class="search-result-tag text-uppercase text-gray-300">Everyyay</small>' +
									'</div>' +
									'<div class="col-xl-11">' +
										'<a href="' + base_url + 'everyyay/details/' + item.slug +'">' +
											'<h4 class="text-gray-600">' +
												item.title +
											'</h4>' +
										'</a>' +
										'<p class="text-gray-600 text-truncate-multiline line-clamp line-clamp-3">' + item['content_' + item.lang] + '</p>' +
										'<a href="' + base_url + 'everyyay/details/' + item.slug +'">' +
											'<p>' + hostname + 'everyyay/details/' + item.slug + '</p>'+
										'</a>' +
									'</div>' +
								'</div>' +
							'</div>' +
						'</div>';
        return template;
    }
  }
};