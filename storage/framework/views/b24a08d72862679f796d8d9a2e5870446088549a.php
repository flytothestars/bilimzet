<?php $__env->startSection('content'); ?>
    <nav aria-label="breadcrumb" class="mt-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.specialities')); ?>">Специализации</a></li>
            <li class="breadcrumb-item">
                <a href="<?php echo e(route('admin.editSpeciality', ['speciality' => $speciality])); ?>">
                    <?php echo e($speciality->title); ?>

                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?php echo e(route('admin.courses', ['speciality' => $speciality])); ?>">Курсы</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo e($item ? 'Редактировать' : 'Добавить'); ?> курс</li>
        </ol>
    </nav>
    <h2 class="mt-4 mb-3"><?php echo e($item ? 'Редактировать' : 'Добавить'); ?> курс</h2>
    <div>
        <?php if($item): ?>
            <p><a href="<?php echo e(route('course', ['id' => $item->id])); ?>" target="_blank">Открыть на сайте</a></p>
        <?php endif; ?>
        <form id="form" method="post" enctype="multipart/form-data" action="<?php echo e($formAction); ?>">
            <?php echo csrf_field(); ?>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?>
            <fieldset class="mt-4">
                <legend>Курс</legend>
                <div class="form-group">
                    <label for="title">Название курса ru</label>
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
						<label for="title_kz">Название курса kz</label>
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
            <fieldset class="mt-4">
                <legend>Автор</legend>
                <div class="form-group">
                    <label for="author_fio">ФИО автора ru</label>
                    <input value="<?php echo e($item->author_fio ?? old('author_fio')); ?>"
                           class="form-control <?php $__errorArgs = ['author_fio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           type="text"
                           name="author_fio" id="author_fio" placeholder="">
                    <?php $__errorArgs = ['author_fio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
							  <div class="invalid-feedback">
									<?php echo e($errors->first('author_fio')); ?>

							  </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
					<div class="form-group">
						<label for="author_fio_kz">ФИО автора kz</label>
						<input value="<?php echo e($item->author_fio_kz ?? old('author_fio_kz')); ?>"
								 class="form-control <?php $__errorArgs = ['author_fio_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
								 type="text"
								 name="author_fio_kz" id="author_fio_kz" placeholder="">
						<?php $__errorArgs = ['author_fio_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
						<div class="invalid-feedback">
							<?php echo e($errors->first('author_fio_kz')); ?>

						</div>
						<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
					</div>
                <div class="form-group">
                    <label for="author_position">Должность автора ru</label>
                    <input value="<?php echo e($item->author_position ?? old('author_position')); ?>"
                           class="form-control <?php $__errorArgs = ['author_position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           type="text"
                           name="author_position" id="author_position" placeholder="">
                    <?php $__errorArgs = ['author_position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('author_position')); ?>

                    </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
					<div class="form-group">
						<label for="author_position_kz">Должность автора kz</label>
						<input value="<?php echo e($item->author_position_kz ?? old('author_position_kz')); ?>"
								 class="form-control <?php $__errorArgs = ['author_position_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
								 type="text"
								 name="author_position_kz" id="author_position_kz" placeholder="">
						<?php $__errorArgs = ['author_position_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
						<div class="invalid-feedback">
							<?php echo e($errors->first('author_position_kz')); ?>

						</div>
						<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
					</div>
                <div class="form-group mt-2">
                    <label for="author_photo">Фото автора</label>
                    <div class="custom-file">
                        <input class="custom-file-input <?php $__errorArgs = ['author_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               type="file" id="author_photo" name="author_photo">
                        <label class="custom-file-label" for="author_photo">Выберите файл</label>
                        <?php $__errorArgs = ['author_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('author_photo')); ?>

                        </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <?php if($item && $item->author_photo): ?>
                        <div class="mt-1">
                            Используется:
                            <a target="_blank" href="<?php echo e($item->getUploadedUrl('author_photo')); ?>">фото</a>
                        </div>
                    <?php endif; ?>
                </div>
            </fieldset>
            <?php if($item): ?>
                <fieldset class="mt-4">
                    <legend>Содержимое курса</legend>
                    <h6 class="ml-4">
                        <a href="<?php echo e($partsRoute); ?>">Редактировать части
                            курса</a>
                    </h6>
                    <!---<h6 class="ml-4">
                        <a href="<?php echo e($testsRoute); ?>">Редактировать тесты
                            курса</a>
                    </h6>
					--->
                </fieldset>
            <?php endif; ?>
            <fieldset class="mt-4">
                <legend>Подробности</legend>
                <div class="form-group">
                    <label for="desc_text">Описание курса ru</label>
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
					<div class="form-group">
						<label for="desc_text_kz">Описание курса kz</label>
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
                <div class="form-group">
                    <label for="listeners_category_text">Категория слушателей ru</label>
                    <textarea class="form-control <?php $__errorArgs = ['listeners_category_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                              name="listeners_category_text" id="listeners_category_text"
                              rows="6"><?php echo e($item->listeners_category_text ?? old('listeners_category_text')); ?></textarea>
                    <?php $__errorArgs = ['listeners_category_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('listeners_category_text')); ?>

                    </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
					<div class="form-group">
						<label for="listeners_category_text_kz">Категория слушателей kz</label>
						<textarea class="form-control <?php $__errorArgs = ['listeners_category_text_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
									 name="listeners_category_text_kz" id="listeners_category_text_kz"
									 rows="6"><?php echo e($item->listeners_category_text_kz ?? old('listeners_category_text_kz')); ?></textarea>
						<?php $__errorArgs = ['listeners_category_text_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
						<div class="invalid-feedback">
							<?php echo e($errors->first('listeners_category_text_kz')); ?>

						</div>
						<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
					</div>
                <div class="form-group">
                    <label for="goals_text">Цели курса ru</label>
                    <textarea class="form-control <?php $__errorArgs = ['goals_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                              name="goals_text" id="goals_text"
                              rows="6"><?php echo e($item->goals_text ?? old('goals_text')); ?></textarea>
                    <?php $__errorArgs = ['goals_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('goals_text')); ?>

                    </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
					<div class="form-group">
						<label for="goals_text_kz">Цели курса kz</label>
						<textarea class="form-control <?php $__errorArgs = ['goals_text_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
									 name="goals_text_kz" id="goals_text_kz"
									 rows="6"><?php echo e($item->goals_text_kz ?? old('goals_text_kz')); ?></textarea>
						<?php $__errorArgs = ['goals_text_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
						<div class="invalid-feedback">
							<?php echo e($errors->first('goals_text_kz')); ?>

						</div>
						<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
					</div>
                <div class="form-group">
                    <label for="tasks_text">Задачи курса ru</label>
                    <textarea class="form-control <?php $__errorArgs = ['tasks_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                              name="tasks_text" id="tasks_text"
                              rows="6"><?php echo e($item->tasks_text ?? old('tasks_text')); ?></textarea>
                    <?php $__errorArgs = ['tasks_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('tasks_text')); ?>

                    </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
					<div class="form-group">
						<label for="tasks_text_kz">Задачи курса kz</label>
						<textarea class="form-control <?php $__errorArgs = ['tasks_text_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
									 name="tasks_text_kz" id="tasks_text_kz"
									 rows="6"><?php echo e($item->tasks_text_kz ?? old('tasks_text_kz')); ?></textarea>
						<?php $__errorArgs = ['tasks_text_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
						<div class="invalid-feedback">
							<?php echo e($errors->first('tasks_text_kz')); ?>

						</div>
						<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
					</div>
                <div class="form-group">
                    <label for="organization_text">Организация образовательного процесса, формы и методы, оценка
                        результатов ru</label>
                    <textarea class="form-control <?php $__errorArgs = ['organization_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                              name="organization_text" id="organization_text"
                              rows="6"><?php echo e($item->organization_text ?? old('organization_text')); ?></textarea>
                    <?php $__errorArgs = ['organization_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('organization_text')); ?>

                    </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
					<div class="form-group">
						<label for="organization_text_kz">Организация образовательного процесса, формы и методы, оценка
							результатов kz</label>
						<textarea class="form-control <?php $__errorArgs = ['organization_text_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
									 name="organization_text_kz" id="organization_text_kz"
									 rows="6"><?php echo e($item->organization_text_kz ?? old('organization_text_kz')); ?></textarea>
						<?php $__errorArgs = ['organization_text_kz'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
						<div class="invalid-feedback">
							<?php echo e($errors->first('organization_text_kz')); ?>

						</div>
						<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
					</div>
            </fieldset>
            <button type="submit" name="_save_opt" value="" class="mt-2 btn btn-success">Сохранить</button>
            <button type="submit" name="_save_opt" value="add_test" class="mt-2 ml-3 btn btn-primary">
                Сохранить и добавить тест
            </button>
            <button type="submit" name="_save_opt" value="add_part" class="mt-2 ml-3 btn btn-primary">
                Сохранить и добавить часть курса
            </button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/admin/course.blade.php ENDPATH**/ ?>