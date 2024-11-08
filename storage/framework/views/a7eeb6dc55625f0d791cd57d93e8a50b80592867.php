<?php $__env->startSection('content'); ?>

    <h2 class="mt-4 mb-3">Добавление курса</h2>
    <?php if(\Session::has('message')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo \Session::get('message'); ?>

        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.olympic.courses.store')); ?>" id='select_predmet_form' method="post">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-md-2">
                <label class="font-weight-bold">Локализация</label>
                <select name="locale" class="form-control">
                    <option value="ru">Ru</option>
                    <option value="kz">Kz</option>
                </select>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="title" placeholder="Название курса" class="form-control">
            </div>
            <div class="col-md-1">
                <input type="number" name="price" placeholder="Цена курса" class="form-control">
            </div>
            <div class="col-md-2">
                <select name="classification" class="form-control">
                    <?php $__currentLoopData = $classifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($classification->id); ?>"><?php echo e($classification->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="member" class="form-control">
                    <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($member->id); ?>"><?php echo e($member->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="subject" class="form-control">
                    <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($subject->id); ?>"><?php echo e($subject->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <hr>
        <h2>Вопросы <a href="#" class="btn btn-success" id="add_new_question">Добавить вопрос</a></h2>
        <div class="questions-list">
            <div class="row" id="question-1">
                <div class="col-md-3">
                    <input class="form-control" type="text" name="question[1][title]" placeholder="Вопрос">
                </div>
                <?php for($i = 1; $i <= 4; $i++): ?>
                    <div class="col-md-2">
                        <input class="form-control" type="text" name="question[1][answers][<?php echo e($i); ?>]" placeholder="Ответ">
                        <input class="form-check-input answer" type="radio" name="is_right" id="exampleRadios<?php echo e($i); ?>" data-key="<?php echo e($i); ?>" data-question="1">
                        <label class="form-check-label" for="exampleRadios<?php echo e($i); ?>">
                            Верный ответ
                        </label>
                    </div>
                <?php endfor; ?>
                <div class="right-answer"></div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Создать курс</button>
            </div>
        </div>
    </form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/admin/olympic/courses/create.blade.php ENDPATH**/ ?>