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
                Части
            </li>
        </ol>
    </nav>
    <h2 class="mt-4 mb-3">Части конкурса ({{ $items ? $items->count() : 0 }})</h2>
    <div class="mb-3" style="text-align: right">
        <a role="button" href="{{ route('admin.createContestPart', compact('contest')) }}"
           class="btn btn-primary btn-sm mr-2">Добавить</a>
    </div>
    @if($items->count())
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>Длительность (академических часов)</th>
                    <th>Стоимость (тенге)</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $part)
                    <tr>
                        <td>{{ $part->duration_hours }}</td>
                        <td>{{ $part->price_kzt }}</td>
                        <td>
                            <a href="{{ route('admin.editContestPart', compact('contest', 'part')) }}"
                               role="button" class="btn btn-primary btn-sm mr-2">Редактировать</a>
                            <form style="display: inline-block" method="post"
                                  action="{{ route('admin.destroyContestPart', compact('contest', 'part')) }}">
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
        <p>Нет частей конкурса</p>
    @endif
@endsection
