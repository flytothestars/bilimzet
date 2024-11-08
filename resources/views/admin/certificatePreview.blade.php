@extends('layouts.admin')

@section('content')
    <nav aria-label="breadcrumb" class="mt-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.testResults') }}">Результаты
                    тестов</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                Просмотр сертификата
            </li>
        </ol>
    </nav>
    <h2 class="mt-4 mb-3">Просмотр сертификата</h2>
    <div>
        <p class="mt-3" style="font-size: 1.2rem">{{ $item->title }}</p>
        <div class="mt-4 mb-4">
            <a target="_blank" href="{{ $item->getUploadedUrl('file') }}">
                <img style="max-width: 100%; max-height: 500px;"
                     src="{{ $item->getUploadedUrl('file') }}"
                     alt="нажмите для увеличения">
            </a>
        </div>

        <form id="form" method="post" enctype="multipart/form-data"
              action="{{ $formAction }}">
            @csrf

            @if(!$item->is_issued)
                <button type="submit" name="_save_opt" value="issue" class="mt-2 mr-3 btn btn-success">
                    Выдать сертификат
                </button>
                <button type="submit" name="_save_opt" value="edit" class="mt-2 mr-3 btn btn-warning">
                    Изменить текст
                </button>
            @endif
            <button type="submit" name="_save_opt" value="delete" class="mt-2 mr-3 btn btn-danger">
                Удалить сертификат
            </button>
        </form>

    </div>
@endsection
