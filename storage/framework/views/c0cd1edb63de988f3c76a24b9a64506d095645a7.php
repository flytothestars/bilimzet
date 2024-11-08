<?php $__env->startSection('content'); ?>
    <h2 class="mt-4 mb-3">Результаты тестов (<?php echo e($items ? $items->total() : 0); ?>)</h2>
    <?php if($items->count()): ?>
        <div class="mt-5 mb-4">
            <?php echo e($items->links()); ?>

        </div>
        <?php if(session('message')): ?>
            <div class="alert alert-primary" role="alert">
                <?php echo e(session('message')); ?>

            </div>
        <?php endif; ?>
        <p>Дата загрузки страницы: <?php echo e(\Carbon\Carbon::now()->format('d.m.Y H:i')); ?> UTC</p>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>Пользователь</th>
                    <th>Специализация</th>
                    <th>Курс</th>
                    <th>Тест</th>
                    <th>Дата прохождения</th>
                    <th>Результат</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <a href="<?php echo e(route('admin.viewUser', ['id' => $item->user->id])); ?>">
                                <?php echo e($item->user->full_name); ?>

                            </a>
                        </td>
                        <td>
                            <a href="<?php echo e(route('admin.editSpeciality', ['speciality' => $item->test->course->speciality])); ?>">
                                <?php echo e($item->test->course->speciality->title); ?>

                            </a>
                        </td>
                        <td>
                            <a href="<?php echo e(route('admin.editCourse', [
                                    'speciality' => $item->test->course->speciality,
                                    'course' => $item->test->course
                                ])); ?>">
                                <?php echo e($item->test->course->title); ?>

                            </a>
                        </td>
                        <td>
                            <a href="<?php echo e(route('admin.editCourseTest', [
                                    'speciality' => $item->test->course->speciality,
                                    'course' => $item->test->course,
                                    'test' => $item->test
                                ])); ?>">
                                <?php echo e($item->test->title); ?>

                            </a>
                        </td>
                        <td><?php echo e($item->finished_at->format('d.m.Y H:i')); ?> UTC</td>
                        <td><?php echo e($item->getPrettyResult()); ?></td>
                        <td>
                            <?php if($item->certificate && $item->certificate->is_issued): ?>
                                <a href="<?php echo e(route('admin.previewCertificate', ['id' => $item->id,
                                        'certId' => $item->certificate->id])); ?>"
                                   class="btn btn-success btn-sm mr-2" role="button">
                                    Посмотреть сертификат
                                </a>
                            <?php elseif($item->certificate && !$item->certificate->is_issued): ?>
                                <a href="<?php echo e(route('admin.previewCertificate', ['id' => $item->id,
                                        'certId' => $item->certificate->id])); ?>"
                                   class="btn btn-warning btn-sm mr-2" role="button">
                                    Продолжить выдачу сертификата
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('admin.createCertificate', ['id' => $item->id])); ?>"
                                   class="btn btn-primary btn-sm mr-2" role="button">
                                    Выдать сертификат
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <?php echo e($items->links()); ?>

        </div>
    <?php else: ?>
        <p>Нет результатов</p>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/admin/testResults.blade.php ENDPATH**/ ?>