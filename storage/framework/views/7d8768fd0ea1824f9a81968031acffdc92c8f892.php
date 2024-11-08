<?php $__env->startSection('content'); ?>

	<ul class="width1088 categories-listing">
		<li class="qualification <?php echo e($tab === 1 ? 'active' : ''); ?>">
			<a href="?tab=1"><?php echo e($categoryNames[0]); ?></a>
		</li>
		<li class="retraining <?php echo e($tab === 2 ? 'active' : ''); ?>">
			<a href="?tab=2"><?php echo e($categoryNames[1]); ?></a>
		</li>
	</ul>

	<div class="width1088">
		<div class="subcat">
			<?php $__currentLoopData = $subcategoryNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategoryName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="subcat-tab <?php echo e($loop->first ? 'current' : ''); ?>" data-target="<?php echo e($loop->index); ?>">
					<a class="btn subcat-courses courses-<?php echo e($loop->index); ?>" data-id="<?php echo e($loop->index); ?>">
						<?php echo e($subcategoryName); ?>

					</a>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
	</div>

	<div class="width1088 swiper-container specialities-tabs swiper-tabs">
		<div class="swiper-wrapper">
			<?php $__currentLoopData = $subcategoriesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courses): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="swiper-slide flex between align-top wrap">
					<?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<a href="<?php echo e(route('speciality', ['id' => $course->id])); ?>" class="flex align-center center wrap" style="background: <?php echo e($course->picture_background); ?>;">
							<img style="max-width: 90px; max-height: 90px; height: auto" src="<?php echo e($course->getUploadedUrl('picture')); ?>" alt="">
							<span><?php echo e($course->title); ?></span>
						</a>
						<?php if($loop->last): ?>
							<?php if($loop->count % 3 === 1): ?>
								<span class="empty"></span>
								<span class="empty"></span>
							<?php elseif($loop->count % 3 === 2): ?>
								<span class="empty"></span>
							<?php endif; ?>
						<?php endif; ?>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/specialities.blade.php ENDPATH**/ ?>