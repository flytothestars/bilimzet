<div class="gid">
	<div class="centered page-title width1088">
		<h1><?php echo app('translator')->get('home.guide'); ?></h1>
	</div>

	<div class="width1088 accordion">
		<?php $__currentLoopData = $guides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $guide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

			<h3><?php echo e($guide->title); ?></h3>
			<div>
				<?php echo $guide->text; ?>

				<div class="text-center" style="text-align: center;">
					<iframe class="guide-video" src="<?php echo e($guide->video); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
</div>
<?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/parts/guide.blade.php ENDPATH**/ ?>