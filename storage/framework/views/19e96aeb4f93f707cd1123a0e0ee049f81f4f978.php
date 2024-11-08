<?php $__env->startSection('content'); ?>

	<h2 class="mt-4 mb-3">Благодарственные письма</h2>

	<div class="table-responsive">
		<table class="table table-striped table-sm">
			<thead>
				<tr>
					<th>Картинка</th>
					<th>Действия</th>
				</tr>
			</thead>
			<tbody>
				<?php $__currentLoopData = $letters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $letter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td>
							<a href="<?php echo e($letter->image); ?>" target="_blank">
								<img src="<?php echo e($letter->image); ?>" width="50">
							</a>
						</td>
						<td>
							<form action="<?php echo e(route('admin.letters.delete')); ?>" method="post" style="display: inline-block">
								<?php echo csrf_field(); ?>
								<input type="hidden" name="photo_to_delete" value="<?php echo e($letter->id); ?>">
								<button type="submit" class="btn btn-danger btn-sm mr-2">Удалить</button>
							</form>
						</td>
					</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</tbody>
		</table>
	</div>
	<br>

	<form action="<?php echo e(route('admin.letters.store')); ?>" id='load_file' method='POST' enctype='multipart/form-data'>
		<?php echo csrf_field(); ?>
		<table>
			<tr>
				<td>Путь к фото:</td>
				<td width="5"></td>
				<td>
					<input type="file" name="letter_photo">
				</td>
			</tr>
		</table>
	</form>
	<a href="javascript:document.getElementById('load_file').submit()" role="button" class="btn btn-primary btn-sm mr-2">Добавить фото</a>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/admin/letters.blade.php ENDPATH**/ ?>