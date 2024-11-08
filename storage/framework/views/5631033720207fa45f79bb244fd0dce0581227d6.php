<?php $__env->startSection('content'); ?>
    <div class="top-poly-bg"></div>

    <div class="thanks-title"><?php echo app('translator')->get('buy.thanks_title'); ?></div>
    <p class="thanks-text">
		 <?php echo app('translator')->get('buy.purchased'); ?> <b>"<?php echo e($item->course->title); ?>".</b>
       <br><?php echo app('translator')->get('buy.on'); ?> <a href="<?php echo e(route('course', ['id' => $item->course_id])); ?>"><?php echo app('translator')->get('buy.page'); ?></a> <?php echo app('translator')->get('buy.you_can'); ?>
       <a href="/handouts"><?php echo app('translator')->get('buy.hangout'); ?></a>.
       <br><?php echo app('translator')->get('buy.on_page'); ?> <a href="<?php echo e(route('myTests')); ?>"><?php echo app('translator')->get('buy.my_tests'); ?></a> <?php echo app('translator')->get('buy.pass_tests'); ?>
    </p>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/buyCoursePartThanks.blade.php ENDPATH**/ ?>