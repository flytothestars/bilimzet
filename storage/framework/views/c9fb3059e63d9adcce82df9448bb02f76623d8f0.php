<?php $__env->startSection('content'); ?>
    <div class="top-poly-bg"></div>

    <div class="thanks-title">Благодарим за покупку части курса</div>
    <p class="thanks-text">
        Вы приобрели часть курса <b>"<?php echo e($item->course->title); ?>".</b>
        <br>На <a href="<?php echo e(route('course', ['id' => $item->course_id])); ?>">странице курса</a> вы сможете
        <a href="/handouts">ознакомиться с материалами курса</a>.
        <br>На странице <a href="<?php echo e(route('myTests')); ?>">мои тесты</a> вы можете пройти тесты для купленных вами курсов.
    </p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/buyCoursePartThanks.blade.php ENDPATH**/ ?>