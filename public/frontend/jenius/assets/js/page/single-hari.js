var current_page = $('#current_page').val();
var max_page = $('#max_page').val();
let next_page = $('#next_page').val();
let slug = $('#slug').val();
var minus_page = max_page - current_page;
var page_num = 1;
let url = base_url + 'ajax/hari2/related/' + current_page + '?page_num=';

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
    $("#single-wrapper").append(data_expand);
    if (lazyLoadInstance) {
        lazyLoadInstance.update();
    }
}

$(document).ready(function () {
    $.ajax({
        url: url+page_num,
        cache: false,
        dataType: 'json',
        type: 'get',
        success: function (response) {
            if (response['total_post'] < response['limit_post']) {
                $('#buttonShow').hide()
            }
            article(response);
            var total_page = response['total_page'];
            $('#buttonShow').click(function (response) {
                page_num++;
                if (page_num == total_page) {
                    $('#buttonShow').hide();
                }
                console.log(page_num);
                $.ajax({
                    type: "POST",
                    url: url + page_num,
                    cache: false,
                    dataType: 'json',
                    success: function (response) {
                        console.log(url + page_num)
                        article(response);
                    },
                    error: function (xhr, status, error) {
                        alert(xhr.status)
                    }
                });
            });
        },
        error: function (xhr, status, error) {
            alert(xhr.status)
        }
    });
});
