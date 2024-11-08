<?php $__env->startSection('content'); ?>

	<?php echo $__env->make('parts.profileMenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<div class="width1088 page-title">
		<h1><?php echo app('translator')->get('tests.my_tests'); ?></h1>
	</div>

	<div class="my-articles width1088">
		<?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<div style="margin-bottom: 25px; font-size: 20px; color: #333">
				<?php echo app('translator')->get('tests.course'); ?> <a style="color: #0C85D5" href="<?php echo e(route('course', ['id' => $course->id])); ?>"><?php echo e($course->title); ?></a>
				<ul style="margin-left: 40px; font-size: 18px; line-height: 25px">
					<?php $__empty_1 = true; $__currentLoopData = $course->tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
						<li>
							<?php echo app('translator')->get('tests.test'); ?> <a style="color: #00b9ff"><?php echo e($test->title); ?></a>, <?php echo app('translator')->get('tests.results'); ?>:
							<?php if($test->total_answers > 0): ?>
								<span style="color: green;"><?php echo e($test->correct_answers); ?>/<?php echo e($test->total_answers); ?></span>
								<?php if($test->certificateId > 0): ?>
									<span style="color: green;"><?php echo app('translator')->get('tests.out'); ?></span>
								<?php else: ?>
									<span style="color: red;"><?php echo app('translator')->get('tests.not_out'); ?></span>
								<?php endif; ?>
							<?php else: ?>
								<span style="color: red;"><?php echo app('translator')->get('tests.not_pass'); ?></span>
							<?php endif; ?>

							<?php if($test->no_cert): ?>
								<input type="button" value="<?php echo e($test->is_test ? __('retake') : __('pass')); ?>"
										 onClick="window.location.href='<?php echo e(route('viewTest', ['id' => $test->id])); ?>'">
							<?php endif; ?>
						</li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
						<li><i><?php echo app('translator')->get('tests.no_tests'); ?></i></li>
					<?php endif; ?>
				</ul>
			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/myTests.blade.php ENDPATH**/ ?>