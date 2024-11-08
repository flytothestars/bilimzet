<h2 class="mt-5 mb-3">Вопросы (<?php echo e($items ? $items->count() : 0); ?>)</h2>
<div class="mb-3" style="text-align: right">
    <a role="button"
       href="<?php echo e(route('admin.createCourseTestQuestion', compact('speciality', 'course', 'test'))); ?>"
       class="btn btn-primary btn-sm mr-2">Добавить</a>
</div>
<?php if($items->count()): ?>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>Название</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($question->title); ?></td>
                    <td>
                        <a href="<?php echo e(route('admin.editCourseTestQuestion',
                                        compact('speciality', 'course', 'test', 'question'))); ?>"
                           role="button" class="btn btn-primary btn-sm mr-2">Редактировать</a>
                        <form style="display: inline-block" method="post"
                              action="<?php echo e(route('admin.destroyCourseTestQuestion',
                                        compact('speciality', 'course', 'test', 'question'))); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-danger btn-sm mr-2">Удалить</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p>Нет Вопросов</p>
<?php endif; ?>
<?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/admin/parts/courseTestQuestions.blade.php ENDPATH**/ ?>