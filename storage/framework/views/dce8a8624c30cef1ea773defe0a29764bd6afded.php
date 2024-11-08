<?php $__env->startSection('content'); ?>

    <nav aria-label="breadcrumb" class="mt-4">
        <ol class="breadcrumb">
			  <li class="breadcrumb-item"><a href="<?php echo e(route('admin.contestFiles')); ?>">Файлы конкуров</a></li>
            <li class="breadcrumb-item active" aria-current="page">Просмотр награды</li>
        </ol>
    </nav>

    <h2 class="mt-4 mb-3">Просмотр награды</h2>

    <div>
        <p class="mt-3" style="font-size: 1.2rem"><?php echo e($award->title); ?></p>
        <div class="mt-4 mb-4">
            <a target="_blank" href="<?php echo e($award->certificate->getUploadedUrl('file')); ?>">
                <img style="max-width: 100%; max-height: 500px;" src="<?php echo e($award->certificate->getUploadedUrl('file')); ?>" alt="нажмите для увеличения">
            </a>
        </div>

        <form action="<?php echo e(route('admin.deleteAward', [ 'contestFile' => $contestFile->id, 'award' => $award->id ])); ?>" method="post">
            <?php echo csrf_field(); ?>
            <button type="submit" name="_save_opt" value="delete" class="mt-2 mr-3 btn btn-danger">
                Удалить награду
            </button>
        </form>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/admin/previewAward.blade.php ENDPATH**/ ?>