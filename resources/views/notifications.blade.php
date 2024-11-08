@extends('layouts.base')

@section('content')

	@include('parts.profileMenu')

	<div class="width1088 page-title">
		<h1>@lang('notifications.title')</h1>
	</div>

    <div class="notifications centered">
        @forelse ($items ?? [] as $item)
            <div class="row">
                <div class="top flex between align-center">
                    <div class="left flex start align-center">
                        <img src="/images/elements/newtask.svg" alt="" class="notify-ico">
                        <p>{{ $item->title }}</p>
                    </div>
                    <div class="date">{{ $item->created_at->format('d.m.Y H:i') }} UTC</div>
                </div>
                <div class="bottom flex between align-center">
                    <div class="left flex start align-center">
                        <div class="num">{{ sprintf("%02d", $loop->iteration) }}</div>
                        <div class="text">
                            <p>{!! $item->desc !!}</p>
                        </div>
                    </div>
                    @if ($item->link)
                        <div class="link">
                            <a href="{{ $item->link }}" class="btn transparent">@lang('notifications.go')</a>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <p style="font-size: 1.2rem">@lang('notifications.no_items')</p>
        @endforelse
    </div>

    @include('parts.recommendations')

@endsection
