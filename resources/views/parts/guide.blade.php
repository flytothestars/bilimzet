<div class="gid">
	<div class="centered page-title width1088">
		<h1>@lang('home.guide')</h1>
	</div>

	<div class="width1088 accordion">
		@foreach ($guides as $guide)

			<h3>{{ $guide->title }}</h3>
			<div>
				{!! $guide->text !!}
				<div class="text-center" style="text-align: center;">
					<iframe class="guide-video" src="{{ $guide->video }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			</div>
		@endforeach
	</div>
</div>
