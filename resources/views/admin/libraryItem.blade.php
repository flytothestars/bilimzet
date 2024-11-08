@extends('layouts.admin')

@section('content')

    <h2 class="mt-4 mb-3">Редактировать статью</h2>
    <div>
        <form id="form" method="post" enctype="multipart/form-data"
              action="{{ route('admin.updateLibraryItem', ['id' => $item->id]) }}">
            @csrf
            <div class="form-group">
                <label for="title">Заголовок статьи ru</label>
                <input value="{{ $item->title }}"
                       class="form-control @error('title') is-invalid @enderror"
                       type="text"
                       name="title" id="title" placeholder="">
                @error('title')
                <div class="invalid-feedback">
                    {{ $errors->first('title') }}
                </div>
                @enderror
            </div>
			  <div class="form-group">
				  <label for="title_kz">Заголовок статьи kz</label>
				  <input value="{{ $item->title_kz }}"
							class="form-control @error('title_kz') is-invalid @enderror"
							type="text"
							name="title_kz" id="title_kz" placeholder="">
				  @error('title_kz')
					  <div class="invalid-feedback">
						  {{ $errors->first('title_kz') }}
					  </div>
				  @enderror
			  </div>
            <div class="form-group mt-2">
                <label for="document">Документ</label>
                <div class="custom-file">
                    <input class="custom-file-input @error('document') is-invalid @enderror"
                           type="file" id="document" name="document">
                    <label class="custom-file-label" for="document">Выберите файл</label>
                    @error('document')
							  <div class="invalid-feedback">
									{{ $errors->first('document') }}
							  </div>
                    @enderror
                </div>
                @if ($item && $item->document)
                    <div class="mt-1">
                        Используется:
                        <a target="_blank" href="{{ $item->documentUrl }}">документ</a>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="category">Категория</label>
                <select class="form-control" name="category" id="category">
                    @if ($item->isCustomCategory())
                        <option selected value="{{ $item->category }}">
                            Другой ({{ $item->category }})
                        </option>
                    @endif
                    @foreach ($categoryNames as $value)
                        <option {{ $item->category === $value ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group form-check mt-2">
                <input type="checkbox" name="is_published"
                       {{ $item->is_published ? 'checked' : '' }}
                       class="form-check-input" id="is_published" value="true">
                <label class="form-check-label" for="is_published">Опубликовать?</label>
            </div>
            <div class="form-group">
                <label for="text">Текст ru</label>
                <textarea class="form-control @error('text') is-invalid @enderror"
                          name="text" id="text" rows="6">{{ $item->text ?? old('text') }}</textarea>
                @error ('text')
                <div class="invalid-feedback">
                    {{ $errors->first('text') }}
                </div>
                @enderror
            </div>
			  <div class="form-group">
				  <label for="text_kz">Текст kz</label>
				  <textarea class="form-control @error('text') is-invalid @enderror"
								name="text_kz" id="text_kz" rows="6">{{ $item->text_kz ?? old('text_kz') }}</textarea>
				  @error ('text_kz')
					  <div class="invalid-feedback">
						  {{ $errors->first('text_kz') }}
					  </div>
				  @enderror
			  </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>

@endsection
