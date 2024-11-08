@extends('layouts.admin')

@section('content')

	<h2 class="mt-4 mb-3">Чат с {{ $user->full_name }}</h2>

	<div id="app" class="chat container">
		<chat chatroom="{{ $chatroom->id }}" user="{{ $user->id }}"></chat>
	</div>

{{--	<div class="chat container">--}}
{{--		@foreach ($chatroom->messages as $message)--}}
{{--			<div class="row message {{ $message->sender->id == $user->id ? 'user' : 'agent' }}">--}}
{{--				<p>{{ $message->message }}</p>--}}
{{--			</div>--}}
{{--		@endforeach--}}

{{--		<form action="{{ route('admin.chat.store', [ 'chatroom' => $chatroom->id ]) }}" method="post">--}}
{{--			@csrf--}}
{{--			<div class="row">--}}
{{--				<div class="col-8">--}}
{{--					<textarea name="body" class="form-control"></textarea>--}}
{{--				</div>--}}
{{--				<div class="col-4">--}}
{{--					<button type="submit" class="btn btn-success">Отправить</button>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--		</form>--}}
{{--	</div>--}}

	@push('scripts')
		<script src="{{ mix('/js/app.min.js') }}"></script>
	@endpush

@endsection
