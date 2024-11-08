@extends('layouts.admin')

@section('content')
    <h2 class="mt-4 mb-3">Пользователи ({{ $items ? $items->total() : 0 }})</h2>
    @if($items->total() > 1)
        <div class="text-right">
            <form method="post" action="{{ route('admin.exportUsers') }}">
                @csrf
                <button role="button" class="btn btn-primary btn-sm mr-2">
                    Экспорт всех пользователей в Excel
                </button>
            </form>
        </div>
    @endif
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
                                  action="{{ route('admin.destroyUser', ['id' => $item->id]) }}">
                                @csrf
                                @if(!$item->isAdmin())
                                    <button type="submit" class="btn btn-danger btn-sm mr-2">Удалить</button>
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
@endsection
