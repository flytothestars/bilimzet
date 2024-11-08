<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
	<a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{ route('profile') }}">На сайт</a>
	<ul class="navbar-nav px-3">
		<li class="nav-item text-nowrap">
			<form id="logout-form" style="display: inline-block" method="post" action="{{ route('logout') }}">
				@csrf
				<a class="nav-link" href="#"
				   onclick="document.getElementById('logout-form').submit(); return false;">Выйти</a>
			</form>
		</li>
	</ul>
</nav>
