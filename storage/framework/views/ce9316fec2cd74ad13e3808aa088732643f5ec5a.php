<!DOCTYPE html>
<html dir="ltr" lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="apple-mobile-web-app-capable" content="yes"/>

	<title><?php echo app('translator')->get('common.title'); ?></title>
	<meta name="description" content="<?php echo app('translator')->get('common.description'); ?>">

	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

	<link rel="stylesheet" type="text/css" href="<?php echo e(mix('/css/main.min.css')); ?>">
</head>
<body>
	<div class="wrapper">
		<div class="container_wrap">
			<div class="mob-header">
				<div class="flex between align-center">
					<div class="logo">
						<a href="<?php echo e(route('index')); ?>"><img src="/images/logo.svg" alt=""></a>
					</div>
					<div class="search">
						<form action="<?php echo e(route('search')); ?>" class="flex start align-top">
							<input name="search" type="search">
							<button><img src="/images/elements/search.svg" alt=""></button>
						</form>
					</div>
					<?php if(auth()->guard()->check()): ?>
						<div class="notification notify">
							<a href="<?php echo e(route('notifications')); ?>"><img src="/images/elements/notification.svg" alt=""></a>
						</div>
						<a href="<?php echo e(route('profile')); ?>">
							<div class="user" style="background:url(<?php echo e(auth()->user()->photoUrl); ?>);"></div>
						</a>
					<?php endif; ?>
					<?php if(auth()->guard()->guest()): ?>
						<a href="<?php echo e(route('login')); ?>"><div class="user">A</div></a>
					<?php endif; ?>
					<div class="menu-btn">
						<span></span>
						<span></span>
						<span></span>
					</div>
				</div>
			</div>
			<header class="main-menu">
				<div class="centered flex between align-center">
					<div class="left flex start align-center">
						<div class="logo">
							<a href="<?php echo e(route('index')); ?>"><img src="/images/logo.svg" alt=""></a>
							<span><?php echo app('translator')->get('common.title'); ?></span>
						</div>
						<?php echo $__env->make('parts.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					</div>

					<?php echo $__env->make('parts.languages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

					<div class="left flex end align-center">
						<div class="search">
							<form action="<?php echo e(route('search')); ?>" class="flex start align-top">
								<input name="search" type="search">
								<button><img src="/images/elements/search.svg" alt=""></button>
							</form>
						</div>
						<?php if(auth()->guard()->check()): ?>
							<div class="notification notify">
								<a href="<?php echo e(route('notifications')); ?>"><img src="/images/elements/notification.svg" alt=""></a>
							</div>
							<a href="<?php echo e(route('profile')); ?>">
								<div class="user" style="background-image:url(<?php echo e(auth()->user()->photoUrl); ?>);"></div>
							</a>
							<div class="login">
								<form id="logout-form-header" method="post" action="<?php echo e(@route('logout')); ?>">
									<?php echo csrf_field(); ?>
									<span class="key">
										<a href="#" onclick="document.getElementById('logout-form-header').submit(); return false;"><?php echo app('translator')->get('auth.logout'); ?></a>
									</span>
								</form>
							</div>
						<?php endif; ?>
						<?php if(auth()->guard()->guest()): ?>
							<div class="login">
								<a href="<?php echo e(@route('login')); ?>"><?php echo app('translator')->get('auth.login'); ?></a>
							</div>
							<div class="login" style="margin-left: 20px">
								<a href="<?php echo e(@route('reg')); ?>"><?php echo app('translator')->get('auth.reg'); ?></a>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</header>

			<?php echo $__env->yieldContent('content'); ?>
		</div>

		<footer>
			<div class="centered flex between align-top">
				<div class="col1">
					<a href="<?php echo e(route('index')); ?>"><img src="/images/logo.svg" alt=""></a>
					<span><?php echo app('translator')->get('common.title'); ?></span>
				</div>
				<div class="col2">
					<div class="top  flex between align-top">
						<div class="menu flex between align-bottom">
							<div class="col">
								<div class="col-title"><?php echo app('translator')->get('menu.navigation'); ?></div>
								<ul>
									<li><a href="<?php echo e(route('index')); ?>"><?php echo app('translator')->get('menu.index'); ?></a></li>
									<li><a href="<?php echo e(route('specialities')); ?>"><?php echo app('translator')->get('menu.courses'); ?></a></li>
									<li><a href="<?php echo e(route('about')); ?>"><?php echo app('translator')->get('menu.about'); ?></a></li>
								</ul>
							</div>
							<div class="col">
								<ul>

									<li><a href="<?php echo e(route('library')); ?>"><?php echo app('translator')->get('menu.library'); ?></a></li>
									<li><a href="<?php echo e(route('contacts')); ?>"><?php echo app('translator')->get('menu.contacts'); ?></a></li>
								</ul>
							</div>
						</div>
						<?php $__currentLoopData = $footer_pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php echo $page; ?>

						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
					<div class="copyrights flex between align-center">
						<div class="text">
							<p><?php echo app('translator')->get('common.center'); ?></p>
							<p><?php echo app('translator')->get('common.all_rights_reserved'); ?></p>
							<p>
								<a href="/politic.docx" target="_blank"><?php echo app('translator')->get('common.policy'); ?></a><br>
								<a href="/user_soglas.rtf" target="_blank"><?php echo app('translator')->get('common.agreement'); ?></a>
							</p>
						</div>
					</div>
				</div>
				<div class="col3">
					<iframe
						src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3455.0212573133185!2d76.93523764034259!3d43.26577639224208!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38836ea1773f7ef1%3A0xa6c17b8bc2c48d1c!2z0YPQu9C40YbQsCDQltC10LvRgtC-0LrRgdCw0L0gMzcsINCQ0LvQvNCw0YLRiyAwNTAwMDAsINCa0LDQt9Cw0YXRgdGC0LDQvQ!5e0!3m2!1sru!2sru!4v1573301281476!5m2!1sru!2sru"
						width="276" height="200" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
				</div>
			</div>
		</footer>
	</div>

	<script src="<?php echo e(mix('/js/libs.min.js')); ?>"></script>
	<script src="<?php echo e(mix('/js/main.min.js')); ?>"></script>
	<?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html>
<?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/layouts/base.blade.php ENDPATH**/ ?>