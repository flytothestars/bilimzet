@extends('layouts.admin')

@section('content')
    <h2 class="mt-4 mb-3">Запросы лекторов ({{ $items ? $items->total() : 0 }})</h2>
    @if($items->count())
        <div class="mt-5 mb-4">
            {{ $items->links() }}
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>ФИО</th>
                    <th>E-mail</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->full_name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>
                            <a href="{{ route('admin.viewUser', ['id' => $item->id]) }}"
                               role="button" class="btn btn-primary btn-sm mr-2">Просмотр</a>
                            <form style="display: inline-block" method="post"
                                  action="{{ route('admin.addLec', ['id' => $item->id]) }}">
                                @csrf
                                @if(!$item->isAdmin())
                                    <button type="submit" class="btn btn-danger btn-sm mr-2">Подтвердить</button>
                                @endif
                            </form>
                            <form style="display: inline-block" method="post"
                                  action="{{ route('admin.delLec', ['id' => $item->id]) }}">
                                @csrf
                                @if(!$item->isAdmin())
                                    <button type="submit" class="btn btn-danger btn-sm mr-2">Отменить</button>
                                @endif
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
        <p>Нет пользователей</p>
    @endif
    <h2 class="mt-4 mb-3">Список лекторов ({{ $items1 ? $items1->total() : 0 }})</h2>
    @if($items1->count())
        <div class="mt-5 mb-4">
            {{ $items1->links() }}
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>ФИО</th>
                    <th>E-mail</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items1 as $item)
                    <tr>
                        <td>{{ $item->full_name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>
                            <a href="{{ route('admin.viewUser', ['id' => $item->id]) }}"
                               role="button" class="btn btn-primary btn-sm mr-2">Просмотр</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $items1->links() }}
        </div>
    @else
        <p>Нет пользователей</p>
    @endif
@endsection
