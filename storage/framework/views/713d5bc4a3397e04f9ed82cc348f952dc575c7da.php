<?php $__env->startSection('content'); ?>
	<nav aria-label="breadcrumb" class="mt-4">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo e(route('admin.guides')); ?>">Гайды</a></li>
			<li class="breadcrumb-item active" aria-current="page"><?php echo e($item ? 'Редактировать' : 'Добавить'); ?>

				гайд
			</li>
		</ol>
	</nav>
	<h2 class="mt-4 mb-3"><?php echo e($item ? 'Редактировать' : 'Добавить'); ?> гайд</h2>
	<div>
		<?php if($item): ?>
			<p><a href="<?php echo e(route('index')); ?>" target="_blank">Открыть на сайте</a></p>
		<?php endif; ?>
		<form id="form" method="post" enctype="multipart/form-data" action="<?php echo e($item ? route('admin.guide.update', [ 'id' => $id ]) : route('admin.guide.store')); ?>">
			<?php echo csrf_field(); ?>
			<?php if($errors->any()): ?>
				<div class="alert alert-danger" role="alert">
					<?php echo e($errors->first()); ?>

				</div>
			<?php endif; ?>
			<div class="form-group">
				<label for="title">Название гайда ru</label>
				<input value="<?php echo e($item->title ?? old('title')); ?>"
						 class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
						 type="text"
						 name="title" id="title" placeholder="">
				<?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
				<div class="invalid-feedback">
					<?php echo e($errors->first('title')); ?>

				</div>
				<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
			</div>
			<div class="form-group">
				<label for="name_kz">Название гайда kz</label>
				<input value="<?php echo e($item->title_kz ?? old('title_kz')); ?>"
						 class="form-control <?php $__errorArgs = ['title_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
						 type="text"
						 name="title_kz" id="title_kz" placeholder="">
				<?php $__errorArgs = ['title_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
				<div class="invalid-feedback">
					<?php echo e($errors->first('title_kz')); ?>

				</div>
				<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
			</div>
			<div class="form-group mt-2">
				<label for="video">Видео</label>
				<input class="form-control <?php $__errorArgs = ['video'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
							 type="text" id="video" name="video" value="<?php echo e($item->video ?? old('video')); ?>">
					<?php $__errorArgs = ['video'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
						<div class="invalid-feedback">
							<?php echo e($errors->first('video')); ?>

						</div>
					<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
				</div>
			</div>
			<div class="form-group">
				<label for="text">Контент гайда ru</label>
				<textarea class="summernote" name="text" id="text" style="width:700px;height:550px"><?php echo e($item->text ?? old('text')); ?></textarea>
			</div>
			<div class="form-group">
				<label for="text_kz">Контент гайда kz</label>
				<textarea class="summernote" name="text_kz" id="text_kz" style="width:700px;height:550px"><?php echo e($item->text_kz ?? old('text_kz')); ?></textarea>
			</div>
			<?php if($item): ?>
				<button type="submit" name="_save_opt" value="save" class="mt-2 btn btn-success">Сохранить</button>
			<?php else: ?>
				<button type="submit" name="_save_opt" value="add_course" class="mt-2 ml-3 btn btn-primary">
					Сохранить и добавить гайд
				</button>
			<?php endif; ?>
		</form>
	</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/admin/guide.blade.php ENDPATH**/ ?>