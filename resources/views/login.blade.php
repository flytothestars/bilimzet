@extends('layouts.base')

@section('content')

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&display=swap&subset=cyrillic" rel="stylesheet">
	<div class="login flex between align-top width1088 shadow">
		<div class="left">
			<div class="top">
				<img src="/images/blue-logo.png" alt="">
				<span>@lang('auth.welcome')</span>
			</div>
			<p>@lang('auth.about')</p>
		</div>
		<div class="right">
			<div class="wrap">
				<div class="title">@lang('auth.login')</div>
				<form action="/login" method="post">
					@csrf
					<input type="email" name="email" value="{{ @old("email") }}" placeholder="E-mail*">
					<input type="password" name="password" placeholder="@lang('auth.password')">
					<div class="flex between align-center">
						<label><input type="checkbox"/> @lang('auth.remember')</label>
						<a href="#">@lang('auth.forgot')</a>
					</div>
					@if ($errors->count())
						<div class="step2" style="color: red; font-size: 16px; margin-top: 16px">
							{{ $errors->first() }}
						</div>
					@endif
					<div class="submites flex center align-center">
						<button type="submit">@lang('auth.enter')</button>
						<a href="{{ route('reg') }}">@lang('auth.reg')</a>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection
