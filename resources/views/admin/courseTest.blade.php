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
            <li class="breadcrumb-item active" aria-current="page">
                {{ $item ? 'Редактировать' : 'Добавить' }} тест курса
            </li>
        </ol>
    </nav>
    <h2 class="mt-4 mb-3">{{ $item ? 'Редактировать' : 'Добавить' }} тест курса</h2>
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
                <label for="title">Название теста ru</label>
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
				  <label for="title_kz">Название теста kz</label>
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
            <div class="form-group">
                <label for="duration_minutes">Длительность (минут)</label>
                <input value="{{ $item->duration_minutes ?? old('duration_minutes') }}"
                       class="form-control @error('duration_minutes') is-invalid @enderror"
                       type="text"
                       name="duration_minutes" id="duration_minutes" placeholder="">
                @error('duration_minutes')
                <div class="invalid-feedback">
                    {{ $errors->first('duration_minutes') }}
                </div>
                @enderror
            </div>
            <button type="submit" name="_save_opt" value="" class="btn btn-success">Сохранить</button>
            <button type="submit" name="_save_opt" value="add_question" class="ml-3 btn btn-primary">
                Сохранить и добавить вопрос
            </button>
        </form>
        @if($item)
            @include('admin.parts.courseTestQuestions', ['items' => $questions, 'test' => $item])
        @endif
    </div>
@endsection
