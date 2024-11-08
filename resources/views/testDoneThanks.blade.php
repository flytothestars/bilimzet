@extends('layouts.base')

@section('content')

    <div class="top-poly-bg"></div>

    <div class="thanks-title">@lang('tests.thanks')</div>
    <div class="thanks-text">
        <p>@lang('tests.you_pass') <b>"{{ $item->title }}".</b></p>
        <p>@lang('tests.correct'): {{ $correctAnswers }} / {{ $totalAnswers }}</p>
        <p>@lang('tests.page') <a href="{{ route('myTests') }}">@lang('tests.my_tests')</a>
			  @lang('tests.other')
        </p>
        <p>
            <a href="{{ route('viewTest', ['id' => $item->id]) }}">@lang('tests.retest')</a>
        </p>
    </div>

@endsection
