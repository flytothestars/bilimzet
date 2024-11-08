<ul class="menu flex between align-center">
	<li>
		<a class="{{ Route::currentRouteName() === 'index' ? 'current' : ''}}" href="{{ route('index') }}">@lang('menu.index')</a>
	</li>
	<li>
		<a class="{{ Route::currentRouteName() === 'specialities' ? 'current' : ''}}" href="{{ route('specialities') }}">@lang('menu.courses')</a>
	</li>
	<!--li>
		<a class="{{ Route::currentRouteName() === 'contests' ? 'current' : ''}}" href="{{ route('contests') }}">@lang('menu.contests')</a>
	</li-->
	<li>
		<a class="{{ Route::currentRouteName() === 'news' ? 'active' : ''}}" href="{{ route('news') }}">@lang('menu.news')</a>
	</li>
	<li>
		<a class="{{ Route::currentRouteName() === 'about' ? 'current' : ''}}" href="{{ route('about') }}">@lang('menu.about')</a>
	</li>
	<li>
		<a class="{{ Route::currentRouteName() === 'library' ? 'current' : ''}}" href="{{ route('library') }}">@lang('menu.library')</a>
	</li>
	<li>
		<a class="{{ Route::currentRouteName() === 'contacts' ? 'current' : ''}}" href="{{ route('contacts') }}">@lang('menu.contacts')</a>
	</li>
	<li>
		<a class="{{ Route::currentRouteName() === 'olympic' ? 'current' : ''}}" href="{{ route('olympic') }}">@lang('olympics.title_one')</a>
	</li>
</ul>
