@extends('layouts.base')

@section('content')

	<div class="specials">
		<div class="centered flex between align-center">
			<div class="left">
				<ul class="breadcrumbs">
					<li><a href="{{ route('index') }}">@lang('menu.index')</a></li>
					<li><a href="{{ route('specialities') }}">@lang('menu.courses')</a></li>
					<li>
						<a href="{{ route('specialities', ['tab' =>
                                \App\Data\CourseSpecialityTabs::getTabNumberForCategory($item->category)]) }}">
							{{ \App\Data\CourseSpecialityCategories::getParentCategory($item->category) }}
						</a>
					</li>
					<li>{{ $item->title }}</li>
				</ul>
				<h1>{{ $item->title }}</h1>
			</div>
			<img src="/images/elements/specials-icon.svg" alt="">
		</div>
	</div>

	<div class="themes courses-listing centered specials-rows">
		@forelse ($item->courses as $course)
			<div class="row">
				<div class="left flex between align-center">
					<div class="colored-block {{ $loop->index % 2 === 0 ? 'green' : 'red' }}"></div>
					<a href="{{ route('course', ['id' => $course->id]) }}" class="title-course">
						{{ \Illuminate\Support\Facades\Lang::getLocale() == 'kz' ? (empty($course->title_kz) ? $course->title : $course->title_kz) : $course->title }}
					</a>
				</div>
				<div class="right flex start align-center">
					<div class="author">
						<p>@lang('courses.teacher')</p>
						<img style="max-width: 28px; max-height: 28px" src="{{ $course->getUploadedUrl('author_photo') }}" alt="">

						{{ \Illuminate\Support\Facades\Lang::getLocale() == 'kz' ? (empty($course->author_fio_kz) ? $course->author_fio : $course->author_fio_kz) : $course->author_fio }}

					</div>
					<div class="link">
						<a href="{{ route('course', ['id' => $course->id]) }}" class="btn transparent">
							@lang('courses.go')
						</a>
					</div>
				</div>
			</div>
		@empty
			<p style="font-size: 1.4rem">
				@lang('courses.no_courses')
			</p>
		@endforelse

	</div>
@endsection
