<?php $__env->startSection('content'); ?>

   <div class="centered page-title width1088">
      <h1><?php echo app('translator')->get('olympics.title_one'); ?> - <?php echo e($courseTitle); ?></h1>
   </div>

   <div class="olympics width1088 flex between wrap align-top" id="app">
      <div class="box-shadow question width1088 p-30 white-background">
         <olympic-question
                 token-key="<?php echo e($token); ?>"
                 remaining-minutes="<?php echo e($remainingMinutes); ?>"
                 remaining-seconds="<?php echo e($remainingSeconds); ?>">
         </olympic-question>
      </div>
   </div>

   <?php $__env->startPush('scripts'); ?>
      <script src="<?php echo e(mix('/js/app.min.js')); ?>"></script>
   <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/olympics/question.blade.php ENDPATH**/ ?>