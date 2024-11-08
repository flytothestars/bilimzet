@extends('layouts.admin')

@section('content')
    <h2 class="mt-4 mb-3">Результаты тестов ({{ $items ? $items->total() : 0 }})</h2>
    @if($items->count())
        <div class="mt-5 mb-4">
            {{ $items->links() }}
        </div>
        @if(session('message'))
            <div class="alert alert-primary" role="alert">
                {{ session('message') }}
            </div>
        @endif
        <p>Дата загрузки страницы: {{ \Carbon\Carbon::now()->format('d.m.Y H:i') }} UTC</p>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>Пользователь</th>
                    <th>Специализация</th>
                    <th>Курс</th>
                    <th>Тест</th>
                    <th>Дата прохождения</th>
                    <th>Результат</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>
                            <a href="{{ route('admin.viewUser', ['id' => $item->user->id]) }}">
                                {{ $item->user->full_name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.editSpeciality', ['speciality' => $item->test->course->speciality]) }}">
                                {{ $item->test->course->speciality->title }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.editCourse', [
                                    'speciality' => $item->test->course->speciality,
                                    'course' => $item->test->course
                                ]) }}">
                                {{ $item->test->course->title }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.editCourseTest', [
                                    'speciality' => $item->test->course->speciality,
                                    'course' => $item->test->course,
                                    'test' => $item->test
                                ]) }}">
                                {{ $item->test->title }}
                            </a>
                        </td>
                        <td>{{ $item->finished_at->format('d.m.Y H:i') }} UTC</td>
                        <td>{{ $item->getPrettyResult() }}</td>
                        <td>
                            @if($item->certificate && $item->certificate->is_issued)
                                <a href="{{ route('admin.previewCertificate', ['id' => $item->id,
                                        'certId' => $item->certificate->id]) }}"
                                   class="btn btn-success btn-sm mr-2" role="button">
                                    Посмотреть сертификат
                                </a>
                            @elseif($item->certificate && !$item->certificate->is_issued)
                                <a href="{{ route('admin.previewCertificate', ['id' => $item->id,
                                        'certId' => $item->certificate->id]) }}"
                                   class="btn btn-warning btn-sm mr-2" role="button">
                                    Продолжить выдачу сертификата
                                </a>
                            @else
                                <a href="{{ route('admin.createCertificate', ['id' => $item->id]) }}"
                                   class="btn btn-primary btn-sm mr-2" role="button">
                                    Выдать сертификат
                                </a>
                            @endif
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
        <p>Нет результатов</p>
    @endif
@endsection
