@extends('layouts.base')

@section('content')

	<div class="centered page-title width1088">
		<h1>{{ $item->title }}</h1>
		@if (session('errorMessage'))
			<div style="margin-bottom: 32px; color: red; font-size: 18px;">
				{{ session('errorMessage') }}
			</div>
		@endif
	</div>

	<div class="course flex start align-top width1088">
		<div class="left">
			<div class="top">@lang('courses.author')</div>
			<div class="about flex start align-center">
				<div class="photo">
					<img style="max-width: 145px;" src="{{ $item->getUploadedUrl('author_photo') }}" alt="">
				</div>
				<div class="text">
					<p class="name">{{ $item->author_fio }}</p>
					<ul>
						<li>{{ $item->author_position }}</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="right">
			<div class="top">@lang('courses.description')</div>
			<div class="text">
				{!! $item->desc_text !!}
			</div>
		</div>
	</div>

	<div class="pay-table width1088">
		<div class="top">@lang('courses.price')</div>
		<table>
			@foreach ($item->parts as $part)
				<tr>
					<td>
					  <span class="left">
							<span class="hours">{{ $part->duration_hours }} @lang('courses.price')</span>
							<span class="cost">{{ $part->price_kzt }} Тг.</span>
					  </span>
					</td>
					<td>
						<a target="_blank" href="{{ $part->getUploadedUrl('plan') }}"
							download="{{ $part->real_plan_name }}">@lang('courses.download')</a>
						@if ($purchasedIds->contains($part->id))
							<a href="/handouts" class="buy">@lang('courses.read')</a>
						@else
							<a href="{{ route('buyCoursePart', ['courseId' => $item->id, 'partId' => $part->id]) }}"
								class="buy">@lang('courses.buy')</a>
						@endif
					</td>
				</tr>
			@endforeach
		</table>
	</div>

	<div class="course-benefits">
		<div class="width1088">
			<div class="title">@lang('courses.benefits')</div>
			<div class="items flex between align-top wrap">
				<div class="item">
					<img src="/images/courses/benefits/1.svg" alt="">
					<div class="title">@lang('courses.benefit1')</div>
					<div class="num">01</div>
				</div>
				<div class="item">
					<img src="/images/courses/benefits/2.svg" alt="">
					<div class="title">@lang('courses.benefit2')</div>
					<div class="num">02</div>
				</div>
				<div class="item">
					<img src="/images/courses/benefits/3.svg" alt="">
					<div class="title">@lang('courses.benefit3')</div>
					<div class="num">03</div>
				</div>
				<div class="item">
					<img src="/images/courses/benefits/4.svg" alt="">
					<div class="title title_big">@lang('courses.benefit4')</div>
					<div class="num">04</div>
				</div>
				<div class="item">
					<img src="/images/courses/benefits/5.svg" alt="">
					<div class="title">@lang('courses.benefit5')</div>
					<div class="num">05</div>
				</div>
				<div class="item">
					<img src="/images/courses/benefits/6.svg" alt="">
					<div class="title title_small">@lang('courses.benefit6')</div>
					<div class="num">06</div>
				</div>
			</div>
		</div>
	</div>

	<div class="about-course width1088">
		<div class="row-block flex between align-top">
			<div class="block">
				<div class="block-title"><span>@lang('courses.listeners_cat'):</span></div>
				<div class="text">
					{!! $item->listeners_category_text !!}
				</div>
			</div>
			<div class="block">
				<div class="block-title"><span>@lang('courses.goals')</span></div>
				<div class="text">
					{!! $item->goals_text !!}
				</div>
			</div>
		</div>
		<div class="block-title"><span>@lang('courses.tasks')</span></div>
		<div class="text -double-col">
			{!! $item->tasks_text !!}
		</div>

		<div class="block-title">
			<span>@lang('courses.organization')</span>
		</div>
		<div class="text -double-col">
			{!! $item->organization_text !!}
		</div>
	</div>

	<div id="testimonials" class="testimonials width1088">
		<div class="block-title">
			@auth
				<span>@lang('courses.leave_review')</span>
			@else
				<span>@lang('courses.reviews')</span>
			@endauth
		</div>
		@auth
			<form action="{{ route('storeCourseTestimonial', ['id' => $item->id]) }}" method="post"
					class="flex between align-top">
				@csrf
				<div class="user">
					<img src="{{ auth()->user()->photoUrl }}" alt="">
					<div class="text">
						<div class="name">@lang('courses.you')</div>
					</div>
				</div>
				<div class="form">
					<textarea name="text" placeholder="@lang('courses.leave')"></textarea>
					@if ($errors->count())
						<span style="color: red; margin-right: 24px;">{{ $errors->first() }}</span>
					@endif
					<input type="submit" value="@lang('courses.send')">
				</div>
			</form>
		@else
			<form action="{{ route('storeCourseTestimonial', ['id' => $item->id]) }}" method="post"
					class="flex between align-top">
				@csrf
				<div class="user">
					<img src="/images/no_avatar.png" alt="">
					<div class="text">
						<div class="name">@lang('courses.you')</div>
					</div>
				</div>
				<div class="form">
					<textarea name="text" placeholder="@lang('courses.leave')"></textarea>
					@if ($errors->count())
						<span style="color: red; margin-right: 24px;">{{ $errors->first() }}</span>
					@endif
					<input type="submit" value="@lang('courses.send')">
				</div>
			</form>
		
		@endauth
		@forelse ($testimonials as $testimonial)
			<div class="testimonial flex between align-top">
				<div class="user">
					<img src="{{ $testimonial->user->photoUrl }}" alt="">
					<div class="text">
						<div class="name">{{ $testimonial->user->full_name }}</div>
					</div>
				</div>
				<div class="text">
					<div class="top flex between align-center">
						<div class="left flex start align-center">
							<div class="date">{{ $testimonial->created_at->format('d.m.Y H:i') }} UTC</div>
						</div>
					</div>
					<div class="bottom">
						<p>{{ $testimonial->text }}</p>
					</div>
				</div>
			</div>
		@empty
			<p>@lang('courses.no_reviews')</p>
		@endforelse
	</div>

@endsection
