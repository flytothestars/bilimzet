<!DOCTYPE html>
<html dir="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="apple-mobile-web-app-capable" content="yes"/>

	<title>@lang('common.title')</title>
	<meta name="description" content="@lang('common.description')">

	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="stylesheet" type="text/css" href="{{ mix('/css/main.min.css') }}">

	<script>
        window.default_locale = "{{ app()->getLocale() }}";
	</script>
</head>
<body>
	<div class="wrapper">
		<div class="container_wrap">
			<div class="mob-header">
				<div class="flex between align-center">
					<div class="logo">
						<a href="{{ route('index') }}"><img src="/images/logo.svg" alt=""></a>
					</div>
					<div class="search">
						<form action="{{ route('search') }}" class="flex start align-top">
							<input name="search" type="search">
							<button><img src="/images/elements/search.svg" alt=""></button>
						</form>
					</div>
					@auth
						<div class="notification notify">
							<a href="{{ route('notifications') }}"><img src="/images/elements/notification.svg" alt=""></a>
						</div>
						<a href="{{ route('profile') }}">
							<div class="user" style="background:url({{ auth()->user()->photoUrl }});"></div>
						</a>
					@endauth
					@guest
						<a href="{{ route('login') }}"><div class="user">A</div></a>
					@endguest
					<div class="menu-btn">
						<span></span>
						<span></span>
						<span></span>
					</div>
				</div>
			</div>
			<header class="main-menu">
				<div class="centered flex between align-center">
					<div class="left flex start align-center">
						<div class="logo">
							<a href="{{ route('index') }}"><img src="/images/logo.svg" alt=""></a>
							<span>@lang('common.title')</span>
						</div>
						@include ('parts.menu')
					</div>

					@include ('parts.languages')

					<div class="left flex end align-center">
						<div class="search">
							<form action="{{ route('search') }}" class="flex start align-top">
								<input name="search" type="search">
								<button><img src="/images/elements/search.svg" alt=""></button>
							</form>
						</div>
						@auth
							<div class="login" style="margin-left: 10px">
								<!--a href="#win1" class="shine-button">Стать лектором</a-->
								@if (!isset(auth()->user()->status_lector)) <a href="{{ route('seminar') }}" class="btn shine-button draw-border"><p>Семинар</p></a> @endif
							</div>
							<div class="notification notify">
								<a href="{{ route('notifications') }}"><img src="/images/elements/notification.svg" alt=""></a>
							</div>
							<a href="{{ route('profile') }}">
								<div class="user" style="background-image:url({{ auth()->user()->photoUrl }});"></div>
							</a>
							<div class="login">
								<form id="logout-form-header" method="post" action="{{ @route('logout') }}">
									@csrf
									<span class="key">
										<a href="#" onclick="document.getElementById('logout-form-header').submit(); return false;">@lang('auth.logout')</a>
									</span>
								</form>
							</div>
						@endauth
						@guest
							<div class="login">
								<a href="{{ @route('login') }}">@lang('auth.login')</a>
							</div>
							<div class="login" style="margin-left: 20px">
								<a href="{{ @route('reg') }}">@lang('auth.reg')</a>
							</div>
							<div style="margin-left: 10px;">
								<a href="{{ route('seminar') }}" class="btn shine-button draw-border">
									<p>Семинар</p>
								</a>
							</div>
						@endguest
					</div>
				</div>
			</header>

			@yield('content')
		</div>

		<footer>
			<div class="centered flex between align-top">
				<div class="col1">
					<a href="{{ route('index') }}"><img src="/images/logo.svg" alt=""></a>
					<span>@lang('common.title')</span>
				</div>
				<div class="col2">
					<div class="top  flex between align-top">
						<div class="menu flex between align-bottom">
							<div class="col">
								<div class="col-title">@lang('menu.navigation')</div>
								<ul>
									<li><a href="{{ route('index') }}">@lang('menu.index')</a></li>
									<li><a href="{{ route('specialities') }}">@lang('menu.courses')</a></li>
									<li><a href="{{ route('about') }}">@lang('menu.about')</a></li>
								</ul>
							</div>
							<div class="col">
								<ul>
{{--									<li><a href="/forum">@lang('menu.forum')</a></li>--}}
									<li><a href="{{ route('library') }}">@lang('menu.library')</a></li>
									<li><a href="{{ route('contacts') }}">@lang('menu.contacts')</a></li>
								</ul>
							</div>
						</div>
						@foreach ($footer_pages as $page)
							{!! $page !!}
						@endforeach
					</div>
					<div class="copyrights flex between align-center">
						<div class="text">
							<p>@lang('common.center')</p>
							<p>@lang('common.all_rights_reserved')</p>
							<p>
								<a href="/politic.docx" target="_blank">@lang('common.policy')</a><br>
								<a href="/user_soglas.rtf" target="_blank">@lang('common.agreement')</a>
							</p>
						</div>
					</div>
				</div>
				<div class="col3">
					<iframe
						src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3455.0212573133185!2d76.93523764034259!3d43.26577639224208!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38836ea1773f7ef1%3A0xa6c17b8bc2c48d1c!2z0YPQu9C40YbQsCDQltC10LvRgtC-0LrRgdCw0L0gMzcsINCQ0LvQvNCw0YLRiyAwNTAwMDAsINCa0LDQt9Cw0YXRgdGC0LDQvQ!5e0!3m2!1sru!2sru!4v1573301281476!5m2!1sru!2sru"
						width="276" height="200" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
				</div>
			</div>
		</footer>
	</div>
<div class="dm-overlay" id="win1">
    <div class="dm-table">
        <div class="dm-cell">
            <div class="dm-modal">
                <a href="#close" class="close"></a>
                <h3 style="text-align:center;color:red;">Сервис временно недоступен</h3>
                <div class="pl-left">
                <!--form action="" method="GET">
                    <input type="text">Ф.И.О.</input>
                    <textarea>Краткая информация о себе</textarea>
                    <input type="submit" value="Отправить заявку" />
                    <a href="#">Прикрепить резюме</a-->
                    <!--img src="https://lorempixel.com/320/320/people/some-text"-->
                <!--/form-->
                </div>
                <p></p>
            </div>
        </div>
    </div>
</div>
	<script src="{{ mix('/js/libs.min.js') }}"></script>
	<script src="{{ mix('/js/main.min.js') }}"></script>
	@stack('scripts')

</body>
</html>
