<?php $__env->startSection('content'); ?>
    <h2 class="mt-4 mb-3">Пользователи (<?php echo e($items ? $items->total() : 0); ?>)</h2>
    <?php if($items->total() > 1): ?>
        <div class="text-right">
            <form method="post" action="<?php echo e(route('admin.exportUsers')); ?>">
                <?php echo csrf_field(); ?>
                <button role="button" class="btn btn-primary btn-sm mr-2">
                    Экспорт всех пользователей в Excel
                </button>
            </form>
        </div>
    <?php endif; ?>
    <?php if($items->count()): ?>
        <div class="mt-5 mb-4">
            <?php echo e($items->links()); ?>

        </div>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>ФИО</th>
                    <th>E-mail</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($item->full_name); ?></td>
                        <td><?php echo e($item->email); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.viewUser', ['id' => $item->id])); ?>"
                               role="button" class="btn btn-primary btn-sm mr-2">Просмотр</a>
                            <form style="display: inline-block" method="post"
                                  action="<?php echo e(route('admin.destroyUser', ['id' => $item->id])); ?>">
                                <?php echo csrf_field(); ?>
                                <?php if(!$item->isAdmin()): ?>
                                    <button type="submit" class="btn btn-danger btn-sm mr-2">Удалить</button>
                                <?php endif; ?>
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
        <p>Нет пользователей</p>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/admin/users.blade.php ENDPATH**/ ?>