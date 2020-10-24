/* ==========================================================================
   General
   ========================================================================== */

/* Smooth Scroll
 -------------------------------------------------- */
$('a.smooth-scroll').click(function() {
	if (
		location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') &&
		location.hostname == this.hostname
	) {
		var target = $(this.hash);
		target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
		if (target.length) {
			$('html, body').animate(
				{
					scrollTop : target.offset().top
				},
				800
			);
			return false;
		}
	}
});



$('#hide-menu').hide();
$('#dropdown-menu-jenius').hide();
$('#select-value').click(function() {
	$('#dropdown-menu-jenius').toggle();
});

/* Viewport Animations
-------------------------------------------------- */
$(document).ready(function() {
	$('.vp-fadeinleft').viewportChecker({ classToAdd: 'visible animated fadeInLeft', offset: 100 });
	$('.vp-fadeinright').viewportChecker({ classToAdd: 'visible animated fadeInRight', offset: 100 });
	$('.vp-fadein').viewportChecker({ classToAdd: 'visible animated fadeIn', offset: 100 });
	$('.vp-fadeindown').viewportChecker({ classToAdd: 'visible animated fadeInDown', offset: 100 });
	$('.vp-fadeinup').viewportChecker({ classToAdd: 'visible animated fadeInUp', offset: 100 });
	$('.vp-slideinleft').viewportChecker({ classToAdd: 'visible animated slideInLeft', offset: 100 });
	$('.vp-slideinright').viewportChecker({ classToAdd: 'visible animated slideInRight', offset: 100 });
	$('.vp-zoomin').viewportChecker({ classToAdd: 'visible animated zoomIn', offset: 100 });
	$('.vp-zoomindown').viewportChecker({ classToAdd: 'visible animated zoomInDown', offset: 100 });
	$('.vp-rotatein').viewportChecker({ classToAdd: 'visible animated rotateIn', offset: 100 });
	$('.vp-slideindown').viewportChecker({ classToAdd: 'visible animated slideInDown', offset: 100 });
});

/* Switch language
-------------------------------------------------- */
$('#lang-inner').click(function() {
	if ($(this).children('#lang-content').text() == 'IND') {
		$(this).children('#lang-content').text('ENG');
	}
	else {
		$(this).children('#lang-content').text('IND');
	}
});

function ind_onClick() {
	$(location).attr('href');
	var id_pathname = window.location.href;
	var en_pathname = id_pathname.replace(window.location.href, window.location.origin + '/en' + location.pathname);
	window.location.replace(en_pathname);
}

function eng_onClick() {
	$(location).attr('href');
	var en_pathname = window.location.href;
	var id_pathname = en_pathname.replace(
		window.location.href,
		window.location.origin + location.pathname.replace('en/', '')
	);
	window.location.replace(id_pathname);
}

/* ==========================================================================
   Navbar
   ========================================================================== */

/* Navbar Scroll
-------------------------------------------------- */
var logo = [
	window.location.origin + '/assets/img/brand/logo_jenius-blue.svg',
	window.location.origin + '/assets/img/brand/logo_jenius-white.svg'
];

$(window).on('scroll', function() {
	if ($(window).scrollTop() > 10) {
		$('.navbar-jenius').addClass('w-shadow');
		$('.navbar-transparent').addClass('navbar-scroll');
		$('.navbar-transparent .logo').attr('src', logo[0]);
	}
	else {
		//remove the background property so it comes transparent again (defined in your css)
		$('.navbar-jenius').removeClass('w-shadow');
		$('.navbar-transparent').removeClass('navbar-scroll');
		$('.navbar-transparent .logo').attr('src', logo[1]);
	}
});

/* Navbar on Mobile
-------------------------------------------------- */
// Mobile menu slide from the left
$('.navbar-toggler').click(function() {
	$('.navbar-slide').toggle('slide');
});

$('.navbar-slide-close').click(function() {
	$('.navbar-slide').toggle('slide');
});

/* Tab Custom
-------------------------------------------------- */
$(document).ready(function() {
	$('.tab-custome .nav-link').click(function() {
		$('.tab-custome .nav-link').removeClass('active');
		$(this).addClass('active');
	});
});

/* Toggle share button
-------------------------------------------------- */
$(document).on("click",".btn-share-socmed",function() {
	if($(this).hasClass("active")){
		$(this).siblings(".share-socmed").toggle();
		$(this).removeClass("active");
	}else{
		$(".share-socmed").hide();
		$(".btn-share-socmed").removeClass("active");
		$(this).siblings(".share-socmed").toggle();
		$(this).addClass("active");
	}
})

/* ==========================================================================
   Help
   ========================================================================== */

/* Help
-------------------------------------------------- */
$('.chat-btn').click(function() {
	console.log('help click');
	$('.m-popup-help').css('bottom', '0.5rem');
});

$('.close-help').click(function() {
	$('.m-popup-help').css('bottom', '-2000px');
});

$('.navbar-transparent #lang-content a').addClass('text-white');

$(window).on('scroll', function() {
	if ($(window).scrollTop() > 10) {
		$('.navbar-transparent #lang-content a').removeClass('text-white');
	}
	else {
		$('.navbar-transparent #lang-content a').addClass('text-white');
	}
});


// ==========================================
// ROTATOR
// =======================
$(document).ready(function () {
	
	// Add smooth scrolling to all links
	$("#click-scroll").on('click', function (event) {

	// Make sure this.hash has a value before overriding default behavior
	if (this.hash !== "") {
		// Prevent default anchor click behavior
		event.preventDefault();

		// Store hash
		var hash = this.hash;

		// Using jQuery's animate() method to add smooth page scroll
		// The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
		$('html, body').animate({
			scrollTop: $(hash).offset().top
		}, 1000, function () {

			// Add hash (#) to URL when done scrolling (default click behavior)
			window.location.hash = hash;
		});
	} // End if
	});
	// click-scroll-mobile-teman
	// Add smooth scrolling to all links
	$("#click-scroll-mobile-teman").on('click', function (event) {

		// Make sure this.hash has a value before overriding default behavior
		if (this.hash !== "") {
			// Prevent default anchor click behavior
			event.preventDefault();

			// Store hash
			var hash = this.hash;

			// Using jQuery's animate() method to add smooth page scroll
			// The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
			$('html, body').animate({
				scrollTop: $(hash).offset().top
			}, 1000, function () {

				// Add hash (#) to URL when done scrolling (default click behavior)
				window.location.hash = hash;
			});
		} // End if
	});
	// Add smooth scrolling to mobile device
	$("#mobile-scroll").on('click', function (event) {

		// Make sure this.hash has a value before overriding default behavior
		if (this.hash !== "") {
			// Prevent default anchor click behavior
			event.preventDefault();

			// Store hash
			var hash = this.hash;

			// Using jQuery's animate() method to add smooth page scroll
			// The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
			$('html, body').animate({
				scrollTop: $(hash).offset().top
			}, 400, function () {

				// Add hash (#) to URL when done scrolling (default click behavior)
				window.location.hash = hash;
			});
		} // End if
	});
});