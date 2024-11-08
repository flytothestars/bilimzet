<?php $__env->startSection('content'); ?>

	<nav aria-label="breadcrumb" class="mt-4">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo e(route('admin.contests')); ?>">Конкурсы</a></li>
			<li class="breadcrumb-item active" aria-current="page"><?php echo e($item ? 'Редактировать' : 'Добавить'); ?> конкурс</li>
		</ol>
	</nav>

	<h2 class="mt-4 mb-3"><?php echo e($item ? 'Редактировать' : 'Добавить'); ?> конкурс</h2>

	<div>
		<?php if($item): ?>
			<p><a href="<?php echo e(route('contest', ['id' => $item->id])); ?>" target="_blank">Открыть на сайте</a></p>
		<?php endif; ?>
		<form id="form" method="post" enctype="multipart/form-data" action="<?php echo e($formAction); ?>">
			<?php echo csrf_field(); ?>
			<?php if($errors->any()): ?>
				<div class="alert alert-danger" role="alert">
					<?php echo e($errors->first()); ?>

				</div>
			<?php endif; ?>
			<fieldset class="mt-4">
				<div class="form-group">
					<label for="title">Название конкурса ru</label>
					<input value="<?php echo e($item->title ?? old('title')); ?>"
							 class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
							 type="text" name="title" id="title" placeholder="">
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
					<label for="title_kz">Название конкурса kz</label>
					<input value="<?php echo e($item->title_kz ?? old('title_kz')); ?>"
							 class="form-control <?php $__errorArgs = ['title_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
							 type="text" name="title_kz" id="title_kz" placeholder="">
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
			</fieldset>
			<div class="form-group">
				<label for="category">Категория</label>
				<select class="form-control" name="category_id" id="category">
					<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<option value="<?php echo e($category->id); ?>" <?php echo e($item ? $item->category_id == $category->id ? 'selected' : '' : ''); ?> >
							<?php echo e($category->name); ?>

						</option>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</select>
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
				<?php if($item && $item->picture): ?>
					<div class="mt-1">
						Используется:
						<a target="_blank" href="<?php echo e($item->getUploadedUrl('picture')); ?>">картинка</a>
					</div>
				<?php endif; ?>
			</div>
			<?php if($item): ?>
				<fieldset class="mt-4">
					<legend>Награды конкурсов</legend>
					<h6 class="ml-4">
						<a href="<?php echo e(route('admin.contestsCertificates', compact('contest'))); ?>">Редактировать</a>
					</h6>
				</fieldset>

				<fieldset class="mt-4">
					<legend>Содержимое конкурса</legend>
					<h6 class="ml-4">
						<a href="<?php echo e($partsRoute); ?>">Редактировать части	конкурса</a>
					</h6>
				</fieldset>
			<?php endif; ?>
			<div class="form-group mt-2">
				<label for="desc_text">Описание конкурса ru</label>
				<textarea class="form-control <?php $__errorArgs = ['desc_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
							 name="desc_text" id="desc_text"
							 rows="6"><?php echo e($item->desc_text ?? old('desc_text')); ?></textarea>
				<?php $__errorArgs = ['desc_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
				<div class="invalid-feedback">
					<?php echo e($errors->first('desc_text')); ?>

				</div>
				<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
			</div>
			<div class="form-group mt-2">
				<label for="desc_text_kz">Описание конкурса kz</label>
				<textarea class="form-control <?php $__errorArgs = ['desc_text_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
							 name="desc_text_kz" id="desc_text_kz"
							 rows="6"><?php echo e($item->desc_text_kz ?? old('desc_text_kz')); ?></textarea>
				<?php $__errorArgs = ['desc_text_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
				<div class="invalid-feedback">
					<?php echo e($errors->first('desc_text_kz')); ?>

				</div>
				<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
			</div>
			<div class="form-group mt-2">
				<label for="text_on_picture">Надпись карточки ru</label>
				<textarea class="form-control <?php $__errorArgs = ['text_on_picture'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
							 name="text_on_picture" id="text_on_picture"
							 rows="6"><?php echo e($item->text_on_picture ?? old('text_on_picture')); ?></textarea>
				<?php $__errorArgs = ['desc_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
				<div class="invalid-feedback">
					<?php echo e($errors->first('text_on_picture')); ?>

				</div>
				<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
			</div>
			<div class="form-group mt-2">
				<label for="text_on_picture_kz">Надпись карточки kz</label>
				<textarea class="form-control <?php $__errorArgs = ['text_on_picture_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
							 name="text_on_picture_kz" id="text_on_picture_kz"
							 rows="6"><?php echo e($item->text_on_picture_kz ?? old('text_on_picture_kz')); ?></textarea>
				<?php $__errorArgs = ['text_on_picture_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
				<div class="invalid-feedback">
					<?php echo e($errors->first('text_on_picture_kz')); ?>

				</div>
				<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
			</div>
			<?php if($item): ?>
				<button type="submit" name="_save_opt" value="save_part" class="mt-2 ml-3 btn btn-primary">
					Сохранить
				</button>
			<?php else: ?>
				<button type="submit" name="_save_opt" value="add_part" class="mt-2 ml-3 btn btn-primary">
					Добавить
				</button>
			<?php endif; ?>
		</form>
	</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/admin/contest.blade.php ENDPATH**/ ?>