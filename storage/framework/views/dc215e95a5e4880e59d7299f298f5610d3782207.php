<?php $__env->startSection('content'); ?>

    <div class="centered page-title width1088">
        <h1><?php echo app('translator')->get('about.title'); ?></h1>
    </div>

  <div class="about-text flex between align-top width1088 ">
		<div class="text">

			<?php $__currentLoopData = $about_pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo $page; ?>

			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

		</div>
		<div class="gallery">
			<a class="about_gallery" href="/images/pics/about1.jpg"><img src="/images/pics/about1.jpg" alt=""></a>
			<a class="about_gallery" href="/images/pics/about2.jpg"><img src="/images/pics/about2.jpg" alt=""></a>
			<a class="about_gallery" href="/images/pics/about3.jpg"><img src="/images/pics/about3.jpg" alt=""></a>
		</div>
	</div>

	<div class="testimonials-letters">
		<div class="width1088">
			<div class="title"><?php echo app('translator')->get('about.letters'); ?></div>
			<div class="navi-parent">
				<div class="swiper-button-next nextLetter"><img src="/images/elements/white-arrow-right.svg" alt=""></div>
				<div class="swiper-button-prev prevLetter"><img src="/images/elements/white-arrow-left.svg" alt=""></div>
				<div class="swiper-container swiper-letters">
					<ul class="swiper-wrapper">
						<?php $__currentLoopData = $letters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $letter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<li class="swiper-slide">
								<a href="<?php echo e($letter->image); ?>" target="_blank"><img src="<?php echo e($letter->image); ?>" alt=""></a>
							</li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</ul>
				 </div>
			</div>
		</div>
	</div>

	<div class="teachers">
		<div class="width1088">
			<div class="title"><h3><b><?php echo app('translator')->get('about.team'); ?></b></h3></div>
			<div class="navi-parent">
				<div class="swiper-button-next nextTeachers"><img src="/images/elements/arrow-black-right.svg" alt=""></div>
				<div class="swiper-button-prev prevTeachers"><img src="/images/elements/arrow-black-left.svg" alt=""></div>
				<div class="swiper-container swiper-teachers">
					<ul class="swiper-wrapper">
						<li class="swiper-slide"><img src="/images/teachers/t1.jpg" alt=""></li>
						<li class="swiper-slide"><img src="/images/teachers/t2.jpg" alt=""></li>
						<li class="swiper-slide"><img src="/images/teachers/t3.jpg" alt=""></li>
						<li class="swiper-slide"><img src="/images/teachers/t4.jpg" alt=""></li>
						<li class="swiper-slide"><img src="/images/teachers/t5.jpg" alt=""></li>
						<li class="swiper-slide"><img src="/images/teachers/t6.jpg" alt=""></li>
						<li class="swiper-slide"><img src="/images/teachers/t7.jpg" alt=""></li>
						<li class="swiper-slide"><img src="/images/teachers/t8.jpg" alt=""></li>
						<li class="swiper-slide"><img src="/images/teachers/t9.jpg" alt=""></li>
						<li class="swiper-slide"><img src="/images/teachers/t10.jpg" alt=""></li>
					</ul>
				 </div>
			</div>
		</div>
	</div>

	<div class="testimonials-letters">
		<div class="width1088">
<!----			<div class="title">Наша команда</div>--->
			<div class="navi-parent">
				<div class="swiper-button-next nextTeam"><img src="/images/elements/white-arrow-right.svg" alt=""></div>
				<div class="swiper-button-prev prevTeam"><img src="/images/elements/white-arrow-left.svg" alt=""></div>
				<div class="swiper-container swiper-team">
					<ul class="swiper-wrapper">
						<?php $__currentLoopData = $file_urls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file_url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<li class="swiper-slide">
									<a href="<?php echo e($file_url); ?>" target="_blank"><img src="<?php echo e($file_url); ?>" alt=""></a>
							</li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</ul>
				 </div>
			</div>
		</div>
	</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/about.blade.php ENDPATH**/ ?>