@extends('layouts.base')

@section('content')
    <div class="top-poly-bg"></div>

    <div class="thanks-title">@lang('buy.thanks_title')</div>
    <p class="thanks-text">
		 @lang('buy.purchased') <b>"{{ $item->course->title }}".</b>
       <br>@lang('buy.on') <a href="{{ route('course', ['id' => $item->course_id]) }}">@lang('buy.page')</a> @lang('buy.you_can')
       <a href="/handouts">@lang('buy.hangout')</a>.
       <br>@lang('buy.on_page') <a href="{{ route('myTests') }}">@lang('buy.my_tests')</a> @lang('buy.pass_tests')
    </p>

@endsection
