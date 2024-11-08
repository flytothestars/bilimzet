<?php $__env->startSection('content'); ?>

    <h2 class="mt-4 mb-3">Редактировать статью</h2>
    <div>
        <form id="form" method="post" enctype="multipart/form-data"
              action="<?php echo e(route('admin.updateLibraryItem', ['id' => $item->id])); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="title">Заголовок статьи ru</label>
                <input value="<?php echo e($item->title); ?>"
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
				  <label for="title_kz">Заголовок статьи kz</label>
				  <input value="<?php echo e($item->title_kz); ?>"
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
                <label for="document">Документ</label>
                <div class="custom-file">
                    <input class="custom-file-input <?php $__errorArgs = ['document'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           type="file" id="document" name="document">
                    <label class="custom-file-label" for="document">Выберите файл</label>
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
                <?php if($item && $item->document): ?>
                    <div class="mt-1">
                        Используется:
                        <a target="_blank" href="<?php echo e($item->documentUrl); ?>">документ</a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="category">Категория</label>
                <select class="form-control" name="category" id="category">
                    <?php if($item->isCustomCategory()): ?>
                        <option selected value="<?php echo e($item->category); ?>">
                            Другой (<?php echo e($item->category); ?>)
                        </option>
                    <?php endif; ?>
                    <?php $__currentLoopData = $categoryNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option <?php echo e($item->category === $value ? 'selected' : ''); ?>>
                            <?php echo e($value); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group form-check mt-2">
                <input type="checkbox" name="is_published"
                       <?php echo e($item->is_published ? 'checked' : ''); ?>

                       class="form-check-input" id="is_published" value="true">
                <label class="form-check-label" for="is_published">Опубликовать?</label>
            </div>
            <div class="form-group">
                <label for="text">Текст ru</label>
                <textarea class="form-control <?php $__errorArgs = ['text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                          name="text" id="text" rows="6"><?php echo e($item->text ?? old('text')); ?></textarea>
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
            </div>
			  <div class="form-group">
				  <label for="text_kz">Текст kz</label>
				  <textarea class="form-control <?php $__errorArgs = ['text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
								name="text_kz" id="text_kz" rows="6"><?php echo e($item->text_kz ?? old('text_kz')); ?></textarea>
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
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/admin/libraryItem.blade.php ENDPATH**/ ?>