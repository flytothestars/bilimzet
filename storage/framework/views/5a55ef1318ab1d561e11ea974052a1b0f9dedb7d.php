<?php $__env->startSection('content'); ?>

	<h2 class="mt-4 mb-3">Файлы конкурсов (<?php echo e($items ? $items->total() : 0); ?>)</h2>

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
					<th>Конкурс</th>
					<th>Дата загрузки</th>
					<th>Файл</th>
					<th>Видео</th>
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
							<a href="<?php echo e(route('admin.editContest', [ 'contest' => $item->contest ])); ?>">
								<?php echo e($item->contest->title); ?>

							</a>
						</td>
						<td><?php echo e($item->updated_at ? $item->updated_at->format('d.m.Y H:i') . 'UTC' : 'нет'); ?></td>
						<td>
							<div class="link file">
								<?php $__currentLoopData = explode(';', $item->file); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<a href="<?php echo e('/uploads/contest_files/' . $file); ?>" target="_blank"><?php echo e($file); ?></a>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
						</td>
						<td>
							<div class="link video">
								<?php $__currentLoopData = explode(';', $item->video); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<a href="<?php echo e($video); ?>" target="_blank"><?php echo e($video); ?></a>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
						</td>
						<td>
							<?php if($item->award): ?>
								<a href="<?php echo e(route('admin.previewAward', [ 'contestFile' => $item->id, 'award' => $item->award->id ])); ?>" class="btn btn-success btn-sm mr-2" role="button">
									Посмотреть награду
								</a>
								<form action="<?php echo e(route('admin.deleteAward', [ 'contestFile' => $item->id, 'award' => $item->award->id ])); ?>" method="post">
									<?php echo csrf_field(); ?>
									<button type="submit" name="_save_opt" value="delete" class="mt-2 mr-3 btn btn-danger">
										Удалить награду
									</button>
								</form>
							<?php else: ?>
								<a href="<?php echo e(route('admin.createAward', [ 'contestFile' => $item->id ])); ?>" class="btn btn-primary btn-sm mr-2" role="button">
									Выдать награду
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
		<p>Нет файлов</p>
	<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/admin/contestFiles.blade.php ENDPATH**/ ?>