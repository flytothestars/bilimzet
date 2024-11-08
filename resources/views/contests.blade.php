@extends('layouts.base')

@section('content')

	<div class="width1088 mt-3">
		<div class="subcat">
			@foreach ($categories as $category)
				<div class="subcat-tab {{ $loop->first ? 'current' : '' }}" data-target="{{ $loop->index }}">
					<a class="btn subcat-contests contests-{{ $category->id }}" data-id="{{ $loop->index }}">
						{{ $category->name }}
					</a>
				</div>
			@endforeach
		</div>
	</div>

	<div class=" width1088 swiper-container contests-tabs swiper-tabs">
		<div class="swiper-wrapper fix">
			@foreach ($categories as $category)
				<div class="swiper-slide flex between align-top wrap">
					@foreach ($category->contests as $contest)
						<div class="konkurs">
							<img src="{{ $contest->getUploadedUrl('picture') }}" alt="">
							<div class="title">
								<a href="{{ route('contest', [ 'id' => $contest->id ]) }}">{{ $contest->title }}</a>
							</div>
							<a href="#" class="download">@lang('contests.download')</a>
							<div class="awards flex start align-center">
								<img src="/img/award.svg" alt="">
								<span>{{ $contest->text_on_picture }}</span>
							</div>
							<div class="members">
								<div class="title">@lang('contests.competitors')</div>
								@foreach ($contest->testimonials as $testimonial)
									<div class="member flex start align-center">
										<img src="{{ $testimonial->user->photoUrl }}" alt="">
										<span>{{ $testimonial->user->full_name }}</span>
									</div>
								@endforeach
							</div>
							<a href="{{ route('contest', [ 'id' => $contest->id ]) }}"
								class="bigbluebtn flex align-center center">@lang('contests.read')</a>
						</div>
					@endforeach
					<span class="empty"></span>
				</div>
			@endforeach
		</div>
	</div>

@endsection
