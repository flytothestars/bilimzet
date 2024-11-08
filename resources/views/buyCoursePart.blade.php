@extends('layouts.base')

@section('content')
    <div class="login flex between align-top width1088 shadow">
        <div class="right" style="flex-basis: 100%;">
            <div class="wrap">
			<div style="width: 900px;">
                <div class="title">@lang('buy.title')</div>
                @if (session('errorMessage'))
                    <div style="margin-bottom: 32px; color: red; font-size: 18px;">
                        {{ session('errorMessage') }}
                    </div>
                @endif
                <p><a href="{{ route('course', [ 'id' => $item->course_id ]) }}">@lang('buy.back')</a></p>
                <p>@lang('buy.gotta') <b>"{{ $item->course->title }}".</b></p>
                <p>@lang('buy.duration'): <b>{{ $item->duration_hours }} Ак.ч.</b></p>
                <p>@lang('buy.price'): <b>{{ $item->price_kzt }} Tг.</b></p>
                <br>
                <p>@lang('buy.money'): <b>{{ $availableMoneyKZT }} Tг.</b></p>
                <form id="buyCourseForm" method="post">
                    @csrf
                    @if ($item->price_kzt <= $availableMoneyKZT)
                        <a class="buy" href="#"
                           onclick="document.getElementById('buyCourseForm').submit(); return false;"><b>@lang('buy.buy')</b></a>
                    @else
                        <br>
                        <p>@lang('buy.not_enough') <a href="{{ route('profile') }}"><b>@lang('buy.not_enough_profile')</b></a></p>
                    @endif
                </form>
            </div>
            </div>
        </div>
    </div>
@endsection
