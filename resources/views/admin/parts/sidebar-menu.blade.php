<nav class="col-md-2 d-none d-md-block bg-light sidebar">
	<div class="sidebar-sticky">
		<ul class="nav flex-column">
			<li class="nav-item">
				<a class="nav-link {{ Route::currentRouteName() === 'admin.users' ? 'active' : ''}}"
					href="{{ route('admin.users') }}">
					<span data-feather="user"></span>
					Пользователи
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link  {{ Route::currentRouteName() === 'admin.querylec' ? 'active' : ''}}"
					href="{{ route('admin.querylec') }}">
					<span data-feather="user"></span>
					Лекторы
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Route::currentRouteName() === 'admin.lectures' ? 'active' : ''}}"
					href="{{ route('admin.lectures') }}">
					<span data-feather="book-open"></span>
					Добавление лекций
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Route::currentRouteName() === 'admin.support' ? 'active' : ''}}"
					href="{{ route('admin.support') }}">
					<span data-feather="smile"></span>
					Служба поддержки
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Route::currentRouteName() === 'admin.specialities' ? 'active' : ''}}"
					href="{{ route('admin.specialities') }}">
					<span data-feather="file-text"></span>
					Курсы
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Route::currentRouteName() === 'admin.testResults' ? 'active' : ''}}"
					href="{{ route('admin.testResults') }}">
					<span data-feather="archive"></span>
					Результаты тестов
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Route::currentRouteName() === 'admin.contests' ? 'active' : ''}}"
					href="{{ route('admin.contests') }}">
					<span data-feather="file-text"></span>
					Конкурсы
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Route::currentRouteName() === 'admin.contestFiles' ? 'active' : ''}}"
					href="{{ route('admin.contestFiles') }}">
					<span data-feather="file-text"></span>
					Файлы конкурсов
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Route::currentRouteName() === 'admin.news' ? 'active' : ''}}"
					href="{{ route('admin.news') }}">
					<span data-feather="file-text"></span>
					Новости
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Route::currentRouteName() === 'admin.library' ? 'active' : ''}}"
					href="{{ route('admin.library') }}">
					<span data-feather="book-open"></span>
					Библиотека
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Route::currentRouteName() === 'admin.guides' ? 'active' : ''}}"
					href="{{ route('admin.guides') }}">
					<span data-feather="book-open"></span>
					Гид
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Route::currentRouteName() === 'admin.certificates' ? 'active' : ''}}"
					href="{{ route('admin.certificates') }}">
					<span data-feather="award"></span>
					Сертификаты
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Route::currentRouteName() === 'admin.testimonials' ? 'active' : ''}}"
					href="{{ route('admin.testimonials') }}">
					<span data-feather="smile"></span>
					Отзывы
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Route::currentRouteName() === 'admin.edit' ? 'active' : ''}}"
					href="{{ route('admin.edit') }}">
					<span data-feather="smile"></span>
					Редактирование сайта
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Route::currentRouteName() === 'admin.gallery' ? 'active' : ''}}"
					href="{{ route('admin.gallery') }}">
					<span data-feather="smile"></span>
					Галлерея на главной
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Route::currentRouteName() === 'admin.letters' ? 'active' : ''}}"
					href="{{ route('admin.letters') }}">
					<span data-feather="smile"></span>
					Благодарственные письма
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"	>
					<span data-feather="smile"></span>
					Олимпиада
				</a>
				<div class="dropdown-menu">
					<a href="{{ route('admin.olympic.courses.index') }}" class="dropdown-item" type="button">Курсы</a>
				</div>
			</li>
		</ul>
	</div>
</nav>
