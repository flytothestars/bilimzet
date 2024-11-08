<?php $__env->startSection('content'); ?>

	<h2 class="mt-4 mb-3">Чат с <?php echo e($user->full_name); ?></h2>

	<div id="app" class="chat container">
		<chat chatroom="<?php echo e($chatroom->id); ?>" user="<?php echo e($user->id); ?>"></chat>
	</div>





















	<?php $__env->startPush('scripts'); ?>
		<script src="<?php echo e(mix('/js/app.min.js')); ?>"></script>
	<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/admin/chat.blade.php ENDPATH**/ ?>