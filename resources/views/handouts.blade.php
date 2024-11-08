@extends('layouts.base')

@section('content')

	@include('parts.profileMenu')

	<?php
		$colors_pos = 0;
		$colors = [ "red", "yellow", "blue", "green", "light_green" ];
	?>

	@if (empty($show_details))
		@foreach ($items as $item)

			<h1 class="centered material-title">{{ $item->course->title }}</h1>
			<div class="colored row blue flex between align-center centered" style="height: 60px;">
			<!--
				<div class="left"><img src="images/elements/recommendations.svg" alt=""></div>
				<div class="right"><a class="btn black" href="#">Скачать</a></div>
				-->
			</div>
			<div class="materials centered">

{{--			@foreach ($item as $subitem)--}}

				<div class="material-row">
					<div class="top flex between align-center">
						<div class="left flex start align-center">
							<div class="num">{{ $loop->iteration }}</div>
							<div class="course-title">{{ $item->course->title }}</div>
						</div>
						<div class="right">
							<div class="author flex end align-center">
								<p>@lang('handouts.author')</p>
								<img style="max-width: 28px; max-height: 28px" src="{{ $item->course->getUploadedUrl('author_photo') }}" alt="">
								{{ $item->course->author_fio }}
							</div>
						</div>
					</div>

					<form action="/handouts" id="additional_info_{{ $item->id }}">
						<input type="hidden" name="show_details" value="{{ $item->id }}">
						<input type="hidden" name="course_title_id" value="{{ $item->course->title }}">
						<input type="hidden" name="author_name" value="{{ $item->course->author_fio }}">
						<input type="hidden" name="author_photo" value="{{ $item->course->getUploadedUrl('author_photo') }}">
						<input type="hidden" name="file_1"
								 value="{{ route('downloadCoursePartFile', [ 'courseId' => $item->course->id, 'partId' => $item->id ]) }}">
					</form>

					<div class="colored row {{ $colors[$colors_pos] }} flex between align-center centered">
						<div class="left"><img src="images/elements/recommendations.svg" alt=""><span>@lang('handouts.recommendation'): {{ $item->duration_hours }} @lang('handouts.hours')</span></div>
						<div class="right">
							<a class="btn black" href="javascript:document.getElementById('additional_info_{{ $item->id }}').submit();">@lang('handouts.go')</a>
						</div>
					</div>
				</div>

{{--			@endforeach--}}
			</div>
				<div class="start-test flex between align-center">
				<div class="left">@lang('handouts.done')</div>
				<div class="right"><a class="btn blue" href="/tests">@lang('handouts.begin')</a></div>
			</div>

			<?php
			$colors_pos++;
			if ($colors_pos >= count($colors))
				$colors_pos = 0;
			?>

		@endforeach

	@else

		<div class="centered page-title flex start align-center material-inner-title">
			<a href="/handouts"><img src="/images/elements/arrow-black-left-big.svg" alt=""></a>
			<div class="num">01</div>
			<h1>{{ $course_title_id }}</h1>
		</div>
		<div class="colored row blue flex between align-center centered">

			<div class="right flex end align-center">
				<p style="margin-right:10px;">@lang('handouts.author')</p>
				<img style="max-width: 28px; max-height: 28px" src="{{ $author_photo }}" alt="">{{ $author_name }}
			</div>
		</div>

		<div class="materials themes centered">
			@foreach ($additional_files as $ad_file)
				<div class="row">
					<div class="left flex between align-top">
						<div class="extension"><span class="docx">PDF</span></div>
						<div class="doc">
							<div class="doc-title">
								@if ($real_names[$ad_file] != "")
									{{ $real_names[$ad_file] }}
								@else
									{{ basename($ad_file) }}
								@endif
							</div>
						</div>
					</div>
					<div class="right flex between align-center">
						<div class="link">
							<a href="{{ $ad_file }}" download="{{ $real_names[$ad_file] }}" class="btn transparent">@lang('handouts.download')</a>
							<a href="{{ $ad_file }}" class="btn transparent" target="_blank">@lang('handouts.go')</a>
						</div>
					</div>
				</div>
			@endforeach
		</div>

	@endif

{{--	<div class="pagination">--}}
{{--		<div class="current-page">Страница 1 из 1</div>--}}
{{--		<ul>--}}
{{--			<li class="active"><a href="#">1</a></li>--}}
{{--			--}}{{--			<li><a href="#">2</a></li>--}}
{{--			--}}{{--			<li><a href="#">3</a></li>--}}
{{--			--}}{{--			<li><a href="#">4</a></li>--}}
{{--			--}}{{--			<li><a href="#">5</a></li>--}}
{{--		</ul>--}}
{{--	</div>--}}

@endsection
