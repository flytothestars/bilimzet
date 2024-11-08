@extends('layouts.admin')

@section('content')

	<h2 class="mt-4 mb-3">Гайды ({{ $items ? $items->total() : 0 }})</h2>
	<div class="mb-3" style="text-align: right">
		<a role="button" href="{{ route('admin.guide.create') }}" class="btn btn-primary btn-sm mr-2">Добавить</a>
	</div>
	@if($items->count())
		<div class="mt-5 mb-4">
			{{ $items->links() }}
		</div>
		<div class="table-responsive">
			<table class="table table-striped table-sm">
				<thead>
				<tr>
					<th>Название</th>
					<th>Действия</th>
				</tr>
				</thead>
				<tbody>
				@foreach($items as $item)
					<tr>
						<td>{{ $item->title }}</td>
						<td>
							<a href="{{ route('admin.guide.edit', [ 'id' => $item->id ]) }}"
								role="button" class="btn btn-primary btn-sm mr-2">Редактировать</a>
							<form style="display: inline-block" method="post"
									action="{{ route('admin.guide.destroy', ['id' => $item->id]) }}">
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
		<p>Нет Гайдов</p>
	@endif

@endsection
