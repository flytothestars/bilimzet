<?php $__env->startSection('content'); ?>
    <style>
        .list-group a input{
            background: transparent;
            border: 0;
            color: #000;
        }

        .list-group a.active input,
        .list-group a.active input:active,
        .list-group a.active input:focus,
        .list-group a.active input:hover{
            color: #fff;
            border: 0;
            box-shadow: none;
            outline: 0;
            outline-offset: 0;
        }
    </style>
    <nav aria-label="breadcrumb" class="mt-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.contests')); ?>">Конкурсы</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.editContest', ['contest' => $contest])); ?>"><?php echo e($contest->title); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page">Награды конкурса</li>
        </ol>
    </nav>
    <h2 class="mt-4 mb-3">Награды конкурса</h2>
    <div>
        <form id="form" method="post" enctype="multipart/form-data" action="<?php echo e($formAction); ?>">
            <?php echo csrf_field(); ?>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-4">
                    <div class="list-group" id="list-tab" role="tablist">
                        <?php $__currentLoopData = $certificates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a class="list-group-item list-group-item-action" data-id="<?php echo e($item->id); ?>" id="list-<?php echo e($item->id); ?>-list" data-toggle="list" href="#list-<?php echo e($item->id); ?>" role="tab" aria-controls="list-<?php echo e($item->id); ?>">
                                <input type="text" name="list[]" value="<?php echo e($item->title); ?>">
                                <input type="hidden" name="id[]" value="<?php echo e($item->id); ?>">
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <a class="btn btn-primary add_git" data-count="<?php echo e(count($certificates)); ?>">Добавить</a>
                    <input type="submit" class="btn btn-success" value="Сохранить">
                </div>
                <div class="col-8">
                    <div class="tab-content" id="nav-tabContent">
                        <?php $__currentLoopData = $certificates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="tab-pane fade show" data-id="<?php echo e($item->id); ?>" id="list-<?php echo e($item->id); ?>" role="tabpanel" aria-labelledby="list-<?php echo e($item->id); ?>-list">
                                <textarea name="tab[]" id="" style="width: 100%; height: 200px"><?php echo e($item->text); ?></textarea>
                                <label for="">Изображение сертификата</label>
                                <input type="file" name="picture<?php echo e($item->id); ?>">
                                <div class="mt-1">
                                    Используется:
                                    <a target="_blank" href="/uploads/certificate/<?php echo e($item->file); ?>">картинка</a>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

        </form>
    </div>

	 <?php $__env->startPush('scripts'); ?>
		 <script>
			 $(document).ready(function () {
				 $('.add_git').click(function (e) {
					 e.preventDefault();
					 var total = $(this).attr('data-count');
					 var total = Number(total) + 1;
					 $(this).attr('data-count', total);
					 var list = '<a class="list-group-item list-group-item-action" data-id="'+total+'" id="list-'+total+'-list" data-toggle="list" href="#list-'+total+'" role="tab" aria-controls="list-'+total+'"><input type="text" name="list[]" value="..."><input type="hidden" name="id[]" value="'+total+'"></a>';
					 var tab = '<div class="tab-pane fade show" data-id="'+total+'" id="list-'+total+'" role="tabpanel" aria-labelledby="list-'+total+'-list"><textarea name="tab[]" id="" style="width: 100%; height: 200px"></textarea> <label for="">Изображение сертификата</label><input name="picture'+total+'" type="file" value=""></div>';
					 $('.list-group').append(list);
					 $('.tab-content').append(tab);
				 })
			 })
		 </script>
	 <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/admin/certificateContest.blade.php ENDPATH**/ ?>