<?php $__env->startSection('content'); ?>

	<nav aria-label="breadcrumb" class="mt-4">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo e(route('admin.specialities')); ?>">Специализации</a></li>
			<li class="breadcrumb-item active" aria-current="page"><?php echo e($speciality ? 'Редактировать' : 'Добавить'); ?>

				специализацию
			</li>
		</ol>
	</nav>
	<h2 class="mt-4 mb-3"><?php echo e($speciality ? 'Редактировать' : 'Добавить'); ?> специализацию</h2>
	<div>
		<?php if($speciality): ?>
			<p>
				<a href="<?php echo e($speciality ? route('speciality', ['id' => $speciality ? $speciality->id : 0]) : ''); ?>"
					target="_blank">Открыть на сайте</a></p>
		<?php endif; ?>
		<form id="form" method="post" enctype="multipart/form-data"
				action="<?php echo e($speciality ? route('admin.updateSpeciality', compact('speciality')) : route('admin.storeSpeciality')); ?>">
			<?php echo csrf_field(); ?>
			<?php if($errors->any()): ?>
				<div class="alert alert-danger" role="alert">
					<?php echo e($errors->first()); ?>

				</div>
			<?php endif; ?>
			<div class="form-group">
				<label for="title">Название специализации ru</label>
				<input value="<?php echo e($speciality->title ?? old('title')); ?>"
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
				<label for="title_kz">Название специализации kz</label>
				<input value="<?php echo e($speciality->title_kz ?? old('title_kz')); ?>"
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
				<label for="picture">Картинка</label>
				<div class="custom-file">
					<input class="custom-file-input <?php $__errorArgs = ['picture'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
							 type="file" id="picture" name="picture">
					<label class="custom-file-label" for="picture">Выберите файл</label>
					<?php $__errorArgs = ['picture'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
					<div class="invalid-feedback">
						<?php echo e($errors->first('picture')); ?>

					</div>
					<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
				</div>
				<?php if($speciality && $speciality->picture): ?>
					<div class="mt-1">
						Используется:
						<a target="_blank" href="<?php echo e($speciality->getUploadedUrl('picture')); ?>">картинка</a>
					</div>
				<?php endif; ?>
			</div>
			<div class="form-group mt-2">
				<label for="picture_background">Фон картинки</label>
				<input id="picture_background" name="picture_background"
						 type="color" value="<?php echo e($speciality->picture_background ?? old('picture_background')); ?>">
				<?php $__errorArgs = ['picture_background'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
				<div class="invalid-feedback">
					<?php echo e($errors->first('picture_background')); ?>

				</div>
				<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
			</div>
			<div class="form-group">
				<label for="category">Категория</label>
				<select class="form-control" name="category" id="category">
					<?php $parent = ''; ?>
					<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php if ($parent != $category->parent) { ?>
						<?php if (!$loop->first) { ?>
						</optgroup>
						<?php } ?>
					<optgroup label="<?php echo e($category->parent); ?>">
						<?php $parent = $category->parent; } ?>
						<option value="<?php echo e($category->id); ?>"
							<?php echo e(($speciality && $speciality->category === $category->id) ? 'selected' : ''); ?>>
							<?php echo e($category->name); ?>

						</option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</optgroup>
				</select>
			</div>
			<?php if($speciality): ?>
				<h5 class="mt-4 mb-4">
					<a href="<?php echo e(route('admin.courses', ['speciality' => $speciality])); ?>">Курсы</a>
				</h5>
			<?php endif; ?>
			<button type="submit" name="_save_opt" value="save" class="mt-2 btn btn-success">Сохранить</button>
			<button type="submit" name="_save_opt" value="add_course" class="mt-2 ml-3 btn btn-primary">
				Сохранить и добавить курс
			</button>
		</form>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/admin/speciality.blade.php ENDPATH**/ ?>