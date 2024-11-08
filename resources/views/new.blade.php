@extends('layouts.base')

@section('content')

	<div class="centered page-title width1088">
		<h1>{{ $item->name ?? '' }}</h1>
	</div>

	<div class="width1088">
		<div class="wrapper">
			<div class="image">
				<img src="{{ $item->getUploadedUrl('miniature') }}" alt="">
			</div>
			<div class="text">
				{!! $item->text !!}
			</div>
		</div>
	</div>

@endsection
