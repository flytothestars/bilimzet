@extends('layouts.admin')

@section('content')
	<nav aria-label="breadcrumb" class="mt-4">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{ route('admin.guides') }}">Гайды</a></li>
			<li class="breadcrumb-item active" aria-current="page">{{ $item ? 'Редактировать' : 'Добавить' }}
				гайд
			</li>
		</ol>
	</nav>
	<h2 class="mt-4 mb-3">{{ $item ? 'Редактировать' : 'Добавить' }} гайд</h2>
	<div>
		@if($item)
			<p><a href="{{ route('index') }}" target="_blank">Открыть на сайте</a></p>
		@endif
		<form id="form" method="post" enctype="multipart/form-data" action="{{ $item ? route('admin.guide.update', [ 'id' => $id ]) : route('admin.guide.store') }}">
			@csrf
			@if ($errors->any())
				<div class="alert alert-danger" role="alert">
					{{ $errors->first() }}
				</div>
			@endif
			<div class="form-group">
				<label for="title">Название гайда ru</label>
				<input value="{{ $item->title ?? old('title') }}"
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
				<label for="name_kz">Название гайда kz</label>
				<input value="{{ $item->title_kz ?? old('title_kz') }}"
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
				<label for="video">Видео</label>
				<input class="form-control @error('video') is-invalid @enderror"
							 type="text" id="video" name="video" value="{{ $item->video ?? old('video') }}">
					@error('video')
						<div class="invalid-feedback">
							{{ $errors->first('video') }}
						</div>
					@enderror
				</div>
			</div>
			<div class="form-group">
				<label for="text">Контент гайда ru</label>
				<textarea class="summernote" name="text" id="text" style="width:700px;height:550px">{{ $item->text ?? old('text') }}</textarea>
			</div>
			<div class="form-group">
				<label for="text_kz">Контент гайда kz</label>
				<textarea class="summernote" name="text_kz" id="text_kz" style="width:700px;height:550px">{{ $item->text_kz ?? old('text_kz') }}</textarea>
			</div>
			@if($item)
				<button type="submit" name="_save_opt" value="save" class="mt-2 btn btn-success">Сохранить</button>
			@else
				<button type="submit" name="_save_opt" value="add_course" class="mt-2 ml-3 btn btn-primary">
					Сохранить и добавить гайд
				</button>
			@endif
		</form>
	</div>

@endsection
