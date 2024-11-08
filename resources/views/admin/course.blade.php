@extends('layouts.admin')

@section('content')
    <nav aria-label="breadcrumb" class="mt-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.specialities') }}">Специализации</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.editSpeciality', ['speciality' => $speciality]) }}">
                    {{ $speciality->title }}
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.courses', ['speciality' => $speciality]) }}">Курсы</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $item ? 'Редактировать' : 'Добавить' }} курс</li>
        </ol>
    </nav>
    <h2 class="mt-4 mb-3">{{ $item ? 'Редактировать' : 'Добавить' }} курс</h2>
    <div>
        @if ($item)
            <p><a href="{{ route('course', ['id' => $item->id]) }}" target="_blank">Открыть на сайте</a></p>
        @endif
        <form id="form" method="post" enctype="multipart/form-data" action="{{ $formAction }}">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif
            <fieldset class="mt-4">
                <legend>Курс</legend>
                <div class="form-group">
                    <label for="title">Название курса ru</label>
                    <input value="{{ $item->title ?? old('title') }}"
                           class="form-control @error ('title') is-invalid @enderror"
                           type="text" name="title" id="title" placeholder="">
                    @error ('title')
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                    @enderror
                </div>
					<div class="form-group">
						<label for="title_kz">Название курса kz</label>
						<input value="{{ $item->title_kz ?? old('title_kz') }}"
								 class="form-control @error ('title_kz') is-invalid @enderror"
								 type="text" name="title_kz" id="title_kz" placeholder="">
						@error ('title_kz')
						<div class="invalid-feedback">
							{{ $errors->first('title_kz') }}
						</div>
						@enderror
					</div>
            </fieldset>
            <fieldset class="mt-4">
                <legend>Автор</legend>
                <div class="form-group">
                    <label for="author_fio">ФИО автора ru</label>
                    <input value="{{ $item->author_fio ?? old('author_fio') }}"
                           class="form-control @error ('author_fio') is-invalid @enderror"
                           type="text"
                           name="author_fio" id="author_fio" placeholder="">
                    @error ('author_fio')
							  <div class="invalid-feedback">
									{{ $errors->first('author_fio') }}
							  </div>
                    @enderror
                </div>
					<div class="form-group">
						<label for="author_fio_kz">ФИО автора kz</label>
						<input value="{{ $item->author_fio_kz ?? old('author_fio_kz') }}"
								 class="form-control @error ('author_fio_kz') is-invalid @enderror"
								 type="text"
								 name="author_fio_kz" id="author_fio_kz" placeholder="">
						@error ('author_fio_kz')
						<div class="invalid-feedback">
							{{ $errors->first('author_fio_kz') }}
						</div>
						@enderror
					</div>
                <div class="form-group">
                    <label for="author_position">Должность автора ru</label>
                    <input value="{{ $item->author_position ?? old('author_position') }}"
                           class="form-control @error ('author_position') is-invalid @enderror"
                           type="text"
                           name="author_position" id="author_position" placeholder="">
                    @error ('author_position')
                    <div class="invalid-feedback">
                        {{ $errors->first('author_position') }}
                    </div>
                    @enderror
                </div>
					<div class="form-group">
						<label for="author_position_kz">Должность автора kz</label>
						<input value="{{ $item->author_position_kz ?? old('author_position_kz') }}"
								 class="form-control @error ('author_position_kz') is-invalid @enderror"
								 type="text"
								 name="author_position_kz" id="author_position_kz" placeholder="">
						@error ('author_position_kz')
						<div class="invalid-feedback">
							{{ $errors->first('author_position_kz') }}
						</div>
						@enderror
					</div>
                <div class="form-group mt-2">
                    <label for="author_photo">Фото автора</label>
                    <div class="custom-file">
                        <input class="custom-file-input @error('author_photo') is-invalid @enderror"
                               type="file" id="author_photo" name="author_photo">
                        <label class="custom-file-label" for="author_photo">Выберите файл</label>
                        @error('author_photo')
                        <div class="invalid-feedback">
                            {{ $errors->first('author_photo') }}
                        </div>
                        @enderror
                    </div>
                    @if($item && $item->author_photo)
                        <div class="mt-1">
                            Используется:
                            <a target="_blank" href="{{ $item->getUploadedUrl('author_photo') }}">фото</a>
                        </div>
                    @endif
                </div>
            </fieldset>
            @if($item)
                <fieldset class="mt-4">
                    <legend>Содержимое курса</legend>
                    <h6 class="ml-4">
                        <a href="{{ $partsRoute }}">Редактировать части
                            курса</a>
                    </h6>
                    <!---<h6 class="ml-4">
                        <a href="{{ $testsRoute }}">Редактировать тесты
                            курса</a>
                    </h6>
					--->
                </fieldset>
            @endif
            <fieldset class="mt-4">
                <legend>Подробности</legend>
                <div class="form-group">
                    <label for="desc_text">Описание курса ru</label>
                    <textarea class="form-control @error('desc_text') is-invalid @enderror"
                              name="desc_text" id="desc_text"
                              rows="6">{{ $item->desc_text ?? old('desc_text') }}</textarea>
                    @error ('desc_text')
                    <div class="invalid-feedback">
                        {{ $errors->first('desc_text') }}
                    </div>
                    @enderror
                </div>
					<div class="form-group">
						<label for="desc_text_kz">Описание курса kz</label>
						<textarea class="form-control @error('desc_text_kz') is-invalid @enderror"
									 name="desc_text_kz" id="desc_text_kz"
									 rows="6">{{ $item->desc_text_kz ?? old('desc_text_kz') }}</textarea>
						@error ('desc_text_kz')
						<div class="invalid-feedback">
							{{ $errors->first('desc_text_kz') }}
						</div>
						@enderror
					</div>
                <div class="form-group">
                    <label for="listeners_category_text">Категория слушателей ru</label>
                    <textarea class="form-control @error ('listeners_category_text') is-invalid @enderror"
                              name="listeners_category_text" id="listeners_category_text"
                              rows="6">{{ $item->listeners_category_text ?? old('listeners_category_text') }}</textarea>
                    @error ('listeners_category_text')
                    <div class="invalid-feedback">
                        {{ $errors->first('listeners_category_text') }}
                    </div>
                    @enderror
                </div>
					<div class="form-group">
						<label for="listeners_category_text_kz">Категория слушателей kz</label>
						<textarea class="form-control @error ('listeners_category_text_kz') is-invalid @enderror"
									 name="listeners_category_text_kz" id="listeners_category_text_kz"
									 rows="6">{{ $item->listeners_category_text_kz ?? old('listeners_category_text_kz') }}</textarea>
						@error ('listeners_category_text_kz')
						<div class="invalid-feedback">
							{{ $errors->first('listeners_category_text_kz') }}
						</div>
						@enderror
					</div>
                <div class="form-group">
                    <label for="goals_text">Цели курса ru</label>
                    <textarea class="form-control @error('goals_text') is-invalid @enderror"
                              name="goals_text" id="goals_text"
                              rows="6">{{ $item->goals_text ?? old('goals_text') }}</textarea>
                    @error ('goals_text')
                    <div class="invalid-feedback">
                        {{ $errors->first('goals_text') }}
                    </div>
                    @enderror
                </div>
					<div class="form-group">
						<label for="goals_text_kz">Цели курса kz</label>
						<textarea class="form-control @error('goals_text_kz') is-invalid @enderror"
									 name="goals_text_kz" id="goals_text_kz"
									 rows="6">{{ $item->goals_text_kz ?? old('goals_text_kz') }}</textarea>
						@error ('goals_text_kz')
						<div class="invalid-feedback">
							{{ $errors->first('goals_text_kz') }}
						</div>
						@enderror
					</div>
                <div class="form-group">
                    <label for="tasks_text">Задачи курса ru</label>
                    <textarea class="form-control @error('tasks_text') is-invalid @enderror"
                              name="tasks_text" id="tasks_text"
                              rows="6">{{ $item->tasks_text ?? old('tasks_text') }}</textarea>
                    @error ('tasks_text')
                    <div class="invalid-feedback">
                        {{ $errors->first('tasks_text') }}
                    </div>
                    @enderror
                </div>
					<div class="form-group">
						<label for="tasks_text_kz">Задачи курса kz</label>
						<textarea class="form-control @error('tasks_text_kz') is-invalid @enderror"
									 name="tasks_text_kz" id="tasks_text_kz"
									 rows="6">{{ $item->tasks_text_kz ?? old('tasks_text_kz') }}</textarea>
						@error ('tasks_text_kz')
						<div class="invalid-feedback">
							{{ $errors->first('tasks_text_kz') }}
						</div>
						@enderror
					</div>
                <div class="form-group">
                    <label for="organization_text">Организация образовательного процесса, формы и методы, оценка
                        результатов ru</label>
                    <textarea class="form-control @error('organization_text') is-invalid @enderror"
                              name="organization_text" id="organization_text"
                              rows="6">{{ $item->organization_text ?? old('organization_text') }}</textarea>
                    @error ('organization_text')
                    <div class="invalid-feedback">
                        {{ $errors->first('organization_text') }}
                    </div>
                    @enderror
                </div>
					<div class="form-group">
						<label for="organization_text_kz">Организация образовательного процесса, формы и методы, оценка
							результатов kz</label>
						<textarea class="form-control @error('organization_text_kz') is-invalid @enderror"
									 name="organization_text_kz" id="organization_text_kz"
									 rows="6">{{ $item->organization_text_kz ?? old('organization_text_kz') }}</textarea>
						@error ('organization_text_kz')
						<div class="invalid-feedback">
							{{ $errors->first('organization_text_kz') }}
						</div>
						@enderror
					</div>
            </fieldset>
            <button type="submit" name="_save_opt" value="" class="mt-2 btn btn-success">Сохранить</button>
            <button type="submit" name="_save_opt" value="add_test" class="mt-2 ml-3 btn btn-primary">
                Сохранить и добавить тест
            </button>
            <button type="submit" name="_save_opt" value="add_part" class="mt-2 ml-3 btn btn-primary">
                Сохранить и добавить часть курса
            </button>
        </form>
    </div>
@endsection
