<div class="inner-menu centered width1088">
	<ul>
		<li class="{{ Route::currentRouteName() === 'profile' ? 'active' : ''}}">
			<a href="{{ route('profile') }}">@lang('menu.profile')</a>
		</li>
		<li class="{{ Route::currentRouteName() === 'applyLibraryItem' ? 'active' : ''}}">
			<a href="{{ route('applyLibraryItem') }}">@lang('menu.push_article')</a>
		</li>
		<li class="{{ Route::currentRouteName() === 'applyLectureItem' ? 'active' : ''}}">
			<a href="{{ route('applyLectureItem') }}">Мои лекции</a>
		</li>
		<li class="{{ Route::currentRouteName() === 'myContests' ? 'active' : ''}}">
			<a href="{{ route('myContests') }}">@lang('menu.my_contests')</a>
		</li>
		<li class="{{ Route::currentRouteName() === 'certificates' ? 'active' : ''}}">
			<a href="{{ route('certificates') }}">@lang('menu.my_certificates')</a>
		</li>
		<li class="{{ Route::currentRouteName() === 'myTests' ? 'active' : ''}}">
			<a href="{{ route('myTests') }}">@lang('menu.my_tests')</a>
		</li>
		<li class="{{ Route::currentRouteName() === 'notifications' ? 'active' : ''}}">
			<a href="{{ route('notifications') }}">@lang('menu.notifications')</a>
		</li>
		<li class="{{ Route::currentRouteName() === 'handouts' ? 'active' : ''}}">
			<a href="{{ route('handouts') }}">@lang('menu.handouts')</a>
		</li>
	</ul>
</div>
