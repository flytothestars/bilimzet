<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link href="{{ asset('css/chat/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chat/custom.css') }}" rel="stylesheet">

    <script>
        window.Laravel = {!! json_encode([ 'csrfToken' => csrf_token(), 'user' =>  auth()->user() ]) !!};
        let fetchChatURL = null;
    </script>
</head>
<body>
	<div id="app">
		 <nav class="navbar navbar-default navbar-static-top">
			  <div class="container">
					<div class="navbar-header">

						 <!-- Collapsed Hamburger -->
						 <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
							  <span class="sr-only">Toggle Navigation</span>
							  <span class="icon-bar"></span>
							  <span class="icon-bar"></span>
							  <span class="icon-bar"></span>
						 </button>

						 <!-- Branding Image -->
						 <a class="navbar-brand" href="{{ url('/') }}">
							  {{ config('app.name') }}
						 </a>
					</div>

					<div class="collapse navbar-collapse" id="app-navbar-collapse">
						 <!-- Left Side Of Navbar -->
						 <ul class="nav navbar-nav">
							  &nbsp;
						 </ul>

						 <!-- Right Side Of Navbar -->
						 <ul class="nav navbar-nav navbar-right">
							  <!-- Authentication Links -->
							  @if (Auth::guest())
									<li><a href="{{ route('login') }}">Login</a></li>
									<li><a href="{{ route('register') }}">Register</a></li>
							  @else
									<li class="dropdown">
										 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
											  {{ Auth::user()->name }} <span class="caret"></span>
										 </a>

										 <ul class="dropdown-menu" role="menu">
											  <li>
													<a href="{{ route('logout') }}"
														onclick="event.preventDefault();
																		  document.getElementById('logout-form').submit();">
														 Logout
													</a>

													<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
														 {{ csrf_field() }}
													</form>
											  </li>
										 </ul>
									</li>
							  @endif
						 </ul>
					</div>
			  </div>
		 </nav>

		 @yield('content')
	</div>

	<!-- Scripts -->
	<script type="text/javascript">
		 @yield('routes')
	</script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.5/socket.io.min.js"></script>--}}
	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
	<script src="https://{{ Request::getHost() }}/socket.io.js"></script>
	<script src="{{ asset('js/chat/app.js') }}"></script>
	<script src="{{ asset('js/chat/notify.min.js') }}"></script>
	<script src="{{ asset('js/chat/custom.js') }}"></script>

	@yield('script')

</body>
</html>
