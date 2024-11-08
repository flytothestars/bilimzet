<?php $__env->startSection('content'); ?>

	<?php echo $__env->make('parts.profileMenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<div class="white-wrap-border width1088">
		<div class="width1088 page-title">
			<h1><?php echo app('translator')->get('contests.my'); ?></h1>
		</div>

		<div class="width1088 accordion">
			<?php $__currentLoopData = $contests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<h3><a href="<?php echo e(route('contest', [ 'id' => $contest->id ])); ?>"><?php echo e($contest->title); ?></a></h3>
				<div>
					<form class="konkurs-link-file" action="<?php echo e(route('myContests.store', [ 'id' => $contest->id ])); ?>" method="post" enctype="multipart/form-data">
						<?php echo csrf_field(); ?>
						<div class="flex between align-bottom">
							<div class="col col1">
								<label><?php echo app('translator')->get('contests.video'); ?></label>
								<input type="text" name="video" placeholder="<?php echo app('translator')->get('contests.link'); ?>">
							</div>
							<div class="input__wrapper col col2">
								<input type="file" name="file" id="input__file" accept="<?php echo e($accept); ?>" class="input input__file" multiple>
								<label for="input__file" class="input__file-button">
									<span class="input__file-button-text"><?php echo app('translator')->get('contests.attach'); ?></span>
									<span class="input__file-icon-wrapper"><img class="input__file-icon" src="/images/elements/upload.svg" alt="<?php echo app('translator')->get('contests.attach'); ?>" width="8"></span>
								</label>
							</div>
							<div class="col col3">
								<button type="submit" class="btn blue"><?php echo app('translator')->get('contests.send'); ?></button>
							</div>
						</div>
						<div class="job">
							<label><?php echo app('translator')->get('contests.workplace'); ?></label>
							<input type="text" name="workplace" placeholder="<?php echo app('translator')->get('contests.enter_workplace'); ?>" value="<?php echo e($contest->workplace); ?>">
						</div>
					</form>
					<div class="links">
						<div class="row flex between align-center">
							<div class="files">
								<?php $__currentLoopData = $contest->files ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php if(!empty($file)): ?>
										<div class="link file">
											<div class="title"><?php echo e($file); ?></div>
											<a class="delete file">x</a>
											<form class="hidden form-delete-file" action="<?php echo e(route('myContests.deleteFile', [ 'id' => $contest->id ])); ?>" method="post">
												<?php echo csrf_field(); ?>
												<input type="hidden" name="file" value="<?php echo e($file); ?>">
												<button type="submit"></button>
											</form>
										</div>
									<?php endif; ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
							<div class="videos">
								<?php $__currentLoopData = $contest->videos ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php if(!empty($video)): ?>
										<div class="link video">
											<div class="title"><?php echo e($video); ?></div>
											<a class="delete video">x</a>
											<form class="hidden form-delete-video" action="<?php echo e(route('myContests.deleteVideo', [ 'id' => $contest->id ])); ?>" method="post">
												<?php echo csrf_field(); ?>
												<input type="hidden" name="video" value="<?php echo e($video); ?>">
												<button type="submit"></button>
											</form>
										</div>
									<?php endif; ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
	</div>

	<script>
		let inputs = document.querySelectorAll('.input__file');
		Array.prototype.forEach.call(inputs, input => {
			let label = input.nextElementSibling,
				labelVal = label.querySelector('.input__file-button-text').innerText;

			input.addEventListener('change', e => {
				let countFiles = '';
				if (this.files && this.files.length >= 1)
					countFiles = this.files.length;

				if (countFiles)
					label.querySelector('.input__file-button-text').innerText = 'Выбрано файлов: ' + countFiles;
				else
					label.querySelector('.input__file-button-text').innerText = labelVal;
			});
		});
	</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/myContests.blade.php ENDPATH**/ ?>