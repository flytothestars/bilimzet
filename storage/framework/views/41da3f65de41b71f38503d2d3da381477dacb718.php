<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
	<a class="navbar-brand col-sm-3 col-md-2 mr-0" href="<?php echo e(route('profile')); ?>">На сайт</a>
	<ul class="navbar-nav px-3">
		<li class="nav-item text-nowrap">
			<form id="logout-form" style="display: inline-block" method="post" action="<?php echo e(route('logout')); ?>">
				<?php echo csrf_field(); ?>
				<a class="nav-link" href="#"
				   onclick="document.getElementById('logout-form').submit(); return false;">Выйти</a>
			</form>
		</li>
	</ul>
</nav>
<?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/admin/parts/top-menu.blade.php ENDPATH**/ ?>