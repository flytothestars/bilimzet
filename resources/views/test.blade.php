@extends('layouts.base')

@section('content')

    <div class="test width1088">
        <div class="top">
            <div class="left">{{ $test->title }}</div>
            <div class="right">
                <span class="time-title">@lang('tests.time')</span>
                <span class="time-counter" id="timer" data-init="{{ $endTime }}"></span>
            </div>
        </div>
        <div class="progress-bar">
            <div class="progress" style="width: {{ $progressPercent }}%;"></div>
        </div>
        <form method="post" action="{{ route('stepTest', [ 'id' => $test->id ]) }}">
            @csrf
            @if (session('errorMessage'))
                <div style="color: red; font-size: 18px; margin-top: 24px;">
                    {{ session('errorMessage') }}
                </div>
            @endif
            <div class="test-body">
                <div class="current">@lang('tests.question') {{ $questionNumberPretty }}</div>
                <div class="question">{{ $questionTextPretty }}</div>
                <div class="answers-block">
                    <div class="answers">
                        @foreach ($answers as $answer)
                            <label class="answer">
                                <span class="{{ $answer->className }}">{{ $answer->letter }}</span>
                                <span class="title">{{ $answer->title }}</span>
                                <input type="radio" name="answer" value="{{ $answer->title }}">
                            </label>
                        @endforeach
                    </div>
                    <button class="next">@lang('tests.next')</button>
                </div>
            </div>
        </form>
        <form style="display: none" method="post" id="timeoutForm"
              action="{{ route('timeoutTest', [ 'id' => $test->id ]) }}">
            @csrf
        </form>
    </div>

@endsection
