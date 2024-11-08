<?php $__env->startSection('content'); ?>

	<div class="specials">
		<div class="centered flex between align-center">
			<div class="left">
				<ul class="breadcrumbs">
					<li><a href="<?php echo e(route('index')); ?>"><?php echo app('translator')->get('menu.index'); ?></a></li>
					<li><a href="<?php echo e(route('specialities')); ?>"><?php echo app('translator')->get('menu.courses'); ?></a></li>
					<li>
						<a href="<?php echo e(route('specialities', ['tab' =>
                                \App\Data\CourseSpecialityTabs::getTabNumberForCategory($item->category)])); ?>">
							<?php echo e(\App\Data\CourseSpecialityCategories::getParentCategory($item->category)); ?>

						</a>
					</li>
					<li><?php echo e($item->title); ?></li>
				</ul>
				<h1><?php echo e($item->title); ?></h1>
			</div>
			<img src="/images/elements/specials-icon.svg" alt="">
		</div>
	</div>

	<div class="themes courses-listing centered specials-rows">
		<?php $__empty_1 = true; $__currentLoopData = $item->courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
			<div class="row">
				<div class="left flex between align-center">
					<div class="colored-block <?php echo e($loop->index % 2 === 0 ? 'green' : 'red'); ?>"></div>
					<a href="<?php echo e(route('course', ['id' => $course->id])); ?>" class="title-course">
						<?php echo e(\Illuminate\Support\Facades\Lang::getLocale() == 'kz' ? (empty($course->title_kz) ? $course->title : $course->title_kz) : $course->title); ?>

					</a>
				</div>
				<div class="right flex start align-center">
					<div class="author">
						<p><?php echo app('translator')->get('courses.teacher'); ?></p>
						<img style="max-width: 28px; max-height: 28px" src="<?php echo e($course->getUploadedUrl('author_photo')); ?>" alt="">

						<?php echo e(\Illuminate\Support\Facades\Lang::getLocale() == 'kz' ? (empty($course->author_fio_kz) ? $course->author_fio : $course->author_fio_kz) : $course->author_fio); ?>


					</div>
					<div class="link">
						<a href="<?php echo e(route('course', ['id' => $course->id])); ?>" class="btn transparent">
							<?php echo app('translator')->get('courses.go'); ?>
						</a>
					</div>
				</div>
			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
			<p style="font-size: 1.4rem">
				<?php echo app('translator')->get('courses.no_courses'); ?>
			</p>
		<?php endif; ?>

	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/speciality.blade.php ENDPATH**/ ?>