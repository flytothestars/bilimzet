<?php $__env->startSection('content'); ?>
    <nav aria-label="breadcrumb" class="mt-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.testResults')); ?>">Результаты
                    тестов</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                Просмотр сертификата
            </li>
        </ol>
    </nav>
    <h2 class="mt-4 mb-3">Просмотр сертификата</h2>
    <div>
        <p class="mt-3" style="font-size: 1.2rem"><?php echo e($item->title); ?></p>
        <div class="mt-4 mb-4">
            <a target="_blank" href="<?php echo e($item->getUploadedUrl('file')); ?>">
                <img style="max-width: 100%; max-height: 500px;"
                     src="<?php echo e($item->getUploadedUrl('file')); ?>"
                     alt="нажмите для увеличения">
            </a>
        </div>

        <form id="form" method="post" enctype="multipart/form-data"
              action="<?php echo e($formAction); ?>">
            <?php echo csrf_field(); ?>

            <?php if(!$item->is_issued): ?>
                <button type="submit" name="_save_opt" value="issue" class="mt-2 mr-3 btn btn-success">
                    Выдать сертификат
                </button>
                <button type="submit" name="_save_opt" value="edit" class="mt-2 mr-3 btn btn-warning">
                    Изменить текст
                </button>
            <?php endif; ?>
            <button type="submit" name="_save_opt" value="delete" class="mt-2 mr-3 btn btn-danger">
                Удалить сертификат
            </button>
        </form>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/admin/certificatePreview.blade.php ENDPATH**/ ?>