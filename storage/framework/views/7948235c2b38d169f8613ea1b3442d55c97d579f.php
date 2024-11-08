<div class="inner-menu centered width1088">
	<ul>
		<li class="<?php echo e(Route::currentRouteName() === 'profile' ? 'active' : ''); ?>">
			<a href="<?php echo e(route('profile')); ?>"><?php echo app('translator')->get('menu.profile'); ?></a>
		</li>
		<li class="<?php echo e(Route::currentRouteName() === 'applyLibraryItem' ? 'active' : ''); ?>">
			<a href="<?php echo e(route('applyLibraryItem')); ?>"><?php echo app('translator')->get('menu.push_article'); ?></a>
		</li>
		<li class="<?php echo e(Route::currentRouteName() === 'myContests' ? 'active' : ''); ?>">
			<a href="<?php echo e(route('myContests')); ?>"><?php echo app('translator')->get('menu.my_contests'); ?></a>
		</li>
		<li class="<?php echo e(Route::currentRouteName() === 'certificates' ? 'active' : ''); ?>">
			<a href="<?php echo e(route('certificates')); ?>"><?php echo app('translator')->get('menu.my_certificates'); ?></a>
		</li>
		<li class="<?php echo e(Route::currentRouteName() === 'myTests' ? 'active' : ''); ?>">
			<a href="<?php echo e(route('myTests')); ?>"><?php echo app('translator')->get('menu.my_tests'); ?></a>
		</li>
		<li class="<?php echo e(Route::currentRouteName() === 'notifications' ? 'active' : ''); ?>">
			<a href="<?php echo e(route('notifications')); ?>"><?php echo app('translator')->get('menu.notifications'); ?></a>
		</li>
		<li class="<?php echo e(Route::currentRouteName() === 'handouts' ? 'active' : ''); ?>">
			<a href="<?php echo e(route('handouts')); ?>"><?php echo app('translator')->get('menu.handouts'); ?></a>
		</li>
	</ul>
</div>
<?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/parts/profileMenu.blade.php ENDPATH**/ ?>