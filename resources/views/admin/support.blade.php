@extends('layouts.admin')

@section('content')
	<h2 class="mt-4 mb-3">Служба поддержки</h2>
	@if ($chatrooms->count())
{{--		<div class="mt-5 mb-4">--}}
{{--			{{ $chatrooms->links() }}--}}
{{--		</div>--}}
		<div class="table-responsive">
			<table class="table table-striped table-sm">
				<thead>
				<tr>
					<th>Дата изменения</th>
					<th>ФИО</th>
					<th>Сообщение</th>
					<th>Действия</th>
				</tr>
				</thead>
				<tbody>
				<?php $chatrooms = collect($chatrooms);$sorted = $chatrooms->sortByDesc('updated_at'); ?>
				@foreach ($sorted as $chatroom)
					<tr>
						<td>
								{{ $chatroom->updated_at }}
						</td>
						<td>
							@if (!$chatroom->viewed) <b> @endif
								{{ $chatroom->full_name }}
							@if (!$chatroom->viewed) </b> @endif
						</td>
						<td>
							@if (!$chatroom->viewed) <b> @endif
								{!! $chatroom->message !!}
							@if (!$chatroom->viewed) </b> @endif
						</td>
						<td>
							<a href="{{ route('admin.chat', [ 'chatroom' => $chatroom->id ]) }}"
								role="button" class="btn btn-primary btn-sm mr-2">Чат</a>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
{{--		<div class="mt-3">--}}
{{--			{{ $chatrooms->links() }}--}}
{{--		</div>--}}
	@else
		<p>Нет чатов</p>
	@endif
@endsection
