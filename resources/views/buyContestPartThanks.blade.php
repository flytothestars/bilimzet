@extends('layouts.base')

@section('content')

    <div class="top-poly-bg"></div>

    <div class="thanks-title">@lang('buy.thanks_title_contest')</div>
    <p class="thanks-text">
		 @lang('buy.purchased_contest') <b>"{{ $item->contest->title }}".</b>
       <br>@lang('buy.on') <a href="{{ route('course', ['id' => $item->contest_id]) }}">@lang('buy.page_contest')</a> @lang('buy.you_can')
       <a href="/handouts">@lang('buy.hangout_contest')</a>.
       <br>@lang('buy.on_page') <a href="{{ route('myTests') }}">@lang('buy.my_tests')</a> @lang('buy.pass_tests_contest')
    </p>

@endsection
