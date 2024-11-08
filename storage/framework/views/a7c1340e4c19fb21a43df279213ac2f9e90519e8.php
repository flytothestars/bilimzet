<?php $__env->startSection('content'); ?>

	<?php echo $__env->make('parts.profileMenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<div class="podacha-statyi width1088">
		<div class="width1088 page-title">
			<h1><?php echo app('translator')->get('common.push_article'); ?></h1>
		</div>
		<div class="my-articles width1088">
			<form id="form" method="post" enctype="multipart/form-data" action="<?php echo e(route('doApplyItem')); ?>">
				<?php echo csrf_field(); ?>
				<?php if($errors->any()): ?>
					<div class="alert alert-danger" role="alert">
						<?php echo e($errors->first()); ?>

					</div>
				<?php endif; ?>
				<div class="row">
					<label><?php echo app('translator')->get('common.article_name'); ?> ru</label>
					<input type="text" name="title" class="<?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
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
				<div class="row">
					<label><?php echo app('translator')->get('common.article_name'); ?> kz</label>
					<input type="text" name="title_kz" class="<?php $__errorArgs = ['title_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
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
				<div class="row flex between  align-center desc">
					<div class="left">
						<label><?php echo app('translator')->get('common.article_description'); ?> ru</label>
						<textarea name="text" class="<?php $__errorArgs = ['text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"></textarea>
						<?php $__errorArgs = ['text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
							<div class="invalid-feedback">
								<?php echo e($errors->first('text')); ?>

							</div>
						<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

						<label><?php echo app('translator')->get('common.article_description'); ?> kz</label>
						<textarea name="text_kz" class="<?php $__errorArgs = ['text_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"></textarea>
						<?php $__errorArgs = ['text_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
							<div class="invalid-feedback">
								<?php echo e($errors->first('text_kz')); ?>

							</div>
						<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
					</div>
					<div class="right">
						<select name="category">
							<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
						<div class="input__wrapper">
							<input name="document" type="file" id="input__file" accept="<?php echo e($accept); ?>"
									 class="input input__file <?php $__errorArgs = ['document'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
							<label for="input__file" class="input__file-button">
								<span class="input__file-button-text"><?php echo app('translator')->get('common.attach_file'); ?></span>
								<span class="input__file-icon-wrapper">
									<img class="input__file-icon" src="/images/elements/upload.svg" alt="<?php echo app('translator')->get('common.attach_file'); ?>" width="8">
								</span>
							</label>
							<?php $__errorArgs = ['document'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
								<div class="invalid-feedback">
									<?php echo e($errors->first('document')); ?>

								</div>
							<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
						</div>
					</div>
				</div>
				<?php if(session('message')): ?>
					<div style="margin-top: 10px; color: green; font-size: 18px;">
						<?php echo e(session('message')); ?>

					</div>
				<?php endif; ?>
				<div class="align-right">
					<button type="submit" class="btn blue"><?php echo app('translator')->get('common.send_article'); ?></button>
				</div>
			</form>
			<?php if($items): ?>
				<div class="articles-listing">
					<div class="top flex between align-center">
						<div class="left"><?php echo app('translator')->get('common.article_name'); ?></div>
						<div class="right"><?php echo app('translator')->get('common.article_status'); ?></div>
					</div>
					<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<div class="row flex between align-center <?php echo e($item->is_published ?  'published' : 'unpublished'); ?> ">
							<div class="left"><a href="<?php echo e(route('showLibraryItem', ['id' => $item->id ])); ?>"><?php echo e($item->title); ?></a></div>
							<div class="right"><?php echo e($item->is_published ? __('common.article_publish') : __('common.article_consideration')); ?></div>
						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<script>
		let inputs = document.querySelectorAll('.input__file');
		Array.prototype.forEach.call(inputs, function (input) {
			let label = input.nextElementSibling,
				labelVal = label.querySelector('.input__file-button-text').innerText;

			input.addEventListener('change', function (e) {
				let countFiles = '';
				if (this.files && this.files.length >= 1)
					countFiles = this.files.length;

				label.querySelector('.input__file-button-text').innerText =
					countFiles ? 'Выбрано файлов: ' + countFiles : labelVal;
			});
		});
	</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/applyDoc.blade.php ENDPATH**/ ?>