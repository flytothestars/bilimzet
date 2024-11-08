<?php $__env->startSection('content'); ?>

	<?php echo $__env->make('parts.profileMenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<div class="width1088 page-title">
		<h1><?php echo app('translator')->get('notifications.title'); ?></h1>
	</div>

    <div class="notifications centered">
        <?php $__empty_1 = true; $__currentLoopData = $items ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="row">
                <div class="top flex between align-center">
                    <div class="left flex start align-center">
                        <img src="/images/elements/newtask.svg" alt="" class="notify-ico">
                        <p><?php echo e($item->title); ?></p>
                    </div>
                    <div class="date"><?php echo e($item->created_at->format('d.m.Y H:i')); ?> UTC</div>
                </div>
                <div class="bottom flex between align-center">
                    <div class="left flex start align-center">
                        <div class="num"><?php echo e(sprintf("%02d", $loop->iteration)); ?></div>
                        <div class="text">
                            <p><?php echo $item->desc; ?></p>
                        </div>
                    </div>
                    <?php if($item->link): ?>
                        <div class="link">
                            <a href="<?php echo e($item->link); ?>" class="btn transparent"><?php echo app('translator')->get('notifications.go'); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p style="font-size: 1.2rem"><?php echo app('translator')->get('notifications.no_items'); ?></p>
        <?php endif; ?>
    </div>

    <?php echo $__env->make('parts.recommendations', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/notifications.blade.php ENDPATH**/ ?>