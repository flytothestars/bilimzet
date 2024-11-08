@extends('layouts.admin')

@section('content')
    <nav aria-label="breadcrumb" class="mt-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.specialities') }}">Специализации</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.editSpeciality', compact('speciality')) }}">
                    {{ $speciality->title }}
                </a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('admin.courses', compact('speciality')) }}">Курсы</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.editCourse', compact('speciality', 'course')) }}">
                    {{ $course->title }}
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.courseTests', compact('speciality', 'course')) }}">Тесты</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.editCourseTest', compact('speciality', 'course', 'test')) }}">
                    {{ $test->title }}
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ $item ? 'Редактировать' : 'Добавить' }} вопрос
            </li>
        </ol>
    </nav>
    <h2 class="mt-4 mb-3">{{ $item ? 'Редактировать' : 'Добавить' }} вопрос</h2>
    <div>
        <form id="form" method="post" enctype="multipart/form-data"
              action="{{ $formAction }}">
            @csrf
            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif
            <div class="form-group">
                <label for="title">Заголовок вопроса ru</label>
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
				  <label for="title_kz">Заголовок вопроса kz</label>
				  <input value="{{ $item->title_kz ?? old('title_kz') ?? '' }}"
							class="form-control @error('title_kz') is-invalid @enderror"
							type="text"
							name="title_kz" id="title_kz" placeholder="">
				  @error('title_kz')
				  <div class="invalid-feedback">
					  {{ $errors->first('title_kz') }}
				  </div>
				  @enderror
			  </div>
            <div class="form-group">
                <label for="correct_answer">Правильный ответ ru</label>
                <input value="{{ $item->correct_answer ?? old('correct_answer') }}"
                       class="form-control @error('correct_answer') is-invalid @enderror"
                       type="text"
                       name="correct_answer" id="correct_answer" placeholder="">
                @error('correct_answer')
                <div class="invalid-feedback">
                    {{ $errors->first('correct_answer') }}
                </div>
                @enderror
            </div>
			  <div class="form-group">
				  <label for="correct_answer_kz">Правильный ответ kz</label>
				  <input value="{{ $item->correct_answer_kz ?? old('correct_answer_kz') }}"
							class="form-control @error('correct_answer_kz') is-invalid @enderror"
							type="text"
							name="correct_answer_kz" id="correct_answer_kz" placeholder="">
				  @error('correct_answer_kz')
				  <div class="invalid-feedback">
					  {{ $errors->first('correct_answer_kz') }}
				  </div>
				  @enderror
			  </div>
            @for ($i = 0; $i < 3; $i++)
                <div class="form-group">
                    <label for="incorrect_answers_{{ $i }}">Неправильный ответ №{{ $i + 1 }} ru</label>
                    <input value="{{ $item->incorrect_answers[$i] ?? old("incorrect_answers.$i") }}"
                           class="form-control @error("incorrect_answers.$i") is-invalid @enderror"
                           type="text"
                           name="incorrect_answers[]" id="incorrect_answers_{{ $i }}" placeholder="">
                    @error("incorrect_answers.$i")
                    <div class="invalid-feedback">
                        {{ $errors->first("incorrect_answers.$i") }}
                    </div>
                    @enderror
                </div>
				  <div class="form-group">
					  <label for="incorrect_answers_kz_{{ $i }}">Неправильный ответ №{{ $i + 1 }} kz</label>
					  <input value="{{ $item->incorrect_answers_kz[$i] ?? old("incorrect_answers_kz.$i") }}"
								class="form-control @error("incorrect_answers_kz.$i") is-invalid @enderror"
								type="text"
								name="incorrect_answers_kz[]" id="incorrect_answers_kz_{{ $i }}" placeholder="">
					  @error("incorrect_answers_kz.$i")
					  <div class="invalid-feedback">
						  {{ $errors->first("incorrect_answers_kz.$i") }}
					  </div>
					  @enderror
				  </div>
            @endfor
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
@endsection
