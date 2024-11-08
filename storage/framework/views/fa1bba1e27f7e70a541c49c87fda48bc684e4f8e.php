<?php $__env->startSection('content'); ?>

	<div class="width1088 mt-3">
		<div class="subcat">
			<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="subcat-tab <?php echo e($loop->first ? 'current' : ''); ?>" data-target="<?php echo e($loop->index); ?>">
					<a class="btn subcat-contests contests-<?php echo e($category->id); ?>" data-id="<?php echo e($loop->index); ?>">
						<?php echo e($category->name); ?>

					</a>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
	</div>

	<div class=" width1088 swiper-container contests-tabs swiper-tabs">
		<div class="swiper-wrapper fix">
			<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="swiper-slide flex between align-top wrap">
					<?php $__currentLoopData = $category->contests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<div class="konkurs">
							<img src="<?php echo e($contest->getUploadedUrl('picture')); ?>" alt="">
							<div class="title">
								<a href="<?php echo e(route('contest', [ 'id' => $contest->id ])); ?>"><?php echo e($contest->title); ?></a>
							</div>
							<a href="#" class="download"><?php echo app('translator')->get('contests.download'); ?></a>
							<div class="awards flex start align-center">
								<img src="/img/award.svg" alt="">
								<span><?php echo e($contest->text_on_picture); ?></span>
							</div>
							<div class="members">
								<div class="title"><?php echo app('translator')->get('contests.competitors'); ?></div>
								<?php $__currentLoopData = $contest->testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<div class="member flex start align-center">
										<img src="<?php echo e($testimonial->user->photoUrl); ?>" alt="">
										<span><?php echo e($testimonial->user->full_name); ?></span>
									</div>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
							<a href="<?php echo e(route('contest', [ 'id' => $contest->id ])); ?>"
								class="bigbluebtn flex align-center center"><?php echo app('translator')->get('contests.read'); ?></a>
						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<span class="empty"></span>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
	</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/contests.blade.php ENDPATH**/ ?>