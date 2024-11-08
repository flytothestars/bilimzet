<?php $__env->startSection('content'); ?>

    <div class="top-poly-bg"></div>

    <div class="thanks-title"><?php echo app('translator')->get('tests.thanks'); ?></div>
    <div class="thanks-text">
        <p><?php echo app('translator')->get('tests.you_pass'); ?> <b>"<?php echo e($item->title); ?>".</b></p>
        <p><?php echo app('translator')->get('tests.correct'); ?>: <?php echo e($correctAnswers); ?> / <?php echo e($totalAnswers); ?></p>
        <p><?php echo app('translator')->get('tests.page'); ?> <a href="<?php echo e(route('myTests')); ?>"><?php echo app('translator')->get('tests.my_tests'); ?></a>
			  <?php echo app('translator')->get('tests.other'); ?>
        </p>
        <p>
            <a href="<?php echo e(route('viewTest', ['id' => $item->id])); ?>"><?php echo app('translator')->get('tests.retest'); ?></a>
        </p>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/testDoneThanks.blade.php ENDPATH**/ ?>