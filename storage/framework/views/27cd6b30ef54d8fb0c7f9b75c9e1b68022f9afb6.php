<nav class="col-md-2 d-none d-md-block bg-light sidebar">
	<div class="sidebar-sticky">
		<ul class="nav flex-column">
			<li class="nav-item">
				<a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.users' ? 'active' : ''); ?>"
					href="<?php echo e(route('admin.users')); ?>">
					<span data-feather="user"></span>
					Пользователи
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.support' ? 'active' : ''); ?>"
					href="<?php echo e(route('admin.support')); ?>">
					<span data-feather="smile"></span>
					Служба поддержки
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.specialities' ? 'active' : ''); ?>"
					href="<?php echo e(route('admin.specialities')); ?>">
					<span data-feather="file-text"></span>
					Курсы
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.testResults' ? 'active' : ''); ?>"
					href="<?php echo e(route('admin.testResults')); ?>">
					<span data-feather="archive"></span>
					Результаты тестов
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.contests' ? 'active' : ''); ?>"
					href="<?php echo e(route('admin.contests')); ?>">
					<span data-feather="file-text"></span>
					Конкурсы
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.contestFiles' ? 'active' : ''); ?>"
					href="<?php echo e(route('admin.contestFiles')); ?>">
					<span data-feather="file-text"></span>
					Файлы конкурсов
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.news' ? 'active' : ''); ?>"
					href="<?php echo e(route('admin.news')); ?>">
					<span data-feather="file-text"></span>
					Новости
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.library' ? 'active' : ''); ?>"
					href="<?php echo e(route('admin.library')); ?>">
					<span data-feather="book-open"></span>
					Библиотека
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.guides' ? 'active' : ''); ?>"
					href="<?php echo e(route('admin.guides')); ?>">
					<span data-feather="book-open"></span>
					Гид
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.certificates' ? 'active' : ''); ?>"
					href="<?php echo e(route('admin.certificates')); ?>">
					<span data-feather="award"></span>
					Сертификаты
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.testimonials' ? 'active' : ''); ?>"
					href="<?php echo e(route('admin.testimonials')); ?>">
					<span data-feather="smile"></span>
					Отзывы
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.edit' ? 'active' : ''); ?>"
					href="<?php echo e(route('admin.edit')); ?>">
					<span data-feather="smile"></span>
					Редактирование сайта
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.gallery' ? 'active' : ''); ?>"
					href="<?php echo e(route('admin.gallery')); ?>">
					<span data-feather="smile"></span>
					Галлерея на главной
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.letters' ? 'active' : ''); ?>"
					href="<?php echo e(route('admin.letters')); ?>">
					<span data-feather="smile"></span>
					Благодарственные письма
				</a>
			</li>
		</ul>
	</div>
</nav>
<?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/admin/parts/sidebar-menu.blade.php ENDPATH**/ ?>