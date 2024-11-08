@extends('layouts.admin')

@section('content')

	<h2 class="mt-4 mb-3">Редактирование страниц сайта</h2>
	@if (\Session::has('message'))
		<div class="alert alert-success" role="alert">
			{!! \Session::get('message') !!}
		</div>
	@endif

	<form action="{{ route('admin.edit') }}" id='select_predmet_form' method='GET'>
		<table>
			<tr>
				<td>
					<select name="page_filt" onChange="document.getElementById('select_predmet_form').submit();">
						<option value="footer" {{ $page_filt == 'footer' ? 'selected' : '' }}>Нижняя часть сайта, footer
						</option>
						<option value="contacts" {{ $page_filt == 'contacts' ? 'selected' : '' }}>Страница контакты, общие, до
							формы отправки заявки
						</option>
						<option value="contacts_stuff" {{ $page_filt == 'contacts_stuff' ? 'selected' : '' }}>Страница
							контакты, контакты сотрудников
						</option>
						<option value="about_text" {{ $page_filt == 'about_text' ? 'selected' : '' }}>Страница О компании
						</option>
						<option value="about_text_main" {{ $page_filt == 'about_text_main' ? 'selected' : '' }}>Главная, текст
							о Центре
						</option>
					</select>
				</td>
			</tr>
		</table>
	</form>

	<form action="{{ route('admin.edit.store') }}" id='update_page' method='post'>
		@csrf <!-- {{ csrf_field() }} -->
		<input type="hidden" name="page_filt" value="{{ $page_filt }}">
			<div class="title">ru</div>
		<textarea class="summernote" name="pages_text" style="width:700px;height:550px">{{ $content }}</textarea>
		<br>
			<div class="title">kz</div>
		<textarea class="summernote" name="pages_text_kz" style="width:700px;height:550px">{{ $content_kz }}</textarea>
		<br>
		<input type="button" style="background-color:#1ab394;border-color:#1ab394;color:#FFFFFF;border-radius:3px;font-size:14px;font-weight:400;line-height:1.42857143;text-align:center;vertical-align:middle;width:330px;margin:0px;height:40px;cursor:pointer"
				 onClick="document.getElementById('update_page').submit();" value="Сохранить Страницу">
	</form>

@endsection
