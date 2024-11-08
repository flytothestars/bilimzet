<?php $__env->startSection('content'); ?>
	<h2 class="mt-4 mb-3">Служба поддержки</h2>

	<?php if($chatrooms->count()): ?>



		<div class="table-responsive">
			<table class="table table-striped table-sm">
				<thead>
				<tr>
					<th>ФИО</th>
					<th>Сообщение</th>
					<th>Действия</th>
				</tr>
				</thead>
				<tbody>
				<?php $__currentLoopData = $chatrooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chatroom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td>
							<?php if(!$chatroom->viewed): ?> <b> <?php endif; ?>
								<?php echo e($chatroom->full_name); ?>

							<?php if(!$chatroom->viewed): ?> </b> <?php endif; ?>
						</td>
						<td>
							<?php if(!$chatroom->viewed): ?> <b> <?php endif; ?>
								<?php echo $chatroom->message; ?>

							<?php if(!$chatroom->viewed): ?> </b> <?php endif; ?>
						</td>
						<td>
							<a href="<?php echo e(route('admin.chat', [ 'chatroom' => $chatroom->id ])); ?>"
								role="button" class="btn btn-primary btn-sm mr-2">Чат</a>
						</td>
					</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tbody>
			</table>
		</div>



	<?php else: ?>
		<p>Нет чатов</p>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/admin/support.blade.php ENDPATH**/ ?>