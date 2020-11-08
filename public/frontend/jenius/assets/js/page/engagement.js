var current_page = $('#current_page').val();
var max_page = $('#max_page').val();
let next_page = $('#next_page').val();
var minus_page = max_page - current_page;
var page_num = 1;

function article(response) {
    var data_expand = '';
    $.each(response['main_data_post'], function (index, value) {
        data_expand += '<div class="col-lg-4 col-md-4 col-6">';
        data_expand += '<div class="wrapper-thumbnail">';
        data_expand += ' <a class="d-none d-lg-block" href="' + base_url + 'hari2/' + value.post_link + '"><img data-src="' + value.post_image + '" class="img-fluid" alt="' + value.post_image + '"></a>';
        data_expand += ' <a class="d-lg-none" href="' + base_url + 'hari2/' + value.post_link + '"><img data-src="' + value.banner_mobile_upload + '" class="img-fluid" alt="' + value.banner_mobile_upload + '"></a>';
        data_expand += '</div>';
        data_expand += '<div class="wrapper-title-produk d-none d-lg-block">';
        data_expand += '<h5 class="text-center title-desktop-post"><a href="' + base_url + 'hari2/' + value.post_link + '">' + value.post_title + '</a></h5>';
        data_expand += '</div>';
        data_expand += '<div class="wrapper-title-produk title-product mobile-title-article d-lg-none">';
        data_expand += '<h5 class="text-center"><a href="' + base_url + 'hari2/' + value.post_link + '">' + value.post_title + '</a></h5>';
        data_expand += '</div>';
        data_expand += '</div>';
    });
    $("#postWrapper").append(data_expand);
    if (lazyLoadInstance) {
        lazyLoadInstance.update();
    }
}

$(document).ready(function () {

    if ($(window).width() <= 1024) {
        $('#fullpage').removeAttr('id');
    }

    $("#js-rotating").Morphext({
        animation: "flipInX",
        separator: ",",
        speed: 2000,
        complete: function () {
        }
    });

    $("#marked-button").click(function () {
        $('#modalMekanisme').modal({ backdrop: 'static', keyboard: false })
        $("html").css({ "overflow-y": "none" })
        $.fn.fullpage.setMouseWheelScrolling(false);
        $.fn.fullpage.setAllowScrolling(false);
        $("#marked-button").hide(); 
        $(".modal-body").css('overflow-y','scroll'); 
        $(".modal-body").css('height','500px'); 
    });

    $("#closeModal").click(function () {
        $('#modalMekanisme').modal('hide')
        $("#marked-button").show();
        $("html").css({ "overflow-y": "scroll" })
        $.fn.fullpage.setMouseWheelScrolling(true);
        $.fn.fullpage.setAllowScrolling(true);
        location.reload();
    });

    $("#js-rotating-mobile").Morphext({
        animation: "fadeInLeft",
        separator: ",",
        speed: 2000,
        complete: function () {
        }
    });
    $("#js-rotating-mobile-2").Morphext({
        animation: "flipInX",
        separator: ",",
        speed: 2000,
        complete: function () {
        }
    });

    // Slider
    var slug = $('#highlight-secondary-navbar').find('li.active').data('slug');
    highlightsGet(slug);
    $('.slider-hari').slick({
        dots: true,
        autoplay: true,
        arrow: false,
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    dots: false,
                    arrows: true,
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    dots: false,
                }
            },
            {
                breakpoint: 750,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: false,
                }
            },
            {
                breakpoint: 415,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                    infinite: true,
                    centerMode: false,
                    arrows: false,
                }
            },
            {
                breakpoint: 376,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                    infinite: true,
                    arrows: false,
                    centerMode: false,
                }
            }
        ],
        init: function () {
            if (a2a) {
                a2a.init_all();
            }
        }
    });

    $('.slider-features-teman').slick({
        dots: false,
        arrow: true,
        infinite: false,
        autoplay: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    dots: false,
                    arrows: true,
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    dots: false,
                    arrows: true,
                }
            },
            {
                breakpoint: 750,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: false,
                    arrows: true,
                }
            },
            {
                breakpoint: 415,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                    infinite: true,
                    centerMode: false,
                    arrows: true,
                }
            },
            {
                breakpoint: 376,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                    infinite: true,
                    arrows: true,
                    centerMode: false,
                }
            }
        ],
        init: function () {
            if (a2a) {
                a2a.init_all();
            }
        }
    });

});


var selectedLabels = [];


function highlightTemplate(data) {
    var template = '<div class="article-item">' +
        '<div class="row row-3">' +
        '<div class="col-5 col-lg-4">' +
        '<a href="' + $('#base_url').val() + 'highlight/detail/' + data.post_slug + '">' +
        '<img data-src="' + data.post_image + '" class="img-fluid" alt="Image">' +
        '</a>' +
        '</div>' +
        '<div class="col-7 col-lg-8 article-info-container">' +
        '<div class="article-info">' +
        '<small>' + data.post_category + '</small>' +
        '<a href="' + $('#base_url').val() + 'highlight/detail/' + data.post_slug + '">' +
        '<h4 class="text-truncate-multiline">' + data.post_title + '</h4>' +
        '</a>' +
        '<div class="article-item-footer">' +
        '<span class="article-item-notes"><i class="icon-written-by"></i> ' + data.post_date + '</span>' +
        '<div class="float-right">' +
        '<div class="article-item-share article-highligth-share position-relative">' +
        '<div class="btn-share-socmed">Share <i class="icon-share"></i></div>' +
        '<div class="a2a_kit a2a_kit_size_32 a2a_default_style share-socmed" data-a2a-url="' + $('#base_url').val() + 'highlight/detail/' + data.post_slug + '" data-a2a-title="' + data.post_title + '">' +
        '<a class="a2a_button_facebook ml-0"><i class="fab fa-facebook-f circle-icon mb-2"></i></a>' +
        '<a class="a2a_button_twitter"><i class="fab fa-twitter circle-icon mb-2"></i></a>' +
        '<a class="a2a_button_line"><i class="icon-line circle-icon mb-2"></i></a>' +
        '<a class="a2a_button_whatsapp"><i class="fab fa-whatsapp circle-icon mb-2"></i></a>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div> ' +
        '</div>' +
        '</div>';

    return template;
}

function highlightsGet(slug) {
    $.ajax({
        type: "GET",
        url: $('#base_url').val() + 'highlight/get_highlight_count/' + (slug ? slug : 'all'),
        beforeSend: function () {
            $("#article-list-highlight").empty();
        },
        success: function (response) {

        },
        complete: function (response) {
            var count = JSON.parse(response.responseText);
            generateResult(slug, count);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });
}

function generateResult(slug, totalNumber) {
    $('#pagination-place').pagination({
        dataSource: $('#base_url').val() + 'highlight/get_highlight_ajax/' + (slug ? slug : 'all'),
        locator: 'data',
        alias: {
            pageNumber: 'page_num',
            pageSize: 'limit'
        },
        totalNumber: totalNumber,
        pageSize: 10,
        pageRange: 1,
        showPrevious: true,
        showNext: true,
        inlineStyle: false,
        classPrefix: 'page-item active',
        className: 'pagination-container clearfix',
        ulClassName: 'pagination vp-fadeinup visible animated fadeInUp full-visible',
        activeClassName: 'active',
        prevText: '<i class="fal fa-angle-left"></i>',
        nextText: '<i class="fal fa-angle-right"></i>',
        callback: function (data, pagination) {
            $('#article-list-highlight').empty();
            data.map((data, index) => {

                $('#article-list-highlight').append(
                    highlightTemplate(data)
                )
            });
            $('.vp-fadeinup').viewportChecker({
                classToAdd: 'visible animated fadeInUp',
                offset: 100
            });
            if (totalNumber < 10) {
                $('#pagination-place').addClass('hidden')
            } else {
                $('#pagination-place').removeClass('hidden')
            }
            if (lazyLoadInstance) {
                lazyLoadInstance.update();
            }
        },
        afterInit: function () {
            if (a2a) {
                a2a.init_all();
            }
        },
        afterPaging: function () {
            if (a2a) {
                a2a.init_all();
            }
        }
    });
}

function highlightsGetVideo(id) {
    $.ajax({
        type: "POST",
        url: $('#base_url').val() + 'highlight/get_highlight_videos_ajax/',
        data: {
            f_id: id,
        },
        beforeSend: function () {

        },
        success: function (response) {

        },
        complete: function (response) {
            var item = JSON.parse(response.responseText);
            $('#video-highlight-image').attr('src', item.post_image);
            $('#video-highlight-url').attr('href', item.post_video);
            $('#video-highlight-title').html(item.post_title);
            $('#video-highlight-description').html(item.post_content);
            $('#video-highlight-date').html(item.post_date);
            $('#video-highlight-share-socmed').attr('data-a2a-url', item.post_video);
            $('#video-highlight-share-socmed').attr('data-a2a-title', item.post_title);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });
}

$(".video-inner-list").click(function (e) {
    e.preventDefault();
    $(".video-inner-list").removeClass('active');
    $(this).addClass('active');
    highlightsGetVideo($(this).data('post'));
})

var navTransparent = function () {
    var windowWidth = document.body.clientWidth;
    if (windowWidth < 520 && !$('.navbar-jenius').hasClass('navbar-transparent')) {
        $('.navbar-jenius').addClass('navbar-transparent');
        $('.navbar .logo').attr('src', $('#base_url').val() + 'assets/img/brand/logo_jenius-white.svg');
    }
};


//filter function
var selectedLabels = [];
var searchKeyword = '';

$(document).ready(function () {
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
    $('.container > ul > li > .nav-link').click(function () {
        $('.nav-link-li').removeClass('active');
        $(this).parent().addClass('active');
    });
    $('.dropdown-menu-jenius > .dropdown-item > .nav-link').click(function () {
        $('.dropdown-item').removeClass('active');
        $(this).parent().addClass('active');
        $('#select-value').html($(this).text());
    });
    $('.nav-link').on('click', function (e) {
        $('.dropdown-menu-jenius').hide();
    });
});

$(window).resize(function () {
    navTransparent();
});