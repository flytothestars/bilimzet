@extends('layouts.admin')

@section('content')
	<nav aria-label="breadcrumb" class="mt-4">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{ route('admin.contests') }}">Конкурсы</a></li>
			<li class="breadcrumb-item">
				<a href="{{ route('admin.editContest', compact('contest')) }}">
					{{ $contest->title }}
				</a>
			</li>
			<li class="breadcrumb-item active" aria-current="page">
				{{ $item ? 'Редактировать' : 'Добавить' }} часть конкурса
			</li>
		</ol>
	</nav>
	<h2 class="mt-4 mb-3">{{ $item ? 'Редактировать' : 'Добавить' }} часть конкурса</h2>
	<div>
		<form id="form" method="post" enctype="multipart/form-data" action="{{ $formAction }}">
			<input type="hidden" name="contest_id" value="{{ $contest->id }}">
			<input type="hidden" name="item_id" value="{{ $item->id ?? '' }}">
			@csrf
			@if ($errors->any())
				<div class="alert alert-danger" role="alert">
					{{ $errors->first() }}
				</div>
			@endif
			<div class="form-group">
				<label for="duration_hours">Длительность части конкурса</label>
				<input value="{{ $item->duration_hours ?? old('duration_hours') }}"
						 class="form-control @error ('duration_hours') is-invalid @enderror"
						 type="text"
						 name="duration_hours" id="duration_hours" placeholder="">
				@error ('duration_hours')
				<div class="invalid-feedback">
					{{ $errors->first('duration_hours') }}
				</div>
				@enderror
			</div>
			<div class="form-group">
				<label for="price_kzt">Стоимость части конкурса (тенге)</label>
				<input value="{{ $item->price_kzt ?? old('price_kzt') }}"
						 class="form-control @error ('price_kzt') is-invalid @enderror"
						 type="text"
						 name="price_kzt" id="price_kzt" placeholder="">
				@error ('price_kzt')
				<div class="invalid-feedback">
					{{ $errors->first('price_kzt') }}
				</div>
				@enderror
			</div>

			<br>
{{--			@if ($item)--}}
{{--			<h6 class="ml-4">--}}
{{--				<a href="/admin/contests/{{ $contest->id }}/tests">Редактировать тесты конкурса</a>--}}
{{--			</h6>--}}
{{--			@endif--}}

			<div class="form-group mt-2">
				<label for="plan">План конкурса</label>
				<div class="custom-file">
					<input class="custom-file-input @error ('plan') is-invalid @enderror"
							 type="file" id="plan" name="plan">
					<label class="custom-file-label" for="plan">Выберите файл</label>
					@error ('plan')
					<div class="invalid-feedback">
						{{ $errors->first('plan') }}
					</div>
					@enderror
				</div>
				@if ($item && $item->plan)
					<div class="mt-1">
						Используется:
						<a target="_blank" href="{{ $item->getUploadedUrl('plan') }}">план</a>
					</div>
				@endif
			</div>

			<script>
				let total_files = 1;

				function add_new_file() {
					if (total_files < 80) {
						document.getElementById('file_group_' + total_files).style.display = "block";
						total_files++;
					} else {
						alert('Число файлов не может быть больше 80ти!');
					}
				}
			</script>

			{{--            <div class="form-group mt-2">--}}
			{{--                <label for="file">Файл курса 1 (доступен после покупки)</label>--}}
			{{--                <div class="custom-file">--}}
			{{--                    <input class="custom-file-input @error('file') is-invalid @enderror"--}}
			{{--                           type="file" id="file" name="file">--}}
			{{--                    <label class="custom-file-label" for="file">Выберите файл</label>--}}
			{{--                  @error('file')--}}
			{{--						<div class="invalid-feedback">--}}
			{{--							{{ $errors->first('file') }}--}}
			{{--						</div>--}}
			{{--						@enderror--}}
			{{--					</div>--}}
			{{--					@if ($item && $item->file)--}}
			{{--						<div class="mt-1">--}}
			{{--							 Используется:--}}
			{{--							 <a target="_blank" href="{{ route('admin.downloadCoursePartFile', array_merge(compact('speciality', 'course'), ['part' => $item])) }}">--}}
			{{--									 файл--}}
			{{--							</a>--}}
			{{--					  </div>--}}
			{{--				 @endif--}}
			{{--			</div>--}}


			@foreach ($additional_files_orig as $additional_file)
				<div class="form-group mt-2" id="file_group_{{ $loop->iteration }}">
					<label for="file">Файл курса {{ $loop->iteration }} (доступен после покупки)</label>
					<div class="custom-file">
						<input class="custom-file-input" type="file" id="file{{ $loop->iteration + 1 }}" name="file {{ $loop->iteration + 1 }}">
						<label class="custom-file-label" for="file">Выберите файл</label>
					</div>
					<script>
						total_files++;
					</script>
					<div class="mt-1">
						Используется:
						<a target="_blank" href="{{ $additional_file }}">файл</a>
					</div>
				</div>
			@endforeach

			<input type="button" value="Добавить еще один файл" onClick="add_new_file()">
			<br><br>
			<button type="submit" class="btn btn-primary">Сохранить</button>
		</form>
	</div>
@endsection
