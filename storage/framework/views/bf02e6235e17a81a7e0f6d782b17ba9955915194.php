<?php $__env->startSection('content'); ?>

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&display=swap&subset=cyrillic" rel="stylesheet">
	<div class="login flex between align-top width1088 shadow">
		<div class="left">
			<div class="top">
				<img src="/images/blue-logo.png" alt="">
				<span><?php echo app('translator')->get('auth.welcome'); ?></span>
			</div>
			<p><?php echo app('translator')->get('auth.about'); ?></p>
		</div>
		<div class="right">
			<div class="wrap">
				<div class="title"><?php echo app('translator')->get('auth.login'); ?></div>
				<form action="/login" method="post">
					<?php echo csrf_field(); ?>
					<input type="email" name="email" value="<?php echo e(@old("email")); ?>" placeholder="E-mail*">
					<input type="password" name="password" placeholder="<?php echo app('translator')->get('auth.password'); ?>">
					<div class="flex between align-center">
						<label><input type="checkbox"/> <?php echo app('translator')->get('auth.remember'); ?></label>
						<a href="#"><?php echo app('translator')->get('auth.forgot'); ?></a>
					</div>
					<?php if($errors->count()): ?>
						<div class="step2" style="color: red; font-size: 16px; margin-top: 16px">
							<?php echo e($errors->first()); ?>

						</div>
					<?php endif; ?>
					<div class="submites flex center align-center">
						<button type="submit"><?php echo app('translator')->get('auth.enter'); ?></button>
						<a href="<?php echo e(route('reg')); ?>"><?php echo app('translator')->get('auth.reg'); ?></a>
					</div>
				</form>
			</div>
		</div>
	</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/login.blade.php ENDPATH**/ ?>