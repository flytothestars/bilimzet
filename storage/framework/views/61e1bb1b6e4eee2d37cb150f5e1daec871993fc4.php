<?php $__env->startSection('content'); ?>

    <h2 class="mt-4 mb-3">Добавление курса</h2>
    <?php if(\Session::has('message')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo \Session::get('message'); ?>

        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.olympic.courses.update', $course->id)); ?>" id='select_predmet_form' method="post">
        <?php echo method_field('PUT'); ?>
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-md-2">
                <label class="font-weight-bold">Локализация</label>
                <select name="locale" class="form-control">
                    <option value="ru" <?php if($course->locale == 'ru'): ?> selected <?php endif; ?>>Ru</option>
                    <option value="kz" <?php if($course->locale == 'kz'): ?> selected <?php endif; ?>>Kz</option>
                </select>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="title" placeholder="Название курса" class="form-control" value="<?php echo e($course->title); ?>">
            </div>
            <div class="col-md-1">
                <input type="number" name="price" placeholder="Цена курса" class="form-control" value="<?php echo e($course->price); ?>">
            </div>
            <div class="col-md-2">
                <select name="classification" class="form-control">
                    <?php $__currentLoopData = $classifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($classification->id); ?>" <?php if($course->classification_id == $classification->id): ?> selected <?php endif; ?>><?php echo e($classification->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="member" class="form-control">
                    <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($member->id); ?>" <?php if($course->member_id == $member->id): ?> selected <?php endif; ?>><?php echo e($member->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="subject" class="form-control">
                    <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($subject->id); ?>" <?php if($course->subject_id == $subject->id): ?> selected <?php endif; ?>><?php echo e($subject->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <hr>
		 <h2>Вопросы <a href="#" class="btn btn-success" id="add_new_question">Добавить вопрос</a></h2>
        <div class="questions-list">
            <?php $__currentLoopData = $course->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="row" id="question-<?php echo e($question->id); ?>">
                    <div class="col-md-3">
                        <input class="form-control" type="text" name="question[<?php echo e($question->id); ?>][title]" placeholder="Вопрос" value="<?php echo e($question->question); ?>">
                    </div>
                    <?php $__currentLoopData = $question->answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-2">
                            <input class="form-control" type="text" name="question[<?php echo e($question->id); ?>][answers][<?php echo e($answer->id); ?>]" placeholder="Ответ" value="<?php echo e($answer->answer); ?>">
                            <input data-answer-id="<?php echo e($answer->id); ?>"  data-question-id="<?php echo e($question->id); ?>" class="form-check-input answer edit" type="radio" name="is_right[<?php echo e($question->id); ?>]" value="<?php echo e($answer->id); ?>" <?php if($answer->is_right): ?> checked <?php endif; ?> id="exampleRadios<?php echo e($answer->id); ?>"
                                   data-key="<?php echo e($answer->id); ?>"
                                   data-question="<?php echo e($question->id); ?>">
                            <label class="form-check-label" for="exampleRadios<?php echo e($answer->id); ?>">
                                Верный ответ
                            </label>
                    </div>
                        <?php if($answer->is_right): ?>
                            <input id="right_answer_<?php echo e($question->id); ?>" type="hidden" name="question[<?php echo e($question->id); ?>][right_answer][]" value="<?php echo e($answer->id); ?>">
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						 <div>
							 <button class="btn btn-danger question-delete" data-question-id="<?php echo e($question->id); ?>">Удалить</button>
						 </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Обновить курс</button>
            </div>
        </div>
    </form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/admin/olympic/courses/edit.blade.php ENDPATH**/ ?>