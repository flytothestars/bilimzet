@extends('layouts.base')

@section('content')

	@include('parts.profileMenu')

	<div class="width1088 page-title">
		<h1>@lang('tests.my_tests')</h1>
	</div>

	<div class="my-articles width1088">
		@foreach ($courses as $course)
			<div style="margin-bottom: 25px; font-size: 20px; color: #333">
				@lang('tests.course') <a style="color: #0C85D5" href="{{ route('course', ['id' => $course->id]) }}">{{ $course->title }}</a>
				<ul style="margin-left: 40px; font-size: 18px; line-height: 25px">
					@forelse ($course->tests as $test)
						<li>
							@lang('tests.test') <a style="color: #00b9ff">{{ $test->title }}</a>, @lang('tests.results'):
							@if ($test->total_answers > 0)
								<span style="color: green;">{{ $test->correct_answers }}/{{ $test->total_answers}}</span>
								@if ($test->certificateId > 0)
									<span style="color: green;">@lang('tests.out')</span>
								@else
									<span style="color: red;">@lang('tests.not_out')</span>
								@endif
							@else
								<span style="color: red;">@lang('tests.not_pass')</span>
							@endif

							@if ($test->no_cert)
								<input type="button" value="{{ $test->is_test ? __('retake') : __('pass') }}"
										 onClick="window.location.href='{{ route('viewTest', ['id' => $test->id]) }}'">
							@endif
						</li>
					@empty
						<li><i>@lang('tests.no_tests')</i></li>
					@endforelse
				</ul>
			</div>
		@endforeach
	</div>

@endsection
