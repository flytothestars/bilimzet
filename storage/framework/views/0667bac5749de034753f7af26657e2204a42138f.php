<?php $__env->startSection('content'); ?>

    <div class="podacha-statyi-profile lk width1088">
        <div class="wrap profile width1088 flex between align-center">
            <div class="photo-name flex between align-center">
                <img src="<?php echo e($user->photoUrl); ?>" alt="">
                <div class="name">
                    <p><?php echo e($user->full_name); ?></p>
                </div>
            </div>
            <div class="contacts">
                <div class="col">
                    <span class="email"><a href="mailto:<?php echo e($user->email); ?>"><?php echo e($user->email); ?></a></span>
                    <span class="phone"><a href="tel:<?php echo e($user->phone); ?>"><?php echo e($user->phone); ?></a></span>
                </div>
                <div class="col">
                    <span class="geo"><?php echo e($user->address); ?></span>
                    <span class="role"><?php echo e($user->position); ?></span>
                </div>
            </div>
        </div>

        <div class="my-articles articles-listing-wrap width1088">
            <div class="title"><?php echo app('translator')->get('common.articles'); ?></div>
            <div class="articles-listing">
                <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="row flex between align-center published">
                        <div class="left"><a href="<?php echo e(route('showLibraryItem', ['id' => $article->id])); ?>"><?php echo e($article->title); ?></a></div>
                        <div class="right"><a href="<?php echo e(route('showLibraryItem', ['id' => $article->id])); ?>"><?php echo app('translator')->get('common.read_article'); ?></a></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/user.blade.php ENDPATH**/ ?>