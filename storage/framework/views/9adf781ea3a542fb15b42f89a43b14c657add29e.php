<?php $__env->startSection('content'); ?>

    <div class="width1088 page-title">
        <h1><?php echo app('translator')->get('home.news_events'); ?></h1>
    </div>

    <div class="news">
        <div class="width1088 flex between wrap">
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="news-item">
						 <img src="<?php echo e($item->getUploadedUrl('miniature')); ?>" alt="">
						 <div class="date"><img src="images/elements/date.svg" alt=""><span><?php echo e($item->date); ?></span></div>
						 <div class="title"><a href="<?php echo e(route('newPost', [ 'id' => $item->id ])); ?>"><?php echo e($item->name); ?></a></div>
						 <div class="link"><a href="<?php echo e(route('newPost', [ 'id' => $item->id ])); ?>"><?php echo app('translator')->get('home.more'); ?></a></div>
					</div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="more"><a href="#"><?php echo app('translator')->get('common.more'); ?></a></div>
    </div>

    <div class="mt-5 mb-4">
        <?php echo e($items->links()); ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/news.blade.php ENDPATH**/ ?>