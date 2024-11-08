@extends('layouts.base')

@section('content')

	<div class="centered page-title width1088">
		<h1>{{ $item->title }}</h1>
	</div>

	<div class="konkurs-full flex between align-top width1088">
		<div class="topblock">
			<div class="top">@lang('contests.description')</div>
			<div class="text">{!! $item->desc_text !!}</div>
		</div>
	</div>

	<div class="pay-table width1088">
		<div class="top">@lang('contests.prices')</div>
		<table>
			@foreach ($item->parts as $part)
				<tr>
					<td>
					  <span class="left">
							<span class="hours">{{ $part->duration_hours }} @lang('contests.hours')</span>
							<span class="cost">{{ $part->price_kzt }} Тг.</span>
					  </span>
					</td>
					<td>
						<a target="_blank" href="{{ $part->getUploadedUrl('plan') }}" download="{{ $part->real_plan_name }}">
							@lang('contests.download')
						</a>
						@if ($purchasedIds->contains($part->id))
							<a href="/handouts" class="buy">@lang('contests.read')</a>
						@else
							<a href="{{ route('buyContestPart', ['contestId' => $item->id, 'partId' => $part->id]) }}"
								class="buy">@lang('contests.part')</a>
						@endif
					</td>
				</tr>
			@endforeach
		</table>
	</div>

	@if (count($item->certificates))
		<div class="konkurs-benefits">
			<div class="width1088">
				<div class="title">@lang('contests.prizes')</div>
				<div class="items flex between align-top wrap">
					@foreach ($item->certificates as $certificate)
						<div class="item">
							<img src="{{ $certificate->getUploadedUrl('file') }}" alt="">
							<div class="title">{{ $certificate->name }}</div>
							<div class="description">{{ $certificate->text }}</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	@endif

	<div class="konkurs-members">
		<div class="width1088">
			<div class="title">@lang('contests.competitors')</div>
			<table>
				<thead>
				<tr>
					<th>@lang('contests.nominations')</th>
					<th>@lang('contests.participant')</th>
					<th>@lang('contests.work')</th>
					<th>@lang('contests.reward')</th>
				</tr>
				</thead>
				<tbody>
				@foreach ($testimonials as $testimonial)
					<tr>
						<td>
							<a href="#" class="work-title">{{ $testimonial->text }}</a>
							<div class="work-date"><img src="images/elements/date.svg" alt="">{{ $testimonial->updated_at }}</div>
						</td>
						<td>
							<div class="member flex start align-center"><img src="{{ $testimonial->user->photoUrl }}" alt=""><span>{{ $testimonial->user->full_name }}</span></div>
							<div class="member-organization">{{ $testimonial->user->company_name ?? '-' }}</div>
							<div class="member-role">{{ $testimonial->user->position ?? '-' }}</div>
						</td>
						<td>
							<div class="pdf"><img src="images/elements/pdf.svg" alt=""><span>@lang('contests.pdf')</span></div>
							<a class="btn bluebtn" href="#">@lang('contests.watch')</a>
						</td>
						<td>
							<div class="pdf"><img src="images/elements/pdf.svg" alt=""><span>@lang('contests.reward_file')</span></div>
							<div class="reward-desc">@lang('contests.first')</div>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>

@endsection
