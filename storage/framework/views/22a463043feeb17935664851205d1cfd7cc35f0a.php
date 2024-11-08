<?php $__env->startSection('content'); ?>
    <nav aria-label="breadcrumb" class="mt-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.news')); ?>">Новости</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo e($item ? 'Редактировать' : 'Добавить'); ?>

                новость
            </li>
        </ol>
    </nav>
    <h2 class="mt-4 mb-3"><?php echo e($item ? 'Редактировать' : 'Добавить'); ?> новость</h2>
    <div>
        <?php if($item): ?>
            <p><a href="<?php echo e(route('newPost', ['id' => $item->id])); ?>"
                  target="_blank">Открыть на сайте</a></p>
        <?php endif; ?>
        <form id="form" method="post" enctype="multipart/form-data" action="<?php echo e($formAction); ?>">
            <?php echo csrf_field(); ?>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="name">Название новости ru</label>
                <input value="<?php echo e($item->name ?? old('name')); ?>"
                       class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       type="text"
                       name="name" id="name" placeholder="">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback">
                    <?php echo e($errors->first('name')); ?>

                </div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
			  <div class="form-group">
				  <label for="name_kz">Название новости kz</label>
				  <input value="<?php echo e($item->name_kz ?? old('name_kz')); ?>"
							class="form-control <?php $__errorArgs = ['name_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
							type="text"
							name="name_kz" id="name_kz" placeholder="">
				  <?php $__errorArgs = ['name_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
				  <div class="invalid-feedback">
					  <?php echo e($errors->first('name_kz')); ?>

				  </div>
				  <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
			  </div>
            <div class="form-group mt-2">
                <label for="picture">Миниатюра</label>
                <div class="custom-file">
                    <input class="custom-file-input <?php $__errorArgs = ['picture'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           type="file" id="picture" name="miniature">
                    <label class="custom-file-label" for="picture">Выберите файл</label>
                    <?php $__errorArgs = ['miniature'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('miniature')); ?>

                    </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <?php if($item && $item->miniature): ?>
                    <div class="mt-1">
                        Используется:
                        <a target="_blank" href="<?php echo e($item->getUploadedUrl('miniature')); ?>">картинка</a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="text">Контент новости ru</label>
                <textarea class="summernote" name="text" id="text" style="width:700px;height:550px"><?php echo e($item->text ?? old('text')); ?></textarea>
            </div>
			  <div class="form-group">
				  <label for="text_kz">Контент новости kz</label>
				  <textarea class="summernote" name="text_kz" id="text_kz" style="width:700px;height:550px"><?php echo e($item->text_kz ?? old('text_kz')); ?></textarea>
			  </div>
            <?php if($item): ?>
                <button type="submit" name="_save_opt" value="save" class="mt-2 btn btn-success">Сохранить</button>
            <?php else: ?>
                <button type="submit" name="_save_opt" value="add_course" class="mt-2 ml-3 btn btn-primary">
                    Сохранить и добавить новость
                </button>
            <?php endif; ?>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/admin/new.blade.php ENDPATH**/ ?>