@extends('layouts.admin')

@section('content')

	<nav aria-label="breadcrumb" class="mt-4">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{ route('admin.contests') }}">Конкурсы</a></li>
			<li class="breadcrumb-item active" aria-current="page">{{ $item ? 'Редактировать' : 'Добавить' }} конкурс</li>
		</ol>
	</nav>

	<h2 class="mt-4 mb-3">{{ $item ? 'Редактировать' : 'Добавить' }} конкурс</h2>

	<div>
		@if ($item)
			<p><a href="{{ route('contest', ['id' => $item->id]) }}" target="_blank">Открыть на сайте</a></p>
		@endif
		<form id="form" method="post" enctype="multipart/form-data" action="{{ $formAction }}">
			@csrf
			@if ($errors->any())
				<div class="alert alert-danger" role="alert">
					{{ $errors->first() }}
				</div>
			@endif
			<fieldset class="mt-4">
				<div class="form-group">
					<label for="title">Название конкурса ru</label>
					<input value="{{ $item->title ?? old('title') }}"
							 class="form-control @error('title') is-invalid @enderror"
							 type="text" name="title" id="title" placeholder="">
					@error('title')
					<div class="invalid-feedback">
						{{ $errors->first('title') }}
					</div>
					@enderror
				</div>
				<div class="form-group">
					<label for="title_kz">Название конкурса kz</label>
					<input value="{{ $item->title_kz ?? old('title_kz') }}"
							 class="form-control @error('title_kz') is-invalid @enderror"
							 type="text" name="title_kz" id="title_kz" placeholder="">
					@error('title_kz')
					<div class="invalid-feedback">
						{{ $errors->first('title_kz') }}
					</div>
					@enderror
				</div>
			</fieldset>
			<div class="form-group">
				<label for="category">Категория</label>
				<select class="form-control" name="category_id" id="category">
					@foreach($categories as $category)
						<option value="{{ $category->id }}" {{ $item ? $item->category_id == $category->id ? 'selected' : '' : ''  }} >
							{{ $category->name }}
						</option>
					@endforeach
				</select>
			</div>
			<div class="form-group mt-2">
				<label for="picture">Картинка</label>
				<div class="custom-file">
					<input class="custom-file-input @error('picture') is-invalid @enderror"
							 type="file" id="picture" name="picture">
					<label class="custom-file-label" for="picture">Выберите файл</label>
					@error ('picture')
					<div class="invalid-feedback">
						{{ $errors->first('picture') }}
					</div>
					@enderror
				</div>
				@if ($item && $item->picture)
					<div class="mt-1">
						Используется:
						<a target="_blank" href="{{ $item->getUploadedUrl('picture') }}">картинка</a>
					</div>
				@endif
			</div>
			@if ($item)
				<fieldset class="mt-4">
					<legend>Награды конкурсов</legend>
					<h6 class="ml-4">
						<a href="{{ route('admin.contestsCertificates', compact('contest')) }}">Редактировать</a>
					</h6>
				</fieldset>

				<fieldset class="mt-4">
					<legend>Содержимое конкурса</legend>
					<h6 class="ml-4">
						<a href="{{ $partsRoute }}">Редактировать части	конкурса</a>
					</h6>
				</fieldset>
			@endif
			<div class="form-group mt-2">
				<label for="desc_text">Описание конкурса ru</label>
				<textarea class="form-control @error('desc_text') is-invalid @enderror"
							 name="desc_text" id="desc_text"
							 rows="6">{{ $item->desc_text ?? old('desc_text') }}</textarea>
				@error ('desc_text')
				<div class="invalid-feedback">
					{{ $errors->first('desc_text') }}
				</div>
				@enderror
			</div>
			<div class="form-group mt-2">
				<label for="desc_text_kz">Описание конкурса kz</label>
				<textarea class="form-control @error('desc_text_kz') is-invalid @enderror"
							 name="desc_text_kz" id="desc_text_kz"
							 rows="6">{{ $item->desc_text_kz ?? old('desc_text_kz') }}</textarea>
				@error ('desc_text_kz')
				<div class="invalid-feedback">
					{{ $errors->first('desc_text_kz') }}
				</div>
				@enderror
			</div>
			<div class="form-group mt-2">
				<label for="text_on_picture">Надпись карточки ru</label>
				<textarea class="form-control @error('text_on_picture') is-invalid @enderror"
							 name="text_on_picture" id="text_on_picture"
							 rows="6">{{ $item->text_on_picture ?? old('text_on_picture') }}</textarea>
				@error ('desc_text')
				<div class="invalid-feedback">
					{{ $errors->first('text_on_picture') }}
				</div>
				@enderror
			</div>
			<div class="form-group mt-2">
				<label for="text_on_picture_kz">Надпись карточки kz</label>
				<textarea class="form-control @error('text_on_picture_kz') is-invalid @enderror"
							 name="text_on_picture_kz" id="text_on_picture_kz"
							 rows="6">{{ $item->text_on_picture_kz ?? old('text_on_picture_kz') }}</textarea>
				@error ('text_on_picture_kz')
				<div class="invalid-feedback">
					{{ $errors->first('text_on_picture_kz') }}
				</div>
				@enderror
			</div>
			@if ($item)
				<button type="submit" name="_save_opt" value="save_part" class="mt-2 ml-3 btn btn-primary">
					Сохранить
				</button>
			@else
				<button type="submit" name="_save_opt" value="add_part" class="mt-2 ml-3 btn btn-primary">
					Добавить
				</button>
			@endif
		</form>
	</div>

@endsection
