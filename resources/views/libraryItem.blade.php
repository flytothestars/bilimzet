@extends('layouts.base')

@section('content')

	<div class="centered page-title width1088">
		<h1>@lang('library.title') <span class="doc-title">{{ $item->title }}</span></h1>
	</div>

	<div class="document-opened width1088">
		<div class="doc-body">
			<div class="top flex between align-center">
				<div class="left">
					<div class="doc-type"><img src="/images/files/word.png" alt=""></div>
					<div class="doc-title">{{ $item->title }}</div>
					<div class="doc-extension docx">{{ $item->document_extension }}</div>
				</div>
				<div class="right">
					<a href="{{ $item->documentUrl }}" target="_blank" download
						class="btn download shadow blue">@lang('library.download')</a>
				</div>
			</div>
			<div class="text">
				<p>{{ $item->text }}</p>
			</div>
		</div>
		<div class="bottom flex between align-center">
			<div class="author flex start align-center">
				<p>@lang('library.author')</p>
				<img style="max-width: 28px; max-height: 28px" src="{{ $item->author->photoUrl }}" alt="">
				<a href="{{ route('profileUser', [ 'id' => $item->author->id ]) }}"
					class="author-name">{{ $item->author->full_name }}</a>
			</div>
			<a href="#" class="readmore">@lang('library.more')</a>
			<div class="char flex end align-center">
				<span class="saves">1</span>
				<span class="date">{{ $item->created_at->format('d.m.Y') }}</span>
			</div>
		</div>
	</div>

	<div class="themes centered">
		<h2>Похожие темы</h2>
		@foreach ($similars as $item)
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
		@endforeach
	</div>

@endsection
