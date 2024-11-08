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
            <li class="breadcrumb-item active" aria-current="page">
                Курсы
            </li>
        </ol>
    </nav>
    <h2 class="mt-4 mb-3">Курсы ({{ $items ? $items->total() : 0 }})</h2>
    <div class="mb-3" style="text-align: right">
        <a role="button" href="{{ route('admin.createCourse', compact('speciality')) }}"
           class="btn btn-primary btn-sm mr-2">Добавить</a>
    </div>
    @if($items->count())
        <div class="mt-5 mb-4">
            {{ $items->links() }}
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $course)
                    <tr>
                        <td>{{ $course->title }}</td>
                        <td>
                            <a href="{{ route('admin.editCourse', compact('speciality', 'course')) }}"
                               role="button" class="btn btn-primary btn-sm mr-2">Редактировать</a>
                            <form style="display: inline-block" method="post"
                                  action="{{ route('admin.destroyCourse', compact('speciality', 'course')) }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm mr-2">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $items->links() }}
        </div>
    @else
        <p>Нет Курсов</p>
    @endif
@endsection
