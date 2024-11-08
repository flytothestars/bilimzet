<?php $__env->startSection('content'); ?>

    <div class="login flex between align-top width1088 shadow">
        <div class="right" style="flex-basis: 100%;">
            <div class="wrap">
					<div style="width: 900px;">
						 <div class="title"><?php echo app('translator')->get('buy.title_contest'); ?></div>
						 <?php if(session('errorMessage')): ?>
							  <div style="margin-bottom: 32px; color: red; font-size: 18px;">
									<?php echo e(session('errorMessage')); ?>

							  </div>
						 <?php endif; ?>
						 <p><a href="<?php echo e(route('contests', [ 'id' => $item->contest_id ])); ?>"><?php echo app('translator')->get('buy.back'); ?></a></p>
						 <p><?php echo app('translator')->get('buy.gotta_contest'); ?> <b>"<?php echo e($item->contest->title); ?>".</b></p>
						 <p><?php echo app('translator')->get('buy.duration'); ?>: <b><?php echo e($item->duration_hours); ?> Ак.ч.</b></p>
						 <p><?php echo app('translator')->get('buy.price'); ?>: <b><?php echo e($item->price_kzt); ?> Tг.</b></p>
						 <br>
						 <p><?php echo app('translator')->get('buy.money'); ?>: <b><?php echo e($availableMoneyKZT); ?> Tг.</b></p>
						 <form id="buyContestForm" method="post">
							  <?php echo csrf_field(); ?>
							  <?php if($item->price_kzt <= $availableMoneyKZT): ?>
									<a class="buy" href="#" onclick="document.getElementById('buyContestForm').submit(); return false;"><b><?php echo app('translator')->get('buy.buy'); ?></b></a>
							  <?php else: ?>
									<br>
									<p><?php echo app('translator')->get('buy.not_enough'); ?> <a href="<?php echo e(route('profile')); ?>"><b><?php echo app('translator')->get('buy.not_enough_profile'); ?></b></a></p>
							  <?php endif; ?>
						 </form>
					</div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/buyContestPart.blade.php ENDPATH**/ ?>