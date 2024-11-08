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
            <li class="breadcrumb-item">
                <a href="<?php echo e(route('admin.courseTests', compact('speciality', 'course'))); ?>">Тесты</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?php echo e(route('admin.editCourseTest', compact('speciality', 'course', 'test'))); ?>">
                    <?php echo e($test->title); ?>

                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <?php echo e($item ? 'Редактировать' : 'Добавить'); ?> вопрос
            </li>
        </ol>
    </nav>
    <h2 class="mt-4 mb-3"><?php echo e($item ? 'Редактировать' : 'Добавить'); ?> вопрос</h2>
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
                <label for="title">Заголовок вопроса ru</label>
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
				  <label for="title_kz">Заголовок вопроса kz</label>
				  <input value="<?php echo e($item->title_kz ?? old('title_kz') ?? ''); ?>"
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
                <label for="correct_answer">Правильный ответ ru</label>
                <input value="<?php echo e($item->correct_answer ?? old('correct_answer')); ?>"
                       class="form-control <?php $__errorArgs = ['correct_answer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       type="text"
                       name="correct_answer" id="correct_answer" placeholder="">
                <?php $__errorArgs = ['correct_answer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback">
                    <?php echo e($errors->first('correct_answer')); ?>

                </div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
			  <div class="form-group">
				  <label for="correct_answer_kz">Правильный ответ kz</label>
				  <input value="<?php echo e($item->correct_answer_kz ?? old('correct_answer_kz')); ?>"
							class="form-control <?php $__errorArgs = ['correct_answer_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
							type="text"
							name="correct_answer_kz" id="correct_answer_kz" placeholder="">
				  <?php $__errorArgs = ['correct_answer_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
				  <div class="invalid-feedback">
					  <?php echo e($errors->first('correct_answer_kz')); ?>

				  </div>
				  <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
			  </div>
            <?php for($i = 0; $i < 3; $i++): ?>
                <div class="form-group">
                    <label for="incorrect_answers_<?php echo e($i); ?>">Неправильный ответ №<?php echo e($i + 1); ?> ru</label>
                    <input value="<?php echo e($item->incorrect_answers[$i] ?? old("incorrect_answers.$i")); ?>"
                           class="form-control <?php $__errorArgs = ["incorrect_answers.$i"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           type="text"
                           name="incorrect_answers[]" id="incorrect_answers_<?php echo e($i); ?>" placeholder="">
                    <?php $__errorArgs = ["incorrect_answers.$i"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first("incorrect_answers.$i")); ?>

                    </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
				  <div class="form-group">
					  <label for="incorrect_answers_kz_<?php echo e($i); ?>">Неправильный ответ №<?php echo e($i + 1); ?> kz</label>
					  <input value="<?php echo e($item->incorrect_answers_kz[$i] ?? old("incorrect_answers_kz.$i")); ?>"
								class="form-control <?php $__errorArgs = ["incorrect_answers_kz.$i"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
								type="text"
								name="incorrect_answers_kz[]" id="incorrect_answers_kz_<?php echo e($i); ?>" placeholder="">
					  <?php $__errorArgs = ["incorrect_answers_kz.$i"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
					  <div class="invalid-feedback">
						  <?php echo e($errors->first("incorrect_answers_kz.$i")); ?>

					  </div>
					  <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
				  </div>
            <?php endfor; ?>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/admin/courseTestQuestion.blade.php ENDPATH**/ ?>