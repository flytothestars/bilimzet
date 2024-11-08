<?php $__env->startSection('content'); ?>
	<nav aria-label="breadcrumb" class="mt-4">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo e(route('admin.contests')); ?>">Конкурсы</a></li>
			<li class="breadcrumb-item">
				<a href="<?php echo e(route('admin.editContest', compact('contest'))); ?>">
					<?php echo e($contest->title); ?>

				</a>
			</li>
			<li class="breadcrumb-item active" aria-current="page">
				<?php echo e($item ? 'Редактировать' : 'Добавить'); ?> часть конкурса
			</li>
		</ol>
	</nav>
	<h2 class="mt-4 mb-3"><?php echo e($item ? 'Редактировать' : 'Добавить'); ?> часть конкурса</h2>
	<div>
		<form id="form" method="post" enctype="multipart/form-data" action="<?php echo e($formAction); ?>">
			<input type="hidden" name="contest_id" value="<?php echo e($contest->id); ?>">
			<input type="hidden" name="item_id" value="<?php echo e($item->id ?? ''); ?>">
			<?php echo csrf_field(); ?>
			<?php if($errors->any()): ?>
				<div class="alert alert-danger" role="alert">
					<?php echo e($errors->first()); ?>

				</div>
			<?php endif; ?>
			<div class="form-group">
				<label for="duration_hours">Длительность части конкурса</label>
				<input value="<?php echo e($item->duration_hours ?? old('duration_hours')); ?>"
						 class="form-control <?php $__errorArgs = ['duration_hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
						 type="text"
						 name="duration_hours" id="duration_hours" placeholder="">
				<?php $__errorArgs = ['duration_hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
				<div class="invalid-feedback">
					<?php echo e($errors->first('duration_hours')); ?>

				</div>
				<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
			</div>
			<div class="form-group">
				<label for="price_kzt">Стоимость части конкурса (тенге)</label>
				<input value="<?php echo e($item->price_kzt ?? old('price_kzt')); ?>"
						 class="form-control <?php $__errorArgs = ['price_kzt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
						 type="text"
						 name="price_kzt" id="price_kzt" placeholder="">
				<?php $__errorArgs = ['price_kzt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
				<div class="invalid-feedback">
					<?php echo e($errors->first('price_kzt')); ?>

				</div>
				<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
			</div>

			<br>
			<?php if($item): ?>
			<h6 class="ml-4">
				<a href="/admin/contests/<?php echo e($contest->id); ?>/tests">Редактировать тесты конкурса</a>
			</h6>
			<?php endif; ?>

			<div class="form-group mt-2">
				<label for="plan">План конкурса</label>
				<div class="custom-file">
					<input class="custom-file-input <?php $__errorArgs = ['plan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
							 type="file" id="plan" name="plan">
					<label class="custom-file-label" for="plan">Выберите файл</label>
					<?php $__errorArgs = ['plan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
					<div class="invalid-feedback">
						<?php echo e($errors->first('plan')); ?>

					</div>
					<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
				</div>
				<?php if($item && $item->plan): ?>
					<div class="mt-1">
						Используется:
						<a target="_blank" href="<?php echo e($item->getUploadedUrl('plan')); ?>">план</a>
					</div>
				<?php endif; ?>
			</div>

			<script>
				let total_files = 1;

				function add_new_file() {
					if (total_files < 80) {
						document.getElementById('file_group_' + total_files).style.display = "block";
						total_files++;
					} else {
						alert('Число файлов не может быть больше 80ти!');
					}
				}
			</script>

			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			


			<?php $__currentLoopData = $additional_files_orig; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $additional_file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="form-group mt-2" id="file_group_<?php echo e($loop->iteration); ?>">
					<label for="file">Файл курса <?php echo e($loop->iteration); ?> (доступен после покупки)</label>
					<div class="custom-file">
						<input class="custom-file-input" type="file" id="file<?php echo e($loop->iteration + 1); ?>" name="file <?php echo e($loop->iteration + 1); ?>">
						<label class="custom-file-label" for="file">Выберите файл</label>
					</div>
					<script>
						total_files++;
					</script>
					<div class="mt-1">
						Используется:
						<a target="_blank" href="<?php echo e($additional_file); ?>">файл</a>
					</div>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

			<input type="button" value="Добавить еще один файл" onClick="add_new_file()">
			<br><br>
			<button type="submit" class="btn btn-primary">Сохранить</button>
		</form>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/admin/contestPart.blade.php ENDPATH**/ ?>