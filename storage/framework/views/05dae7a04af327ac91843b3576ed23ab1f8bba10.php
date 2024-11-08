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
                Части
            </li>
        </ol>
    </nav>
    <h2 class="mt-4 mb-3">Части курса (<?php echo e($items ? $items->count() : 0); ?>)</h2>
    <div class="mb-3" style="text-align: right">
        <a role="button" href="<?php echo e(route('admin.createCoursePart', compact('speciality', 'course'))); ?>"
           class="btn btn-primary btn-sm mr-2">Добавить</a>
    </div>
    <?php if($items->count()): ?>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>Длительность (академических часов)</th>
                    <th>Стоимость (тенге)</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($part->duration_hours); ?></td>
                        <td><?php echo e($part->price_kzt); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.editCoursePart', compact('speciality', 'course', 'part'))); ?>"
                               role="button" class="btn btn-primary btn-sm mr-2">Редактировать</a>
                            <form style="display: inline-block" method="post"
                                  action="<?php echo e(route('admin.destroyCoursePart', compact('speciality', 'course', 'part'))); ?>">
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
        <p>Нет частей курса</p>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/admin/courseParts.blade.php ENDPATH**/ ?>