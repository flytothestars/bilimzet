@extends('layouts.base')

@section('content')

	@include('parts.profileMenu')

	<div class="podacha-statyi width1088">
		<div class="width1088 page-title">
			<h1>Мои лекции</h1>
		</div>
		<div class="my-articles width1088">
			<form id="form" method="post" enctype="multipart/form-data" action="{{ route('doApplyLecItem') }}">
				@csrf
				@if ($errors->any())
					<div class="alert alert-danger" role="alert">
						{{ $errors->first() }}
					</div>
				@endif
				<div class="row">
					<label>@lang('common.lection_name') ru</label>
					<input type="text" name="title" class="@error ('title') is-invalid @enderror">
					@error ('title')
						<div class="invalid-feedback">
							{{ $errors->first('title') }}
						</div>
					@enderror
				</div>
				<div class="row">
					<label>@lang('common.lection_name') kz</label>
					<input type="text" name="title_kz" class="@error ('title_kz') is-invalid @enderror">
					@error ('title_kz')
						<div class="invalid-feedback">
							{{ $errors->first('title_kz') }}
						</div>
					@enderror
				</div>
				<div class="row flex between  align-center desc">
					<div class="left">
						<label>@lang('common.lection_description') ru</label>
						<textarea name="text" class="@error ('text') is-invalid @enderror"></textarea>
						@error ('text')
							<div class="invalid-feedback">
								{{ $errors->first('text') }}
							</div>
						@enderror

						<label>@lang('common.lection_description') kz</label>
						<textarea name="text_kz" class="@error ('text_kz') is-invalid @enderror"></textarea>
						@error ('text_kz')
							<div class="invalid-feedback">
								{{ $errors->first('text_kz') }}
							</div>
						@enderror
					</div>
					<div class="right">
						<select name="category">
							@foreach ($categories as $category)
								<option value="{{ $category->id }}">{{ $category->name }}</option>
							@endforeach
						</select>
						<div class="input__wrapper">
							<input name="document" type="file" id="input__file" accept="{{ $accept }}"
									 class="input input__file @error ('document') is-invalid @enderror">
							<label for="input__file" class="input__file-button">
								<span class="input__file-button-text">@lang('common.attach_file')</span>
								<span class="input__file-icon-wrapper">
									<img class="input__file-icon" src="/images/elements/upload.svg" alt="@lang('common.attach_file')" width="8">
								</span>
							</label>
							@error ('document')
								<div class="invalid-feedback">
									{{ $errors->first('document') }}
								</div>
							@enderror
						</div>
					</div>
				</div>
				@if (session('message'))
					<div style="margin-top: 10px; color: green; font-size: 18px;">
						{{ session('message') }}
					</div>
				@endif
				<div class="align-right">
					<button type="submit" class="btn blue">@lang('common.send_lection')</button>
				</div>
			</form>
			@if ($items)
				<div class="articles-listing">
					<div class="top flex between align-center">
						<div class="left">@lang('common.lection_name')</div>
						<div class="right">@lang('common.article_status')</div>
					</div>
					@foreach ($items as $item)
						<div class="row flex between align-center {{ $item->is_published ?  'published' : 'unpublished'}} ">
							<div class="left"><a href="{{ route('showLectureItem', ['id' => $item->id ]) }}">{{ $item->title }}</a></div>
							<div class="right">{{ $item->is_published ? __('common.article_publish') : __('common.article_consideration') }}</div>
						</div>
					@endforeach
				</div>
			@endif
		</div>
	</div>

	<script>
		let inputs = document.querySelectorAll('.input__file');
		Array.prototype.forEach.call(inputs, function (input) {
			let label = input.nextElementSibling,
				labelVal = label.querySelector('.input__file-button-text').innerText;

			input.addEventListener('change', function (e) {
				let countFiles = '';
				if (this.files && this.files.length >= 1)
					countFiles = this.files.length;

				label.querySelector('.input__file-button-text').innerText =
					countFiles ? 'Выбрано файлов: ' + countFiles : labelVal;
			});
		});
	</script>

@endsection
