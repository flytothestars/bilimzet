<?php $__env->startSection('content'); ?>

	<div class="centered page-title width1088">
		<h1><?php echo e($item->title); ?></h1>
		<?php if(session('errorMessage')): ?>
			<div style="margin-bottom: 32px; color: red; font-size: 18px;">
				<?php echo e(session('errorMessage')); ?>

			</div>
		<?php endif; ?>
	</div>

	<div class="course flex start align-top width1088">
		<div class="left">
			<div class="top"><?php echo app('translator')->get('courses.author'); ?></div>
			<div class="about flex start align-center">
				<div class="photo">
					<img style="max-width: 145px;" src="<?php echo e($item->getUploadedUrl('author_photo')); ?>" alt="">
				</div>
				<div class="text">
					<p class="name"><?php echo e($item->author_fio); ?></p>
					<ul>
						<li><?php echo e($item->author_position); ?></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="right">
			<div class="top"><?php echo app('translator')->get('courses.description'); ?></div>
			<div class="text">
				<?php echo $item->desc_text; ?>

			</div>
		</div>
	</div>

	<div class="pay-table width1088">
		<div class="top"><?php echo app('translator')->get('courses.price'); ?></div>
		<table>
			<?php $__currentLoopData = $item->parts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td>
					  <span class="left">
							<span class="hours"><?php echo e($part->duration_hours); ?> <?php echo app('translator')->get('courses.price'); ?></span>
							<span class="cost"><?php echo e($part->price_kzt); ?> Тг.</span>
					  </span>
					</td>
					<td>
						<a target="_blank" href="<?php echo e($part->getUploadedUrl('plan')); ?>"
							download="<?php echo e($part->real_plan_name); ?>"><?php echo app('translator')->get('courses.download'); ?></a>
						<?php if($purchasedIds->contains($part->id)): ?>
							<a href="/handouts" class="buy"><?php echo app('translator')->get('courses.read'); ?></a>
						<?php else: ?>
							<a href="<?php echo e(route('buyCoursePart', ['courseId' => $item->id, 'partId' => $part->id])); ?>"
								class="buy"><?php echo app('translator')->get('courses.buy'); ?></a>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</table>
	</div>

	<div class="course-benefits">
		<div class="width1088">
			<div class="title"><?php echo app('translator')->get('courses.benefits'); ?></div>
			<div class="items flex between align-top wrap">
				<div class="item">
					<img src="/images/courses/benefits/1.svg" alt="">
					<div class="title"><?php echo app('translator')->get('courses.benefit1'); ?></div>
					<div class="num">01</div>
				</div>
				<div class="item">
					<img src="/images/courses/benefits/2.svg" alt="">
					<div class="title"><?php echo app('translator')->get('courses.benefit2'); ?></div>
					<div class="num">02</div>
				</div>
				<div class="item">
					<img src="/images/courses/benefits/3.svg" alt="">
					<div class="title"><?php echo app('translator')->get('courses.benefit3'); ?></div>
					<div class="num">03</div>
				</div>
				<div class="item">
					<img src="/images/courses/benefits/4.svg" alt="">
					<div class="title title_big"><?php echo app('translator')->get('courses.benefit4'); ?></div>
					<div class="num">04</div>
				</div>
				<div class="item">
					<img src="/images/courses/benefits/5.svg" alt="">
					<div class="title"><?php echo app('translator')->get('courses.benefit5'); ?></div>
					<div class="num">05</div>
				</div>
				<div class="item">
					<img src="/images/courses/benefits/6.svg" alt="">
					<div class="title title_small"><?php echo app('translator')->get('courses.benefit6'); ?></div>
					<div class="num">06</div>
				</div>
			</div>
		</div>
	</div>

	<div class="about-course width1088">
		<div class="row-block flex between align-top">
			<div class="block">
				<div class="block-title"><span><?php echo app('translator')->get('courses.listeners_cat'); ?>:</span></div>
				<div class="text">
					<?php echo $item->listeners_category_text; ?>

				</div>
			</div>
			<div class="block">
				<div class="block-title"><span><?php echo app('translator')->get('courses.goals'); ?></span></div>
				<div class="text">
					<?php echo $item->goals_text; ?>

				</div>
			</div>
		</div>
		<div class="block-title"><span><?php echo app('translator')->get('courses.tasks'); ?></span></div>
		<div class="text -double-col">
			<?php echo $item->tasks_text; ?>

		</div>

		<div class="block-title">
			<span><?php echo app('translator')->get('courses.organization'); ?></span>
		</div>
		<div class="text -double-col">
			<?php echo $item->organization_text; ?>

		</div>
	</div>

	<div id="testimonials" class="testimonials width1088">
		<div class="block-title">
			<?php if(auth()->guard()->check()): ?>
				<span><?php echo app('translator')->get('courses.leave_review'); ?></span>
			<?php else: ?>
				<span><?php echo app('translator')->get('courses.reviews'); ?></span>
			<?php endif; ?>
		</div>
		<?php if(auth()->guard()->check()): ?>
			<form action="<?php echo e(route('storeCourseTestimonial', ['id' => $item->id])); ?>" method="post"
					class="flex between align-top">
				<?php echo csrf_field(); ?>
				<div class="user">
					<img src="<?php echo e(auth()->user()->photoUrl); ?>" alt="">
					<div class="text">
						<div class="name"><?php echo app('translator')->get('courses.you'); ?></div>
					</div>
				</div>
				<div class="form">
					<textarea name="text" placeholder="<?php echo app('translator')->get('courses.leave'); ?>"></textarea>
					<?php if($errors->count()): ?>
						<span style="color: red; margin-right: 24px;"><?php echo e($errors->first()); ?></span>
					<?php endif; ?>
					<input type="submit" value="<?php echo app('translator')->get('courses.send'); ?>">
				</div>
			</form>
		<?php else: ?>
			<form action="<?php echo e(route('storeCourseTestimonial', ['id' => $item->id])); ?>" method="post"
					class="flex between align-top">
				<?php echo csrf_field(); ?>
				<div class="user">
					<img src="/images/no_avatar.png" alt="">
					<div class="text">
						<div class="name"><?php echo app('translator')->get('courses.you'); ?></div>
					</div>
				</div>
				<div class="form">
					<textarea name="text" placeholder="<?php echo app('translator')->get('courses.leave'); ?>"></textarea>
					<?php if($errors->count()): ?>
						<span style="color: red; margin-right: 24px;"><?php echo e($errors->first()); ?></span>
					<?php endif; ?>
					<input type="submit" value="<?php echo app('translator')->get('courses.send'); ?>">
				</div>
			</form>
		
		<?php endif; ?>
		<?php $__empty_1 = true; $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
			<div class="testimonial flex between align-top">
				<div class="user">
					<img src="<?php echo e($testimonial->user->photoUrl); ?>" alt="">
					<div class="text">
						<div class="name"><?php echo e($testimonial->user->full_name); ?></div>
					</div>
				</div>
				<div class="text">
					<div class="top flex between align-center">
						<div class="left flex start align-center">
							<div class="date"><?php echo e($testimonial->created_at->format('d.m.Y H:i')); ?> UTC</div>
						</div>
					</div>
					<div class="bottom">
						<p><?php echo e($testimonial->text); ?></p>
					</div>
				</div>
			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
			<p><?php echo app('translator')->get('courses.no_reviews'); ?></p>
		<?php endif; ?>
	</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/course.blade.php ENDPATH**/ ?>