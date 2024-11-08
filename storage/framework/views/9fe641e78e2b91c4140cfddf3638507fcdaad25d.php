<?php $__env->startSection('content'); ?>
    <h2 class="mt-4 mb-3">Сертификаты (<?php echo e($items ? $items->total() : 0); ?>)</h2>
    <?php if($items->count()): ?>
        <div class="mt-5 mb-4">
            <?php echo e($items->links()); ?>

        </div>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>Пользователь</th>
                    <th>Название сертификата</th>
                    <th>Файл</th>
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
                            <?php echo e($item->title); ?>

                        </td>
                        <td>
                            <a href="<?php echo e($item->getUploadedUrl('file')); ?>" target="_blank">
                                открыть
                            </a>
                        </td>
                        <td>
                            <form style="display: inline-block" method="post"
                                  action="<?php echo e(route('admin.destroyCertificate', ['id' => $item->id])); ?>">
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
            <?php echo e($items->links()); ?>

        </div>
    <?php else: ?>
        <p>Нет сертификатов</p>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/admin/certificates.blade.php ENDPATH**/ ?>