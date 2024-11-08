@extends('layouts.admin')

@section('content')

	<nav aria-label="breadcrumb" class="mt-4">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{ route('admin.specialities') }}">Специализации</a></li>
			<li class="breadcrumb-item active" aria-current="page">{{ $speciality ? 'Редактировать' : 'Добавить' }}
				специализацию
			</li>
		</ol>
	</nav>
	<h2 class="mt-4 mb-3">{{ $speciality ? 'Редактировать' : 'Добавить' }} специализацию</h2>
	<div>
		@if ($speciality)
			<p>
				<a href="{{ $speciality ? route('speciality', ['id' => $speciality ? $speciality->id : 0]) : '' }}"
					target="_blank">Открыть на сайте</a></p>
		@endif
		<form id="form" method="post" enctype="multipart/form-data"
				action="{{ $speciality ? route('admin.updateSpeciality', compact('speciality')) : route('admin.storeSpeciality') }}">
			@csrf
			@if($errors->any())
				<div class="alert alert-danger" role="alert">
					{{ $errors->first() }}
				</div>
			@endif
			<div class="form-group">
				<label for="title">Название специализации ru</label>
				<input value="{{ $speciality->title ?? old('title') }}"
						 class="form-control @error('title') is-invalid @enderror"
						 type="text"
						 name="title" id="title" placeholder="">
				@error('title')
				<div class="invalid-feedback">
					{{ $errors->first('title') }}
				</div>
				@enderror
			</div>
			<div class="form-group">
				<label for="title_kz">Название специализации kz</label>
				<input value="{{ $speciality->title_kz ?? old('title_kz') }}"
						 class="form-control @error('title_kz') is-invalid @enderror"
						 type="text"
						 name="title_kz" id="title_kz" placeholder="">
				@error('title_kz')
				<div class="invalid-feedback">
					{{ $errors->first('title_kz') }}
				</div>
				@enderror
			</div>
			<div class="form-group mt-2">
				<label for="picture">Картинка</label>
				<div class="custom-file">
					<input class="custom-file-input @error('picture') is-invalid @enderror"
							 type="file" id="picture" name="picture">
					<label class="custom-file-label" for="picture">Выберите файл</label>
					@error('picture')
					<div class="invalid-feedback">
						{{ $errors->first('picture') }}
					</div>
					@enderror
				</div>
				@if ($speciality && $speciality->picture)
					<div class="mt-1">
						Используется:
						<a target="_blank" href="{{ $speciality->getUploadedUrl('picture') }}">картинка</a>
					</div>
				@endif
			</div>
			<div class="form-group mt-2">
				<label for="picture_background">Фон картинки</label>
				<input id="picture_background" name="picture_background"
						 type="color" value="{{ $speciality->picture_background ?? old('picture_background')}}">
				@error('picture_background')
				<div class="invalid-feedback">
					{{ $errors->first('picture_background') }}
				</div>
				@enderror
			</div>
			<div class="form-group">
				<label for="category">Категория</label>
				<select class="form-control" name="category" id="category">
					<?php $parent = ''; ?>
					@foreach ($categories as $category)
					<?php if ($parent != $category->parent) { ?>
						<?php if (!$loop->first) { ?>
						</optgroup>
						<?php } ?>
					<optgroup label="{{ $category->parent }}">
						<?php $parent = $category->parent; } ?>
						<option value="{{ $category->id }}"
							{{ ($speciality && $speciality->category === $category->id) ? 'selected' : '' }}>
							{{ $category->name }}
						</option>
						@endforeach
					</optgroup>
				</select>
			</div>
			@if($speciality)
				<h5 class="mt-4 mb-4">
					<a href="{{ route('admin.courses', ['speciality' => $speciality]) }}">Курсы</a>
				</h5>
			@endif
			<button type="submit" name="_save_opt" value="save" class="mt-2 btn btn-success">Сохранить</button>
			<button type="submit" name="_save_opt" value="add_course" class="mt-2 ml-3 btn btn-primary">
				Сохранить и добавить курс
			</button>
		</form>
	</div>
@endsection
