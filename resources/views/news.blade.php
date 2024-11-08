@extends('layouts.base')

@section('content')

    <div class="width1088 page-title">
        <h1>@lang('home.news_events')</h1>
    </div>

    <div class="news">
        <div class="width1088 flex between wrap news-row">
            @foreach ($items as $item)
					<div class="news-item">
						 <img src="{{ $item->getUploadedUrl('miniature') }}" alt="">
						 <div class="date"><img src="/images/elements/date.svg" alt=""><span>{{ $item->date }}</span></div>
						 <div class="title"><a href="{{ route('newPost', [ 'id' => $item->id ]) }}">{{ $item->name }}</a></div>
						 <div class="link" style="display:flex; justify-content: space-between; font-size: 0.8em">
                             <a href="{{ route('newPost', [ 'id' => $item->id ]) }}">@lang('home.more')</a>
                             <span>Просмотров: {{ $item->views_count }}</span>
                         </div>
					</div>
            @endforeach
        </div>

        <div class="more"><a href="#">@lang('common.more')</a></div>
    </div>

    <div class="mt-5 mb-4">
        {{ $items->links() }}
    </div>

@endsection
