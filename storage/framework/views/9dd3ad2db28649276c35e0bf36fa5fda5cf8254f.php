<?php $__env->startSection('content'); ?>

	<?php echo $__env->make('parts.profileMenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<div class="lk flex between align-top centered width1088">
		<div class="profile">
			<div class="top flex between align-center" style="height:120px">
				<div class="balance"><?php echo app('translator')->get('profile.balance'); ?>: <span style="font-size:14pt;"><?php echo e($user->money_amount_kzt); ?> Т</span>

					<form action="/create_new_payment.php" method="POST" id="add_funds" target="_blank">
						<input type="hidden" name="user_id" value="<?php echo e($user->id); ?>">
						<input type="hidden" name="user_email" value="<?php echo e($user->email); ?>">
						<br>
						<table>
							<tr>
								<td><?php echo app('translator')->get('profile.fill_balance'); ?>:</td>
								<td width="5"></td>
								<td><input type="text" name="amount" style="width:100px;height:30px;font-size:12pt"></td>
								<td width="5"></td>
								<td><a href="javascript:document.getElementById('add_funds').submit()" class="btn black"><?php echo app('translator')->get('profile.fill'); ?></a></td>
							</tr>
						</table>
					</form>
				</div>
			</div>
			<div class="wrap">
				<?php if(session('message')): ?>
					<div style="margin-bottom: 16px;color: green;font-size: 18px;">
						<?php echo e(session('message')); ?>

					</div>
				<?php endif; ?>
				<div class="photo-name">
					<img style="max-width: 122px; max-height: 122px;" src="<?php echo e($user->photoUrl); ?>" alt="">
					<div class="name">
						<p><?php echo e($user->full_name); ?></p>
						<a href="<?php echo e(route('editProfile')); ?>" class="edit"><?php echo app('translator')->get('profile.edit'); ?></a>
						<?php if($user->isAdmin()): ?>
							<br>
							<a style="color: red; font-size: 18px;"
								href="<?php echo e(@route('admin.index')); ?>"><?php echo app('translator')->get('profile.to_admin'); ?></a>
						<?php endif; ?>
					</div>
				</div>
				<div class="contacts">
					<div class="col">
						<span class="email"><a href="mailto:<?php echo e($user->email); ?>"><?php echo e($user->email); ?></a></span>
						<span class="phone">
                  	<?php if($user->phone): ?>
								<a href="tel:<?php echo e($user->phone); ?>"><?php echo e($user->phone); ?></a>
							<?php else: ?>
								<?php echo app('translator')->get('profile.not_specified'); ?>
							<?php endif; ?>
						</span>
						<span class="role">
							<?php echo e($user->position ?? __('profile.not_specified')); ?>

						</span>
					</div>
					<div class="col">
						<span class="geo"><?php echo e($user->company_name ?? __('profile.not_specified')); ?></span>
						
						<span class="key"><a href="<?php echo e(route('editPassword')); ?>"><?php echo app('translator')->get('profile.change_password'); ?></a></span>
					</div>
				</div>
			</div>
			<a class="btn-support flex center align-center">
				<img src="/images/elements/support.svg" alt="">
				<span><?php echo app('translator')->get('profile.support'); ?></span>
			</a>
		</div>
		<div class="courses">
			<div class="title"><?php echo app('translator')->get('profile.my_courses'); ?></div>
			<div class="wrap">
				<?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
					<div class="course physics">
						<div class="title" style="font-size: 10pt;"><?php echo e($course->title); ?></div>
						<div class="watch"><a href="<?php echo e(route('course', [ 'id' => $course->id ])); ?>"
													 class="btn blue shadow watch"><?php echo app('translator')->get('profile.watch'); ?></a></div>
					</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
					<?php echo app('translator')->get('profile.no_courses'); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<?php echo $__env->make('parts.recommendations', [ 'templateNarrow' => true ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('parts.chat', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<?php $__env->startPush('scripts'); ?>
		<script src="<?php echo e(mix('/js/app.min.js')); ?>"></script>
	<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/profile.blade.php ENDPATH**/ ?>