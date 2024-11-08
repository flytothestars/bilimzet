@extends('layouts.admin')

@section('content')

	<h2 class="mt-4 mb-3">Файлы конкурсов ({{ $items ? $items->total() : 0 }})</h2>

	@if ($items->count())
		<div class="mt-5 mb-4">
			{{ $items->links() }}
		</div>
		@if (session('message'))
			<div class="alert alert-primary" role="alert">
				{{ session('message') }}
			</div>
		@endif
		<p>Дата загрузки страницы: {{ \Carbon\Carbon::now()->format('d.m.Y H:i') }} UTC</p>
		<div class="table-responsive">
			<table class="table table-striped table-sm">
				<thead>
				<tr>
					<th>Пользователь</th>
					<th>Конкурс</th>
					<th>Дата загрузки</th>
					<th>Файл</th>
					<th>Видео</th>
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
							<a href="{{ route('admin.editContest', [ 'contest' => $item->contest ]) }}">
								{{ $item->contest->title }}
							</a>
						</td>
						<td>{{ $item->updated_at ? $item->updated_at->format('d.m.Y H:i') . 'UTC' : 'нет' }}</td>
						<td>
							<div class="link file">
								@foreach (explode(';', $item->file) as $file)
									<a href="{{ '/uploads/contest_files/' . $file }}" target="_blank">{{ $file }}</a>
								@endforeach
							</div>
						</td>
						<td>
							<div class="link video">
								@foreach (explode(';', $item->video) as $video)
									<a href="{{ $video }}" target="_blank">{{ $video }}</a>
								@endforeach
							</div>
						</td>
						<td>
							@if ($item->award)
								<a href="{{ route('admin.previewAward', [ 'contestFile' => $item->id, 'award' => $item->award->id ]) }}" class="btn btn-success btn-sm mr-2" role="button">
									Посмотреть награду
								</a>
								<form action="{{ route('admin.deleteAward', [ 'contestFile' => $item->id, 'award' => $item->award->id ]) }}" method="post">
									@csrf
									<button type="submit" name="_save_opt" value="delete" class="mt-2 mr-3 btn btn-danger">
										Удалить награду
									</button>
								</form>
							@else
								<a href="{{ route('admin.createAward', [ 'contestFile' => $item->id ]) }}" class="btn btn-primary btn-sm mr-2" role="button">
									Выдать награду
								</a>
							@endif
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
		<p>Нет файлов</p>
	@endif

@endsection
