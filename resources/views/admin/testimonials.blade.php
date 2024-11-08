@extends('layouts.admin')

@section('content')

    <h2 class="mt-4 mb-3">Отзывы</h2>
	 <h3>Курсы {{ $items ? $items->total() : 0 }} ({{ $items_new }})</h3>
    @if ($items->count())
        <div class="mt-5 mb-4">
            {{ $items->links() }}
        </div>
        <p>Дата загрузки страницы: {{ \Carbon\Carbon::now()->format('d.m.Y H:i') }} UTC</p>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>Пользователь</th>
                    <th>Курс</th>
                    <th>Текст отзыва</th>
                    <th>Дата</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>
                            <a href="{{ route('admin.viewUser', ['id' => $item->user->id]) }}">
                                {{ $item->user->full_name }}
                            </a>
                        </td>
                        <td>
                        {{$item->course->title}}
                        </td>
                        <td>
									@if (!$item->viewed) <b> @endif
                           	{{ $item->text }}
									@if (!$item->viewed) </b> @endif
                        </td>
                        <td>
                            {{ $item->created_at->format('d.m.Y H:i') }} UTC
                        </td>
                        <td>
									@if (!$item->viewed)
										<form style="display: inline-block" method="post"
												action="{{ route('admin.viewedTestimonial', ['id' => $item->id]) }}">
											@csrf
											<button type="submit" class="btn btn-info btn-sm mr-2">Просмотрено</button>
										</form>
									@endif

                           <form style="display: inline-block" method="post"
                                  action="{{ route('admin.destroyTestimonial', ['id' => $item->id]) }}">
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
        <p>Нет отзывов</p>
    @endif

	 <h3>Конкурсы {{ $contests ? $contests->total() : 0 }} ({{ $contests_new }})</h3>
	 @if ($contests->count())
		 <div class="mt-5 mb-4">
			 {{ $contests->links() }}
		 </div>
		 <p>Дата загрузки страницы: {{ \Carbon\Carbon::now()->format('d.m.Y H:i') }} UTC</p>
		 <div class="table-responsive">
			 <table class="table table-striped table-sm">
				 <thead>
				 <tr>
					 <th>Пользователь</th>
					 <th>Текст отзыва</th>
					 <th>Дата</th>
					 <th>Действия</th>
				 </tr>
				 </thead>
				 <tbody>
				 @foreach ($contests as $item)
					 <tr>
						 <td>
							 <a href="{{ route('admin.viewUser', ['id' => $item->user->id]) }}">
								 {{ $item->user->full_name }}
							 </a>
						 </td>
						 <td>
							 @if (!$item->viewed) <b> @endif
								 {{ $item->text }}
							 @if (!$item->viewed) </b> @endif
						 </td>
						 <td>
							 {{ $item->created_at->format('d.m.Y H:i') }} UTC
						 </td>
						 <td>
							 @if (!$item->viewed)
								 <form style="display: inline-block" method="post"
										 action="{{ route('admin.viewedContestTestimonial', ['id' => $item->id]) }}">
									 @csrf
									 <button type="submit" class="btn btn-info btn-sm mr-2">Просмотрено</button>
								 </form>
							 @endif

							 <form style="display: inline-block" method="post"
									 action="{{ route('admin.destroyContestTestimonial', ['id' => $item->id]) }}">
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
			 {{ $contests->links() }}
		 </div>
	 @else
		 <p>Нет отзывов</p>
	 @endif

@endsection
