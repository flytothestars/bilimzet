<?php $__env->startSection('content'); ?>

    <div class="centered page-title width1088">
        <h1><?php echo e($courseTitle); ?></h1>
    </div>

    <div class="olympics">
        <div class="centered olympic-is-end">
            <div class="certificate">
                <?php if($letterImage): ?>
                    <img src="/uploads/courses/letter/<?php echo e($letterImage); ?>">
                <?php endif; ?>
                    <img src="/uploads/courses/diploma/<?php echo e($certificateImage); ?>">
            </div>
            <div class="col-md-12" style="display:flex; justify-content: center;">
                <?php if($letterImage): ?>
                    <a href="<?php echo e(route('olympic.download', $id)); ?>?type=letter">Скачать грамоту</a>
                <?php endif; ?>
                    <a href="<?php echo e(route('olympic.download', $id)); ?>?type=diploma">Скачать диплом</a>
            </div>
            <div class="results">
                <h1><?php echo app('translator')->get('olympics.result'); ?></h1>
                <span class="duration"><?php echo app('translator')->get('olympics.duration'); ?> <?php echo e($durationText); ?></span>
                <?php $__empty_1 = true; $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="question">
                    <h3><?php echo e($result['questionText']); ?></h3>
                    <ul>
                        <li><?php echo app('translator')->get('olympics.right_answer'); ?> <?php echo e($result['correctAnswerText']); ?></li>
                        <li class="<?php echo e($result['isCorrectAnswer'] ? 'correctAnswer' : 'incorrectAnswer'); ?>"><?php echo app('translator')->get('olympics.own_answer'); ?> <?php echo e($result['userAnswer']); ?></li>
                    </ul>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="no-results"><?php echo app('translator')->get('olympics.no_answers'); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/olympics/result.blade.php ENDPATH**/ ?>