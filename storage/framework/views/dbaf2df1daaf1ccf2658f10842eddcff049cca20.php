<?php $__env->startSection('content'); ?>

    <div class="results-top">
        <div class="centered flex between align-center">
            <h1><?php echo app('translator')->get('search.results'); ?></h1>
            <div class="search-wrap">
                <form class="flex between align-center">
                    <input value="<?php echo e(Request::get('search')); ?>" name="search" type="search"
									placeholder="<?php echo app('translator')->get('search.marketing'); ?>">
                    <select name="course_type">
                        <option value="*"><?php echo app('translator')->get('search.any_type'); ?></option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $subcategories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option <?php echo e(Request::get('course_type') === $category ? 'selected' : ''); ?>>
                                <?php echo e($category); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <button><img src="/images/elements/blue-search-btn.svg" alt=""></button>
                </form>
            </div>
        </div>
    </div>

    <?php if(count($items) > 0): ?>
        <div class="themes courses-listing centered">
            <h2><?php echo app('translator')->get('search.found'); ?> <?php echo e(count($items)); ?></h2>
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="row">
                    <div class="left flex start align-center">
                        <div class="colored-block <?php echo e($loop->index % 2 === 0 ? 'green' : 'red'); ?>"></div>
                        <a href="#" class="title-course"><?php echo e($item->title); ?></a>
                    </div>
                    <div class="right flex between align-center">
                        <div class="author">
                            <p><?php echo app('translator')->get('search.author'); ?></p>
                            <img style="max-width: 28px; max-height: 28px" src="<?php echo e($item->getUploadedUrl('author_photo')); ?>" alt="">
                            <a href="<?php echo e(route('course', ['id' => $item->id])); ?>" class="author-name"><?php echo e($item->author_fio); ?></a>
                        </div>
                        <div class="link">
                            <a href="<?php echo e(route('course', ['id' => $item->id])); ?>"
                               class="btn transparent"><?php echo app('translator')->get('search.go'); ?></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="themes noresult courses-listing centered">
            <p class="noresults"><?php echo app('translator')->get('search.nothing'); ?></p>
        </div>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/search.blade.php ENDPATH**/ ?>