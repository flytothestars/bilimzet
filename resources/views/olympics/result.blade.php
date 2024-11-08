@extends('layouts.base')

@section('content')

    <div class="centered page-title width1088">
        <h1>{{ $courseTitle }}</h1>
    </div>

    <div class="olympics">
        <div class="centered olympic-is-end">
            <div class="certificate">
                @if($letterImage)
                    <img src="/uploads/courses/letter/{{ $letterImage }}">
                @endif
                    <img src="/uploads/courses/diploma/{{ $certificateImage }}">
            </div>
            <div class="col-md-12" style="display:flex; justify-content: center;">
                @if($letterImage)
                    <a href="{{ route('olympic.download', $id) }}?type=letter">Скачать грамоту</a>
                @endif
                    <a href="{{ route('olympic.download', $id) }}?type=diploma">Скачать диплом</a>
            </div>
            <div class="results">
                <h1>@lang('olympics.result')</h1>
                <span class="duration">@lang('olympics.duration') {{ $durationText }}</span>
                @forelse($results as $result)
                <div class="question">
                    <h3>{{ $result['questionText'] }}</h3>
                    <ul>
                        <li>@lang('olympics.right_answer') {{ $result['correctAnswerText'] }}</li>
                        <li class="{{ $result['isCorrectAnswer'] ? 'correctAnswer' : 'incorrectAnswer' }}">@lang('olympics.own_answer') {{ $result['userAnswer'] }}</li>
                    </ul>
                </div>
                @empty
                    <div class="no-results">@lang('olympics.no_answers')</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection