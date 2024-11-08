<?php $__env->startSection('content'); ?>

    <div class="centered page-title align">
        <h1><?php echo app('translator')->get('library.title'); ?></h1>
    </div>

	 <div class="biblioteka-menu centered flex between align-center">
		 <ul>
			 <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				 <li class="<?php echo e($currentCategory == $category['id'] ? 'active' : ''); ?>">
					 <a href="?category=<?php echo e($category['id']); ?>" class="btn subcat-contests contests-<?php echo e($category['id']); ?>" data-id="<?php echo e($category['id']); ?>">
						 <?php echo e($category['name']); ?>

					 </a>
				 </li>
			 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		 </ul>
	 </div>
	 <div class="search-box">
		 <div class="search">
			 <form class="flex start align-top">
				 <input type="search">
				 <button><img src="/images/elements/search-btn.svg" alt=""></button>
			 </form>
		 </div>
	 </div>

    <div class="themes centered">
        <h2><?php echo app('translator')->get('library.last'); ?></h2>
        <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="row">
                <div class="left flex between align-top">
                    <div class="extension"><span class="docx"><?php echo e($item->document_extension); ?></span></div>
                    <div class="doc">
                        <div class="doc-title"><?php echo e($item->title); ?></div>
                        <div class="flex start align-center">
                            <span class="saves">1</span>
                            <span class="date"><?php echo e($item->created_at->format('d.m.Y')); ?></span>
                        </div>
                    </div>
                </div>
                <div class="right flex between align-center">
                    <div class="author">
                        <p><?php echo app('translator')->get('library.author'); ?></p>
                        <img style="max-width: 28px; max-height: 28px;" src="<?php echo e($item->author->photoUrl); ?>" alt="">
                        <a href="<?php echo e(route('profileUser', [ 'id' => $item->author->id ])); ?>" class="author-name"><?php echo e($item->author->full_name); ?></a>
                    </div>
                    <div class="link">
                        <a href="<?php echo e(route('showLibraryItem', [ 'id' => $item->id ])); ?>" class="btn transparent"><?php echo app('translator')->get('library.go'); ?></a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <h3><?php echo app('translator')->get('library.no_items'); ?></h3>
        <?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/library.blade.php ENDPATH**/ ?>