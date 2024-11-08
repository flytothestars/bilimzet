const Swiper = require('swiper/swiper-bundle.min');

let swiperMain = new Swiper('.swiper-mainslider', {
	initialSlide: 0,
	slidesPerView: 1,
	spaceBetween: 0,
	speed: 800,
	loop: true,
	grabCursor: true,
	centeredSlides: false,
	navigation: {
		nextEl: '.nextMSlide',
		prevEl: '.prevMSlide',
	},
	pagination: {
		el: '.swiper-pagination',
		clickable: true,
		renderBullet: function (index, className) {
			return '<span class="' + className + '">' + (index + 1) + '</span>';
		},
	},
	autoplay: {
		delay: 5000,
	},
});

let swiperSteps = new Swiper('.swiper-steps', {
	initialSlide: 0,
	slidesPerView: 4,
	spaceBetween: 28,
	speed: 800,
	loop: true,
	grabCursor: true,
	centeredSlides: false,
	breakpoints: {
		650: {
			slidesPerView: 1,
			spaceBetween: 10,
		},
	},
	navigation: {
		nextEl: '.nextStep',
		prevEl: '.prevStep',
	}
});

let swiperTeacher = new Swiper('.swiper-teacher', {
	initialSlide: 0,
	slidesPerView: 6,
	spaceBetween: 28,
	speed: 800,
	loop: true,
	grabCursor: true,
	centeredSlides: false,
	breakpoints: {
		1000: {
			slidesPerView: 3,
			spaceBetween: 10,
		},
	},
	navigation: {
		nextEl: '.nextTeacher',
		prevEl: '.prevTeacher',
	}
});

let swiperTeachers = new Swiper('.swiper-teachers', {
	initialSlide: 0,
	slidesPerView: 6,
	spaceBetween: 28,
	speed: 800,
	loop: false,
	grabCursor: true,
	centeredSlides: false,
	breakpoints: {
		1000: {
			slidesPerView: 3,
			spaceBetween: 10,
		},
		500: {
			slidesPerView: 2,
			spaceBetween: 10,
		},
	},
	navigation: {
		nextEl: '.nextTeachers',
		prevEl: '.prevTeachers',
	}
});

let swiperLetters = new Swiper('.swiper-letters', {
	initialSlide: 0,
	slidesPerView: 4,
	spaceBetween: 28,
	speed: 800,
	loop: true,
	grabCursor: true,
	centeredSlides: false,
	breakpoints: {
		1200: {
			slidesPerView: 4,
			spaceBetween: 10,
		},
		1000: {
			slidesPerView: 3,
			spaceBetween: 10,
		},
		500: {
			slidesPerView: 1,
			spaceBetween: 10,
		},
	},
	navigation: {
		nextEl: '.nextLetter',
		prevEl: '.prevLetter',
	}
});

let swiperTeam = new Swiper('.swiper-team', {
	initialSlide: 0,
	slidesPerView: 4,
	spaceBetween: 28,
	speed: 800,
	loop: true,
	grabCursor: true,
	centeredSlides: false,
	breakpoints: {
		1200: {
			slidesPerView: 4,
			spaceBetween: 10,
		},
		1000: {
			slidesPerView: 3,
			spaceBetween: 10,
		},
		500: {
			slidesPerView: 1,
			spaceBetween: 10,
		},
	},
	navigation: {
		nextEl: '.nextTeam',
		prevEl: '.prevTeam',
	}
});

let swiperFavorites = new Swiper('.swiper-favorites', {
	initialSlide: 0,
	slidesPerView: 3,
	spaceBetween: 20,
	speed: 800,
	loop: true,
	grabCursor: true,
	centeredSlides: false,
	breakpoints: {
		1000: {
			slidesPerView: 3,
			spaceBetween: 10,
		},
		600: {
			slidesPerView: 1,
			spaceBetween: 10,
		},
	},
	navigation: {
		nextEl: '.nextFav',
		prevEl: '.prevFav',
	}
});

let swiperNews = new Swiper('.swiper-newsslider', {
	initialSlide: 0,
	slidesPerView: 1,
	spaceBetween: 0,
	speed: 800,
	loop: true,
	grabCursor: true,
	centeredSlides: false,
	name: "navigation",
	navigation: {
		nextEl: null,
		prevEl: null,
		hideOnClick: !1,
		disabledClass: "swiper-button-disabled",
		hiddenClass: "swiper-button-hidden",
		lockClass: "swiper-button-lock"
	},
	pagination: {
		el: '.swiper-pagination',
		clickable: true,
		renderBullet: function (index, className) {
			return '<span class="' + className + '">' + (index + 1) + '</span>';
		},
	},
});

let swiperCourseNavi = new Swiper('.swiper-course-navi', {
	initialSlide: 0,
	slidesPerView: 5,
	spaceBetween: 20,
	speed: 800,
	loop: false,
	grabCursor: true,
	centeredSlides: false,
	breakpoints: {
		1000: {
			slidesPerView: 3,
			spaceBetween: 10,
		},
		700: {
			slidesPerView: 2,
			spaceBetween: 10,
		},
	},
});

$('.doshk').click( () => {
	swiperTabs.slideTo(0, 500);
	jQuery('.swiper-course-navi .swiper-slide').removeClass('current');
	jQuery(this).addClass('current');
});

$('.corr-obr').click( () => {
	swiperTabs.slideTo(1, 500);
	jQuery('.swiper-course-navi .swiper-slide').removeClass('current');
	jQuery(this).addClass('current');
});

$('.dop-obr').click( () => {
	swiperTabs.slideTo(2, 500);
	jQuery('.swiper-course-navi .swiper-slide').removeClass('current');
	jQuery(this).addClass('current');
});

$('.ob-sr-obr').click( () => {
	swiperTabs.slideTo(3, 500);
	jQuery('.swiper-course-navi .swiper-slide').removeClass('current');
	jQuery(this).addClass('current');
});

$('.tipo').click( () => {
	swiperTabs.slideTo(4, 500);
	jQuery('.swiper-course-navi .swiper-slide').removeClass('current');
	jQuery(this).addClass('current');
});
