<?php $__env->startSection('content'); ?>
    <nav aria-label="breadcrumb" class="mt-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.specialities')); ?>">Специализации</a></li>
            <li class="breadcrumb-item">
                <a href="<?php echo e(route('admin.editSpeciality', compact('speciality'))); ?>">
                    <?php echo e($speciality->title); ?>

                </a>
            </li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.courses', compact('speciality'))); ?>">Курсы</a></li>
            <li class="breadcrumb-item">
                <a href="<?php echo e(route('admin.editCourse', compact('speciality', 'course'))); ?>">
                    <?php echo e($course->title); ?>

                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <?php echo e($item ? 'Редактировать' : 'Добавить'); ?> тест курса
            </li>
        </ol>
    </nav>
    <h2 class="mt-4 mb-3"><?php echo e($item ? 'Редактировать' : 'Добавить'); ?> тест курса</h2>
    <div>
        <form id="form" method="post" enctype="multipart/form-data"
              action="<?php echo e($formAction); ?>">
            <?php echo csrf_field(); ?>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="title">Название теста ru</label>
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
				  <label for="title_kz">Название теста kz</label>
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
            <div class="form-group">
                <label for="duration_minutes">Длительность (минут)</label>
                <input value="<?php echo e($item->duration_minutes ?? old('duration_minutes')); ?>"
                       class="form-control <?php $__errorArgs = ['duration_minutes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       type="text"
                       name="duration_minutes" id="duration_minutes" placeholder="">
                <?php $__errorArgs = ['duration_minutes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback">
                    <?php echo e($errors->first('duration_minutes')); ?>

                </div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <button type="submit" name="_save_opt" value="" class="btn btn-success">Сохранить</button>
            <button type="submit" name="_save_opt" value="add_question" class="ml-3 btn btn-primary">
                Сохранить и добавить вопрос
            </button>
        </form>
        <?php if($item): ?>
            <?php echo $__env->make('admin.parts.courseTestQuestions', ['items' => $questions, 'test' => $item], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/admin/courseTest.blade.php ENDPATH**/ ?>