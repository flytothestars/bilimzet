const Swiper = require('swiper/swiper-bundle.min');

if ($('.specialities-tabs').length > 0) {
	let swiperTabs = new Swiper('.swiper-tabs', {
		initialSlide: 0,
		slidesPerView: 1,
		spaceBetween: 0,
		speed: 800,
		loop: false,
		grabCursor: true,
		centeredSlides: false,
		autoHeight: true
	});

	$('.subcat-courses').click( e => {
		let btn = $(e.target),
			box = btn.parent(),
			id = btn.data('id');

		swiperTabs.slideTo(id, 500);
		$('.subcat .subcat-tab').removeClass('current');
		box.addClass('current');
	});
}
