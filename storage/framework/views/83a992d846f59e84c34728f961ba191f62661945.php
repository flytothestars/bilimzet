<?php $__env->startSection('content'); ?>

    <h2 class="mt-4 mb-3">Курсов (<?php echo e($courses ? $courses->total() : 0); ?>)</h2>
    <div class="mb-3" style="text-align: right">
        <a role="button" href="<?php echo e(route('admin.olympic.courses.create')); ?>" class="btn btn-primary btn-sm mr-2">Добавить</a>
    </div>
    <?php if($courses->count()): ?>
        <div class="mt-5 mb-4">
            <?php echo e($courses->links()); ?>

        </div>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Классификация</th>
                    <th>Участник</th>
                    <th>Направление</th>
                    <th>Цена</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($course->title); ?></td>
                        <td><?php echo e($course->classification->name); ?></td>
                        <td><?php echo e($course->member->name); ?></td>
                        <td><?php echo e($course->subject->name); ?></td>
                        <td><?php echo e($course->price); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.olympic.courses.edit', $course->id)); ?>"
                               role="button" class="btn btn-primary btn-sm mr-2">Редактировать</a>
                            <form style="display: inline-block" method="post" action="<?php echo e(route('admin.olympic.courses.destroy', $course->id)); ?>">
                                <?php echo method_field('DELETE'); ?>
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-danger btn-sm mr-2">Удалить</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <?php echo e($courses->links()); ?>

        </div>
    <?php else: ?>
        <p>Нет Курсов</p>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/admin/olympic/courses/index.blade.php ENDPATH**/ ?>