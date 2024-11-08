<ul class="menu flex between align-center">
	<li>
		<a class="<?php echo e(Route::currentRouteName() === 'index' ? 'current' : ''); ?>" href="<?php echo e(route('index')); ?>"><?php echo app('translator')->get('menu.index'); ?></a>
	</li>
	<li>
		<a class="<?php echo e(Route::currentRouteName() === 'specialities' ? 'current' : ''); ?>" href="<?php echo e(route('specialities')); ?>"><?php echo app('translator')->get('menu.courses'); ?></a>
	</li>
	<!--li>
		<a class="<?php echo e(Route::currentRouteName() === 'contests' ? 'current' : ''); ?>" href="<?php echo e(route('contests')); ?>"><?php echo app('translator')->get('menu.contests'); ?></a>
	</li-->
	<li>
		<a class="<?php echo e(Route::currentRouteName() === 'news' ? 'active' : ''); ?>" href="<?php echo e(route('news')); ?>"><?php echo app('translator')->get('menu.news'); ?></a>
	</li>
	<li>
		<a class="<?php echo e(Route::currentRouteName() === 'about' ? 'current' : ''); ?>" href="<?php echo e(route('about')); ?>"><?php echo app('translator')->get('menu.about'); ?></a>
	</li>
	<li>
		<a class="<?php echo e(Route::currentRouteName() === 'library' ? 'current' : ''); ?>" href="<?php echo e(route('library')); ?>"><?php echo app('translator')->get('menu.library'); ?></a>
	</li>
	<li>
		<a class="<?php echo e(Route::currentRouteName() === 'contacts' ? 'current' : ''); ?>" href="<?php echo e(route('contacts')); ?>"><?php echo app('translator')->get('menu.contacts'); ?></a>
	</li>
	<li>
		<a class="<?php echo e(Route::currentRouteName() === 'olympic' ? 'current' : ''); ?>" href="<?php echo e(route('olympic')); ?>"><?php echo app('translator')->get('olympics.title_one'); ?></a>
	</li>
</ul>
<?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/parts/menu.blade.php ENDPATH**/ ?>