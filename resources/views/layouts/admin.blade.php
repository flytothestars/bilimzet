<!doctype html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<title>Dashboard</title>

	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link href="{{ mix('/css/admin.min.css') }}" rel="stylesheet">
</head>
<body>

	@include ('admin.parts.top-menu')

	<div class="container-fluid">
		<div class="row">

			@include ('admin.parts.sidebar-menu')

			<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 mb-4">
				@yield('content')
			</main>
		</div>
	</div>

	<script src="{{ mix('/js/admin.min.js') }}"></script>
	@stack('scripts')

</body>
</html>
