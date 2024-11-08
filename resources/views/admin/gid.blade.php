@extends('layouts.admin')

@section('content')

    <style>
        .list-group a input{
            background: transparent;
            border: 0;
            color: #000;
        }

        .list-group a.active input,
        .list-group a.active input:active,
        .list-group a.active input:focus,
        .list-group a.active input:hover{
            color: #fff;
            border: 0;
            box-shadow: none;
            outline: 0;
            outline-offset: 0;
        }
    </style>
    <nav aria-label="breadcrumb" class="mt-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Админ</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                Гид
            </li>
        </ol>
    </nav>
    <h2 class="mt-4 mb-3">Гид</h2>
    <div>
        <form id="form" method="post" enctype="multipart/form-data" action="{{ route('admin.updateGid') }}">
            @csrf
            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="row">
                <div class="col-4">
                    <div class="list-group" id="list-tab" role="tablist">
                        @foreach($items as $item)
                            <a class="list-group-item list-group-item-action" data-id="{{ $item->id }}" id="list-{{ $item->id }}-list" data-toggle="list" href="#list-{{ $item->id }}" role="tab" aria-controls="list-{{ $item->id }}">
                                <input type="text" name="list[]" value="{{ $item->title }}">
										 <input type="text" name="list_kz[]" value="{{ $item->title_kz }}">
                                <input type="hidden" name="id[]" value="{{ $item->id }}">
                            </a>
                        @endforeach
                    </div>
                    <a class="btn btn-primary add_git" data-count="{{ count($items) }}">Добавить</a>
                    <input type="submit" class="btn btn-success" value="Сохранить">
                </div>
                <div class="col-8">
                    <div class="tab-content" id="nav-tabContent">
                        @foreach($items as $item)
                        <div class="tab-pane fade show" data-id="{{ $item->id }}" id="list-{{ $item->id }}" role="tabpanel" aria-labelledby="list-{{ $item->id }}-list">
                            <textarea name="tab[]" id="" style="width: 100%; height: 200px">{{ $item->text }}</textarea>
									<textarea name="tab_kz[]" id="" style="width: 100%; height: 200px">{{ $item->text_kz }}</textarea>
                            <label for="">Ссылка видео YouTube</label>
                            <input type="text" name="video[]" value="{{ $item->video }}">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </form>
    </div>

	 @push('scripts')
		 <script>
			 $(document).ready(function () {
				 $('.add_git').click(function (e) {
					 e.preventDefault();
					 let total = $(this).attr('data-count');
					 total = Number(total) + 1;
					 $(this).attr('data-count', total);
					 let list = '<a class="list-group-item list-group-item-action" data-id="'+total+'" id="list-'+total+'-list" data-toggle="list" href="#list-'+total+'" role="tab" aria-controls="list-'+total+'"><input type="text" name="list[]" value="..."><input type="hidden" name="id[]" value="'+total+'"></a>';
					 let tab = '<div class="tab-pane fade show" data-id="'+total+'" id="list-'+total+'" role="tabpanel" aria-labelledby="list-'+total+'-list"><textarea name="tab[]" id="" style="width: 100%; height: 200px"></textarea> <label for="">Ссылка видео YouTube</label><input name="video[]" type="text" value=""></div>';
					 $('.list-group').append(list);
					 $('.tab-content').append(tab);
				 })
			 })
		 </script>
	 @endpush

@endsection

