@extends('layouts.base')

@section('content')

    @include('parts.profileMenu')

    <div class="centered page-title width1088">
        <h1>@lang('certificates.title')</h1>
    </div>

    <div class="sertificates width1088 flex between wrap align-top">
        @forelse ($items as $item)
            <a class="item group" href="{{ $item->getUploadedUrl('file') }}">
                <img src="{{ $item->getUploadedUrl('file') }}" alt=""/>
                <span>{{ $item->title }}</span>
            </a>
        @empty
            <p>@lang('certificates.no_certificates')</p>
        @endforelse
        <span class="item empty"></span>
    </div>

@endsection
