window.ui = require('jquery-ui-dist/jquery-ui.min');

$(document.body).on('click', '.btn-support', e => {
	$('#app').show();
});

$('.accordion').accordion({
	heightStyle: 'content'
});
