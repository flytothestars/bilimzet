<?php $__env->startSection('content'); ?>

	<nav aria-label="breadcrumb" class="mt-4">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo e(route('admin.contestFiles')); ?>">Файлы конкуров</a></li>
			<li class="breadcrumb-item active" aria-current="page">Выбрать награду</li>
		</ol>
	</nav>

	<h2 class="mt-4 mb-3">Выбрать награду</h2>

	<div>
		<form id="form" method="post" action="<?php echo e(route(('admin.storeAward'), [ 'contestFile' => $contestFile->id ])); ?>">
			<?php echo csrf_field(); ?>
			<?php if($errors->any()): ?>
				<div class="alert alert-danger" role="alert">
					<?php echo e($errors->first()); ?>

				</div>
			<?php endif; ?>

			<div>
				<b>Пользователь</b> <?php echo e($contestFile->user->full_name); ?>

			</div>

			<div>
				<b>Конкурс</b> <a href="<?php echo e(route('admin.editContest', [ 'contest' => $contestFile->contest->id ])); ?>"
										role="button"><?php echo e($contestFile->contest->title); ?></a>
			</div>

			<div><b>Файлы</b></div>

			<div class="link file">
				<?php $__currentLoopData = explode(';', $contestFile->file); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<a href="<?php echo e('/uploads/contest_files/' . $file); ?>" target="_blank"><?php echo e($file); ?></a>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>
			<div class="link video">
				<?php $__currentLoopData = explode(';', $contestFile->video); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<a href="<?php echo e($video); ?>" target="_blank"><?php echo e($video); ?></a>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>

			<div><b>Награды</b></div>

			<?php if(count($certificates)): ?>
				<div class="konkurs-benefits">
					<div class="width1088">
						<div class="items flex between align-top wrap">
							<?php $__currentLoopData = $certificates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $certificate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<div class="item cursor-pointer">
									<a class="select-award" data-id="<?php echo e($certificate->id); ?>">
										<img src="<?php echo e($certificate->getUploadedUrl('file')); ?>" alt="">
										<div class="title"><?php echo e($certificate->name); ?></div>
										<div class="description"><?php echo e($certificate->text); ?></div>
									</a>
								</div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<input type="hidden" name="certificate_id" id="certificate_id">

			<button type="submit" name="_save_opt" value="create" class="btn btn-primary">Сохранить</button>
		</form>

	</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/admin/createAward.blade.php ENDPATH**/ ?>