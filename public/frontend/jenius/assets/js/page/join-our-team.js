function onJobClick(id) {
  var base_url = $('#base_url').val();
  fetch(base_url + 'joinourteam/getJobPositionContent/' + id ).then((res) => {
    return res.json();
  }).then((res) => {
    $('#jobDescription').html(
        `<h3 class="modal-title" id="JobDescLabel">${res.position_title}</h3>
        <p class="text-gray-200">Published on: ${res.position_date}</p>
        ${res.position_content}
        <div class="text-center">
          <a href="${encodeURI(res.position_url)}" class="btn btn-primary btn-rounded">Apply For Job</a>
        </div>`
      );
  });
}

$(document).ready(function() {
  $('.slider-preview-list').slick({
    slidesToShow: 1,
    dots: true,
    autoplay: true,
    autoplaySpeed: 3000,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          centerMode: true,
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
        }
      }
    ]
  });
});

$(document).ready(function() {
  //asdfasdf hello world
  $('.slider-job-list').slick({
    slidesToShow: 2,
    dots: false,
    autoplay: true,
    autoplaySpeed: 3000,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          // centerMode: true,
          dots: true,
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          dots: true,
        }
      }
    ]
  });
});

