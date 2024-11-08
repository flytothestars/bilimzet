@extends('layouts.base')

@section('content')

	<ul class="width1088 categories-listing">
		<li class="qualification {{ $tab === 1 ? 'active' : '' }}">
			<a href="?tab=1">{{ $categoryNames[0] }}</a>
		</li>
		<li class="retraining {{ $tab === 2 ? 'active' : '' }}">
			<a href="?tab=2">{{ $categoryNames[1] }}</a>
		</li>
	</ul>

	<div class="width1088">
		<div class="subcat">
			@foreach ($subcategoryNames as $subcategoryName)
				<div class="subcat-tab {{ $loop->first ? 'current' : '' }}" data-target="{{ $loop->index }}">
					<a class="btn subcat-courses courses-{{ $loop->index }}" data-id="{{ $loop->index }}">
						{{ $subcategoryName }}
					</a>
				</div>
			@endforeach
		</div>
	</div>

	<div class="width1088 swiper-container specialities-tabs swiper-tabs">
		<div class="swiper-wrapper">
			@foreach ($subcategoriesData as $courses)
				<div class="swiper-slide flex between align-top wrap">
					@foreach($courses as $course)
						<a href="{{ route('speciality', ['id' => $course->id]) }}" class="flex align-center center wrap" style="background: {{ $course->picture_background }};">
							<img style="max-width: 90px; max-height: 90px; height: auto" src="{{ $course->getUploadedUrl('picture') }}" alt="">
							<span>{{ $course->title }}</span>
						</a>
						@if ($loop->last)
							@if ($loop->count % 3 === 1)
								<span class="empty"></span>
								<span class="empty"></span>
							@elseif ($loop->count % 3 === 2)
								<span class="empty"></span>
							@endif
						@endif
					@endforeach
				</div>
			@endforeach
		</div>
	</div>
@endsection
