require('jquery-colorbox/jquery.colorbox-min');

$(".group").colorbox({ rel: 'group', maxWidth: '100%' });
$(".about_gallery").colorbox({ rel: 'about_gallery', maxWidth: '100%' });

$('.menu-btn').click( () => {
	let that = $(this),
		header = $('header.main-menu');

	that.toggleClass('open');
	header.slideToggle(600);
	$('body').toggleClass("fixed_body");
});
