<?php $__env->startSection('content'); ?>

    <div class="test width1088">
        <div class="top">
            <div class="left"><?php echo e($test->title); ?></div>
            <div class="right">
                <span class="time-title"><?php echo app('translator')->get('tests.time'); ?></span>
                <span class="time-counter" id="timer" data-init="<?php echo e($endTime); ?>"></span>
            </div>
        </div>
        <div class="progress-bar">
            <div class="progress" style="width: <?php echo e($progressPercent); ?>%;"></div>
        </div>
        <form method="post" action="<?php echo e(route('stepTest', [ 'id' => $test->id ])); ?>">
            <?php echo csrf_field(); ?>
            <?php if(session('errorMessage')): ?>
                <div style="color: red; font-size: 18px; margin-top: 24px;">
                    <?php echo e(session('errorMessage')); ?>

                </div>
            <?php endif; ?>
            <div class="test-body">
                <div class="current"><?php echo app('translator')->get('tests.question'); ?> <?php echo e($questionNumberPretty); ?></div>
                <div class="question"><?php echo e($questionTextPretty); ?></div>
                <div class="answers-block">
                    <div class="answers">
                        <?php $__currentLoopData = $answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="answer">
                                <span class="<?php echo e($answer->className); ?>"><?php echo e($answer->letter); ?></span>
                                <span class="title"><?php echo e($answer->title); ?></span>
                                <input type="radio" name="answer" value="<?php echo e($answer->title); ?>">
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <button class="next"><?php echo app('translator')->get('tests.next'); ?></button>
                </div>
            </div>
        </form>
        <form style="display: none" method="post" id="timeoutForm"
              action="<?php echo e(route('timeoutTest', [ 'id' => $test->id ])); ?>">
            <?php echo csrf_field(); ?>
        </form>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/test.blade.php ENDPATH**/ ?>