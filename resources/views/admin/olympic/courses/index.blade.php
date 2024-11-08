@extends('layouts.admin')

@section('content')

    <h2 class="mt-4 mb-3">Курсов ({{ $courses ? $courses->total() : 0 }})</h2>
    <div class="mb-3" style="text-align: right">
        <a role="button" href="{{ route('admin.olympic.courses.create') }}" class="btn btn-primary btn-sm mr-2">Добавить</a>
    </div>
    @if($courses->count())
        <div class="mt-5 mb-4">
            {{ $courses->links() }}
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Классификация</th>
                    <th>Участник</th>
                    <th>Направление</th>
                    <th>Цена</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($courses as $course)
                    <tr>
                        <td>{{ $course->title }}</td>
                        <td>{{ $course->classification->name }}</td>
                        <td>{{ $course->member->name }}</td>
                        <td>{{ $course->subject->name }}</td>
                        <td>{{ $course->price }}</td>
                        <td>
                            <a href="{{ route('admin.olympic.courses.edit', $course->id)}}"
                               role="button" class="btn btn-primary btn-sm mr-2">Редактировать</a>
                            <form style="display: inline-block" method="post" action="{{ route('admin.olympic.courses.destroy', $course->id) }}">
                                @method('DELETE')
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
            {{ $courses->links() }}
        </div>
    @else
        <p>Нет Курсов</p>
    @endif

@endsection
