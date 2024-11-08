@extends('layouts.base')

@section('content')

    <div class="podacha-statyi-profile lk width1088">
        <div class="wrap profile width1088 flex between align-center">
            <div class="photo-name flex between align-center">
                <img src="{{ $user->photoUrl }}" alt="">
                <div class="name">
                    <p>{{ $user->full_name }}</p>
                </div>
            </div>
            <div class="contacts">
                <div class="col">
                    <span class="email"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></span>
                    <span class="phone"><a href="tel:{{ $user->phone }}">{{ $user->phone }}</a></span>
                </div>
                <div class="col">
                    <span class="geo">{{ $user->address }}</span>
                    <span class="role">{{ $user->position }}</span>
                </div>
            </div>
        </div>

        <div class="my-articles articles-listing-wrap width1088">
            <div class="title">@lang('common.articles')</div>
            <div class="articles-listing">
                @foreach ($articles as $article)
                    <div class="row flex between align-center published">
                        <div class="left"><a href="{{ route('showLibraryItem', ['id' => $article->id]) }}">{{ $article->title }}</a></div>
                        <div class="right"><a href="{{ route('showLibraryItem', ['id' => $article->id]) }}">@lang('common.read_article')</a></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
