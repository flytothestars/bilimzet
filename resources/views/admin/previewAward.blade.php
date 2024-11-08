@extends('layouts.admin')

@section('content')

    <nav aria-label="breadcrumb" class="mt-4">
        <ol class="breadcrumb">
			  <li class="breadcrumb-item"><a href="{{ route('admin.contestFiles') }}">Файлы конкуров</a></li>
            <li class="breadcrumb-item active" aria-current="page">Просмотр награды</li>
        </ol>
    </nav>

    <h2 class="mt-4 mb-3">Просмотр награды</h2>

    <div>
        <p class="mt-3" style="font-size: 1.2rem">{{ $award->title }}</p>
        <div class="mt-4 mb-4">
            <a target="_blank" href="{{ $award->certificate->getUploadedUrl('file') }}">
                <img style="max-width: 100%; max-height: 500px;" src="{{ $award->certificate->getUploadedUrl('file') }}" alt="нажмите для увеличения">
            </a>
        </div>

        <form action="{{ route('admin.deleteAward', [ 'contestFile' => $contestFile->id, 'award' => $award->id ]) }}" method="post">
            @csrf
            <button type="submit" name="_save_opt" value="delete" class="mt-2 mr-3 btn btn-danger">
                Удалить награду
            </button>
        </form>

    </div>

@endsection
