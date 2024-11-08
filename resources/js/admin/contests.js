$('.delete.file').click(e => {
	let btn = $(e.target),
		box = btn.parent(),
		title = box.find('title');

	if (confirm('Удалить файл?')) {
		$.ajax({
			headers: {'x-csrf-token': $("meta[name='csrf-token']").attr('content')},
			url: '/profile/contests/delete-file/' + btn.data('id'),
			type: 'POST',
			data: {file: title.text()},
			dataType: 'json',
			success: data => {
				if (data.ok) {
					box.remove();
				}
			}
		})
	}
});

$('.delete.video').click(e => {
	let btn = $(e.target),
		box = btn.parent(),
		title = box.find('title');

	if (confirm('Удалить видео?')) {
		$.ajax({
			headers: {'x-csrf-token': $("meta[name='csrf-token']").attr('content')},
			url: '/profile/contests/delete-video/' + btn.data('id'),
			type: 'POST',
			data: {video: title.text()},
			dataType: 'json',
			success: data => {
				if (data.ok) {
					box.remove();
				}
			}
		})
	}
});

const select_awards = $('.select-award');
if (select_awards.length) {
	select_awards.click( ev => {
		let btn = $(ev.target).parent('a'),
			id = btn.data('id'),
			item = btn.parent('.item');
		$('.item').removeClass('selected');
		item.addClass('selected');
		$('#certificate_id').val(id);
	});
}
