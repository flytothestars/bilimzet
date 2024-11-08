@extends('layouts.admin')

@section('content')

	<h2 class="mt-4 mb-3">Благодарственные письма</h2>

	<div class="table-responsive">
		<table class="table table-striped table-sm">
			<thead>
				<tr>
					<th>Картинка</th>
					<th>Действия</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($letters as $letter)
					<tr>
						<td>
							<a href="{{ $letter->image }}" target="_blank">
								<img src="{{ $letter->image }}" width="50">
							</a>
						</td>
						<td>
							<form action="{{ route('admin.letters.delete') }}" method="post" style="display: inline-block">
								@csrf
								<input type="hidden" name="photo_to_delete" value="{{ $letter->id }}">
								<button type="submit" class="btn btn-danger btn-sm mr-2">Удалить</button>
							</form>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<br>

	<form action="{{ route('admin.letters.store') }}" id='load_file' method='POST' enctype='multipart/form-data'>
		@csrf
		<table>
			<tr>
				<td>Путь к фото:</td>
				<td width="5"></td>
				<td>
					<input type="file" name="letter_photo">
				</td>
			</tr>
		</table>
	</form>
	<a href="javascript:document.getElementById('load_file').submit()" role="button" class="btn btn-primary btn-sm mr-2">Добавить фото</a>

@endsection
