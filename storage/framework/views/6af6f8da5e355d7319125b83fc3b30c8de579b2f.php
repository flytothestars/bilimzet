<?php $__env->startSection('content'); ?>

	<div class="centered page-title width1088">
		<h1><?php echo e($item->name ?? ''); ?></h1>
	</div>

	<div class="width1088">
		<div class="wrapper">
			<div class="image">
				<img src="<?php echo e($item->getUploadedUrl('miniature')); ?>" alt="">
			</div>
			<div class="text">
				<?php echo $item->text; ?>

			</div>
		</div>
	</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/new.blade.php ENDPATH**/ ?>