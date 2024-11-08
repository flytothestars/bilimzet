const mix = require('laravel-mix');
require('laravel-mix-alias');

const libsJs = [
		'node_modules/jquery/dist/jquery.min.js',
		'resources/js/add_jquery.js',
		'node_modules/jquery-ui-dist/jquery-ui.js',
		'node_modules/jquery-colorbox/jquery.colorbox-min.js',
		'node_modules/swiper/swiper-bundle.min.js'
	],
	siteJs = [
		//'resources/js/utm.js',
		'resources/js/main.js',
		'resources/js/contests.js',
		'resources/js/courses.js',
		'resources/js/script.js',
		'resources/js/carousel.js',
		'resources/js/timer.js'
	],
	appJs = [
		'resources/js/app.js',
	],
	adminJs = [
		'node_modules/jquery/dist/jquery.min.js',
		'resources/js/add_jquery.js',
		'node_modules/popper.js/dist/popper.min.js',
		'node_modules/bootstrap/dist/js/bootstrap.min.js',
		'node_modules/feather-icons/dist/feather.min.js',
		'node_modules/bs-custom-file-input/dist/bs-custom-file-input.min.js',
		'node_modules/summernote/dist/summernote.min.js',
		'node_modules/summernote/dist/summernote-bs4.min.js',
		'node_modules/summernote/dist/lang/summernote-ru-RU.min.js',
		'node_modules/metismenu/dist/metisMenu.min.js',
		'node_modules/sweetalert2/dist/sweetalert2.min.js',
		'resources/js/admin/dashboard.js',
		'resources/js/admin/contests.js'
	];

mix.options({
	processCssUrls: false
});

// mix.alias({
// 	'load-image': 'node_modules/blueimp-load-image/js/load-image.all.min.js',
// 	'load-image-meta': 'node_modules/blueimp-load-image/js/load-image-meta.js',
// 	'load-image-exif': 'node_modules/blueimp-load-image/js/load-image-exif.js',
// 	'load-image-orientation': 'node_modules/blueimp-load-image/js/load-image-orientation.js',
// 	'load-image-scale': 'node_modules/blueimp-load-image/js/load-image-scale.js',
// 	'canvas-to-blob': 'node_modules/blueimp-canvas-to-blob/js/canvas-to-blob.js',
// 	'jquery-ui/ui/widget': 'node_modules/jquery.ui.widget/jquery.ui.widget.js',
// 	'@popperjs/core': 'node_modules/popper.js/dist/popper.min.js'
// });

mix
	.js( libsJs, 'public/js/libs.js' )
	.js( siteJs, 'public/js/main.js' )
	.js( appJs, 'public/js/app.js' )
	.js( adminJs, 'public/js/admin.js' )
	.minify([ 'public/js/libs.js', 'public/js/main.js', 'public/js/app.js', 'public/js/admin.js' ])

	.copy( 'node_modules/summernote/dist/summernote.min.js.map', 'public/js/summernote.min.js.map' )
	.copy( 'node_modules/swiper/swiper-bundle.min.js.map', 'public/js/swiper-bundle.min.js.map' )
	.copy( 'node_modules/popper.js/dist/popper.js.map', 'public/js/popper.js.map' )

	.copyDirectory( 'node_modules/summernote/dist/font', 'public/css/font' )

	// .copyDirectory( 'node_modules/@fortawesome/fontawesome-free/webfonts', 'public/fonts' )
	// .copyDirectory( 'resources/fonts', 'public/fonts' )
	// .copyDirectory( 'node_modules/jquery-fancybox/source/img', 'public/img/fancybox' )

	.sass( 'resources/sass/main.scss', 'public/css')
	.sass( 'resources/sass/admin.scss', 'public/css')
	.minify([ 'public/css/main.css', 'public/css/admin.css' ])

	.version()
