@extends('layouts.base')

@section('content')

    <div class="centered page-title align">
        <h1>@lang('library.title')</h1>
    </div>

	 <div class="biblioteka-menu centered flex between align-center">
		 <ul>
			 @foreach ($categories as $category)
				 <li class="{{ $currentCategory == $category['id'] ? 'active' : '' }}">
					 <a href="?category={{ $category['id'] }}" class="btn subcat-contests contests-{{ $category['id'] }}" data-id="{{ $category['id'] }}">
						 {{ $category['name'] }}
					 </a>
				 </li>
			 @endforeach
		 </ul>
	 </div>
	 <div class="search-box">
		 <div class="search">
			 <form class="flex start align-top">
				 <input type="search">
				 <button><img src="/images/elements/search-btn.svg" alt=""></button>
			 </form>
		 </div>
	 </div>

    <div class="themes centered">
        <h2>@lang('library.last')</h2>
        @forelse ($items as $item)
            <div class="row">
                <div class="left flex between align-top">
                    <div class="extension"><span class="docx">{{ $item->document_extension }}</span></div>
                    <div class="doc">
                        <div class="doc-title">{{ $item->title }}</div>
                        <div class="flex start align-center">
                            <span class="saves">1</span>
                            <span class="date">{{ $item->created_at->format('d.m.Y') }}</span>
                        </div>
                    </div>
                </div>
                <div class="right flex between align-center">
                    <div class="author">
                        <p>@lang('library.author')</p>
                        <img style="max-width: 28px; max-height: 28px;" src="{{ $item->author->photoUrl }}" alt="">
                        <a href="{{ route('profileUser', [ 'id' => $item->author->id ]) }}" class="author-name">{{ $item->author->full_name }}</a>
                    </div>
                    <div class="link">
                        <a href="{{ route('showLibraryItem', [ 'id' => $item->id ]) }}" class="btn transparent">@lang('library.go')</a>
                    </div>
                </div>
            </div>
        @empty
            <h3>@lang('library.no_items')</h3>
        @endforelse
    </div>

@endsection
