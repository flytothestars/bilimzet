/* globals feather:false, bsCustomFileInput:false */

// (function () {
// 	'use strict';
//
// 	feather.replace();
// 	bsCustomFileInput.init();
// }());

const summernote = $('.summernote');
if (summernote.length > 0) {
	summernote.summernote({ height: 500, lang: 'ru-RU' });
}



let key = 1;
let right_answers = [];
$(document).ready(function () {
    $('.questions-list').on('click', '.question-row', function (e) {
        e.preventDefault();

        let question_id = $(this).attr('data-question-id');

        $('#question-' + question_id).remove();
    });

    $('#add_new_question').click(function (e) {
        e.preventDefault();

        key++;

        $('.questions-list').append(questionDom(key));
    });

    $('.questions-list').on('click', '.form-check-input.answer', function () {
        let is_right_key = $(this).attr('data-key');
        let question = $(this).attr('data-question');
        right_answers = right_answers.filter((v) => v.question !== question);

        right_answers.push({
            question: question,
            answer: is_right_key,
        });

        right_answers.forEach(function (v, i) {
            $('#question-' + v.question + ' > .right-answer').text('');
            $('#question-' + v.question + ' > .right-answer').append('<input type="hidden" name="question[' + v.question + '][right_answer]" value="' + v.answer + '">');
        })
    });

    $('.form-check-input.answer.edit').click(function () {
        let question_id = $(this).attr('data-question-id');
        let answer_id = $(this).attr('data-answer-id');

        $('#right_answer_' + question_id).val(answer_id);
    });

	 $('.question-delete').click(function () {
		 let id = $(this).attr('data-question-id');
		 let _token = $('meta[name="csrf-token"]').attr('content');

		 if (confirm('Вы действительно хотите удалить вопрос?')) {
			 $.post('/admin/olympic/question/delete', {
				 id: id,
				 _token: _token,
			 }, function() {
				 $('#question-' + id).remove();
			 });
		 }

		 return false;
	 });
});

function questionDom(key) {
	let html = '';

	html += ' <div class="row" style="margin-bottom: 2em;" id="question-' + key + '">\n' +
        '                <div class="col-md-3">\n' +
        '                    <input class="form-control" type="text" name="question[' + key + '][title]" placeholder="Вопрос">\n' +
		  '                    <input class="form-control" type="hidden" name="question[' + key + '][is_new]" value="1">\n' +
        '                </div>';

	for (let i = 1; i <= 4; i++) {
	    html += '<div class="col-md-2">\n' +
            '                        <input class="form-control" type="text" name="question[' + key + '][answers][' + i + ']" placeholder="Ответ">\n' +
            '                        <input class="form-check-input answer" type="radio" name="is_right_' + key + '" id="answer' + key+i + '" data-question="' + key + '" data-key="' + i + '">\n' +
            '                        <label class="form-check-label" for="answer' + key+i + '">\n' +
            '                            Верный ответ\n' +
            '                        </label>\n' +
            '                    </div>';
    }
    html += '<div><button type="button" class="btn btn-danger question-row" data-question-id="' + key + '">Удалить</button></div>';

    html += '<div class="right-answer"><input type="hidden" name="question[' + key + '][right_answer]"></div></div>';

	return html;
}
