@extends('layouts.base')

@section('content')

    <div class="results-top">
        <div class="centered flex between align-center">
            <h1>@lang('search.results')</h1>
            <div class="search-wrap">
                <form class="flex between align-center">
                    <input value="{{ Request::get('search') }}" name="search" type="search"
									placeholder="@lang('search.marketing')">
                    <select name="course_type">
                        <option value="*">@lang('search.any_type')</option>
                        @foreach ($categories as $category => $subcategories)
                            <option {{ Request::get('course_type') === $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                    <button><img src="/images/elements/blue-search-btn.svg" alt=""></button>
                </form>
            </div>
        </div>
    </div>

    @if (count($items) > 0)
        <div class="themes courses-listing centered">
            <h2>@lang('search.found') {{ count($items) }}</h2>
            @foreach($items as $item)
                <div class="row">
                    <div class="left flex start align-center">
                        <div class="colored-block {{ $loop->index % 2 === 0 ? 'green' : 'red' }}"></div>
                        <a href="#" class="title-course">{{ $item->title }}</a>
                    </div>
                    <div class="right flex between align-center">
                        <div class="author">
                            <p>@lang('search.author')</p>
                            <img style="max-width: 28px; max-height: 28px" src="{{$item->getUploadedUrl('author_photo') }}" alt="">
                            <a href="{{ route('course', ['id' => $item->id]) }}" class="author-name">{{ $item->author_fio }}</a>
                        </div>
                        <div class="link">
                            <a href="{{ route('course', ['id' => $item->id]) }}"
                               class="btn transparent">@lang('search.go')</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="themes noresult courses-listing centered">
            <p class="noresults">@lang('search.nothing')</p>
        </div>
    @endif

@endsection
