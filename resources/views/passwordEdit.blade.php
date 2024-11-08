@extends('layouts.base')

@section('content')

    <div class="login flex between align-top width1088 shadow">
        <div class="right" style="flex-basis: 100%;">
            <div class="wrap">
                <div class="title">@lang('auth.password_change')</div>
                <form method="post">
                    @csrf
                    <input type="password" name="current_password" placeholder="@lang('auth.password_change_current')">
                    <input type="password" name="new_password" placeholder="@lang('auth.password_change_new')">
                    <input type="password" name="new_password_confirmation" placeholder="@lang('auth.password_change_confirmation')">
                    @if ($errors->count())
                        <div class="step2" style="color: red; font-size: 16px; margin-top: 16px">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <button type="submit">@lang('auth.password_change_do')</button>
                </form>
            </div>
        </div>
    </div>

@endsection
