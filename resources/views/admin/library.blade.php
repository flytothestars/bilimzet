@extends('layouts.admin')

@section('content')

    <h2 class="mt-4 mb-3">Библиотека ({{ $items ? $items->total() : 0 }})</h2>

    @if ($items->count())
        <div class="mt-5 mb-4">
            {{ $items->links() }}
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>Опубликовано?</th>
                    <th>Категория</th>
                    <th>Заголовок</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->is_published ? 'Да' : 'Нет' }}</td>
                        <td>{{ $item->category }}</td>
                        <td>{{ $item->title }}</td>
                        <td>
                            <a href="{{ route('admin.editLibraryItem', ['id' => $item->id]) }}"
                               role="button" class="btn btn-primary btn-sm mr-2">Редактировать</a>
                            <form style="display: inline-block" method="post"
                                  action="{{ route('admin.destroyLibraryItem', ['id' => $item->id]) }}">
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
        <p>Нет статей</p>
    @endif

@endsection
