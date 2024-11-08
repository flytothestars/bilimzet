<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('parts.profileMenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="centered page-title width1088">
        <h1><?php echo app('translator')->get('certificates.title'); ?></h1>
    </div>

    <div class="sertificates width1088 flex between wrap align-top">
        <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a class="item group" href="<?php echo e($item->getUploadedUrl('file')); ?>">
                <img src="<?php echo e($item->getUploadedUrl('file')); ?>" alt=""/>
                <span><?php echo e($item->title); ?></span>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p><?php echo app('translator')->get('certificates.no_certificates'); ?></p>
        <?php endif; ?>
        <span class="item empty"></span>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/certificates.blade.php ENDPATH**/ ?>