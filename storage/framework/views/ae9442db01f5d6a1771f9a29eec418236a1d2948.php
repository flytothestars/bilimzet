<?php $__env->startSection('content'); ?>

	<?php echo $__env->make('parts.profileMenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<?php
		$colors_pos = 0;
		$colors = [ "red", "yellow", "blue", "green", "light_green" ];
	?>

	<?php if(empty($show_details)): ?>
		<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

			<h1 class="centered material-title"><?php echo e($item->course->title); ?></h1>
			<div class="colored row blue flex between align-center centered" style="height: 60px;">
			<!--
				<div class="left"><img src="images/elements/recommendations.svg" alt=""></div>
				<div class="right"><a class="btn black" href="#">Скачать</a></div>
				-->
			</div>
			<div class="materials centered">



				<div class="material-row">
					<div class="top flex between align-center">
						<div class="left flex start align-center">
							<div class="num"><?php echo e($loop->iteration); ?></div>
							<div class="course-title"><?php echo e($item->course->title); ?></div>
						</div>
						<div class="right">
							<div class="author flex end align-center">
								<p><?php echo app('translator')->get('handouts.author'); ?></p>
								<img style="max-width: 28px; max-height: 28px" src="<?php echo e($item->course->getUploadedUrl('author_photo')); ?>" alt="">
								<?php echo e($item->course->author_fio); ?>

							</div>
						</div>
					</div>

					<form action="/handouts" id="additional_info_<?php echo e($item->id); ?>">
						<input type="hidden" name="show_details" value="<?php echo e($item->id); ?>">
						<input type="hidden" name="course_title_id" value="<?php echo e($item->course->title); ?>">
						<input type="hidden" name="author_name" value="<?php echo e($item->course->author_fio); ?>">
						<input type="hidden" name="author_photo" value="<?php echo e($item->course->getUploadedUrl('author_photo')); ?>">
						<input type="hidden" name="file_1"
								 value="<?php echo e(route('downloadCoursePartFile', [ 'courseId' => $item->course->id, 'partId' => $item->id ])); ?>">
					</form>

					<div class="colored row <?php echo e($colors[$colors_pos]); ?> flex between align-center centered">
						<div class="left"><img src="images/elements/recommendations.svg" alt=""><span><?php echo app('translator')->get('handouts.recommendation'); ?>: <?php echo e($item->duration_hours); ?> <?php echo app('translator')->get('handouts.hours'); ?></span></div>
						<div class="right">
							<a class="btn black" href="javascript:document.getElementById('additional_info_<?php echo e($item->id); ?>').submit();"><?php echo app('translator')->get('handouts.go'); ?></a>
						</div>
					</div>
				</div>


			</div>
				<div class="start-test flex between align-center">
				<div class="left"><?php echo app('translator')->get('handouts.done'); ?></div>
				<div class="right"><a class="btn blue" href="/tests"><?php echo app('translator')->get('handouts.begin'); ?></a></div>
			</div>

			<?php
			$colors_pos++;
			if ($colors_pos >= count($colors))
				$colors_pos = 0;
			?>

		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

	<?php else: ?>

		<div class="centered page-title flex start align-center material-inner-title">
			<a href="/handouts"><img src="/images/elements/arrow-black-left-big.svg" alt=""></a>
			<div class="num">01</div>
			<h1><?php echo e($course_title_id); ?></h1>
		</div>
		<div class="colored row blue flex between align-center centered">

			<div class="right flex end align-center">
				<p style="margin-right:10px;"><?php echo app('translator')->get('handouts.author'); ?></p>
				<img style="max-width: 28px; max-height: 28px" src="<?php echo e($author_photo); ?>" alt=""><?php echo e($author_name); ?>

			</div>
		</div>

		<div class="materials themes centered">
			<?php $__currentLoopData = $additional_files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad_file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="row">
					<div class="left flex between align-top">
						<div class="extension"><span class="docx">PDF</span></div>
						<div class="doc">
							<div class="doc-title">
								<?php if($real_names[$ad_file] != ""): ?>
									<?php echo e($real_names[$ad_file]); ?>

								<?php else: ?>
									<?php echo e(basename($ad_file)); ?>

								<?php endif; ?>
							</div>
						</div>
					</div>
					<div class="right flex between align-center">
						<div class="link">
							<a href="<?php echo e($ad_file); ?>" download="<?php echo e($real_names[$ad_file]); ?>" class="btn transparent"><?php echo app('translator')->get('handouts.download'); ?></a>
							<a href="<?php echo e($ad_file); ?>" class="btn transparent" target="_blank"><?php echo app('translator')->get('handouts.go'); ?></a>
						</div>
					</div>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>

	<?php endif; ?>












<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/handouts.blade.php ENDPATH**/ ?>