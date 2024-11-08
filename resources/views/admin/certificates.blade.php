@extends('layouts.admin')

@section('content')
    <h2 class="mt-4 mb-3">Сертификаты ({{ $items ? $items->total() : 0 }})</h2>
    @if($items->count())
        <div class="mt-5 mb-4">
            {{ $items->links() }}
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>Пользователь</th>
                    <th>Название сертификата</th>
                    <th>Файл</th>
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
                            {{ $item->title }}
                        </td>
                        <td>
                            <a href="{{ $item->getUploadedUrl('file') }}" target="_blank">
                                открыть
                            </a>
                        </td>
                        <td>
                            <form style="display: inline-block" method="post"
                                  action="{{ route('admin.destroyCertificate', ['id' => $item->id]) }}">
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
        <p>Нет сертификатов</p>
    @endif
@endsection
