@extends('layouts.admin')

@section('content')

    <nav aria-label="breadcrumb" class="mt-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.news') }}">Новости</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $item ? 'Редактировать' : 'Добавить' }}
                новость
            </li>
        </ol>
    </nav>
    <h2 class="mt-4 mb-3">{{ $item ? 'Редактировать' : 'Добавить' }} новость</h2>
    <div>
        @if ($item)
            <p><a href="{{ route('newPost', ['id' => $item->id]) }}"
                  target="_blank">Открыть на сайте</a></p>
        @endif
        <form id="form" method="post" enctype="multipart/form-data" action="{{ $formAction }}">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif
            <div class="form-group">
                <label for="name">Название новости ru</label>
                <input value="{{ $item->name ?? old('name') }}"
                       class="form-control @error('name') is-invalid @enderror"
                       type="text"
                       name="name" id="name" placeholder="">
                @error('name')
                <div class="invalid-feedback">
                    {{ $errors->first('name') }}
                </div>
                @enderror
            </div>
			  <div class="form-group">
				  <label for="name_kz">Название новости kz</label>
				  <input value="{{ $item->name_kz ?? old('name_kz') }}"
							class="form-control @error('name_kz') is-invalid @enderror"
							type="text"
							name="name_kz" id="name_kz" placeholder="">
				  @error('name_kz')
				  <div class="invalid-feedback">
					  {{ $errors->first('name_kz') }}
				  </div>
				  @enderror
			  </div>
            <div class="form-group mt-2">
                <label for="picture">Миниатюра</label>
                <div class="custom-file">
                    <input class="custom-file-input @error('picture') is-invalid @enderror"
                           type="file" id="picture" name="miniature">
                    <label class="custom-file-label" for="picture">Выберите файл</label>
                    @error('miniature')
							  <div class="invalid-feedback">
									{{ $errors->first('miniature') }}
							  </div>
                    @enderror
                </div>
                @if ($item && $item->miniature)
                    <div class="mt-1">
                        Используется:
                        <a target="_blank" href="{{ $item->getUploadedUrl('miniature') }}">картинка</a>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="text">Контент новости ru</label>
                <textarea class="summernote" name="text" id="text" style="width:700px;height:550px">{{ $item->text ?? old('text') }}</textarea>
            </div>
			  <div class="form-group">
				  <label for="text_kz">Контент новости kz</label>
				  <textarea class="summernote" name="text_kz" id="text_kz" style="width:700px;height:550px">{{ $item->text_kz ?? old('text_kz') }}</textarea>
			  </div>
            @if($item)
                <button type="submit" name="_save_opt" value="save" class="mt-2 btn btn-success">Сохранить</button>
            @else
                <button type="submit" name="_save_opt" value="add_course" class="mt-2 ml-3 btn btn-primary">
                    Сохранить и добавить новость
                </button>
            @endif
        </form>
    </div>

@endsection
