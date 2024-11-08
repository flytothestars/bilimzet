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
                Тесты
            </li>
        </ol>
    </nav>
    <h2 class="mt-4 mb-3">Тесты курса ({{ $items ? $items->count() : 0 }})</h2>
    <div class="mb-3" style="text-align: right">
        <a role="button" href="{{ route('admin.createCourseTest', compact('speciality', 'course')) }}"
           class="btn btn-primary btn-sm mr-2">Добавить</a>
    </div>
    @if ($items->count())
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Время выполнения (минут)</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $test)
                    <tr>
                        <td>{{ $test->title }}</td>
                        <td>{{ $test->duration_minutes }}</td>
                        <td>
                            <a href="{{ route('admin.editCourseTest', compact('speciality', 'course', 'test')) }}"
                               role="button" class="btn btn-primary btn-sm mr-2">Редактировать</a>
                            <form style="display: inline-block" method="post"
                                  action="{{ route('admin.destroyCourseTest', compact('speciality', 'course', 'test')) }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm mr-2">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Нет тестов</p>
    @endif

@endsection
