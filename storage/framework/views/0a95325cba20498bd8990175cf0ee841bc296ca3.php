<?php $__env->startSection('content'); ?>

	<div class="centered page-title width1088">
		<h1><?php echo e($item->title); ?></h1>
	</div>

	<div class="konkurs-full flex between align-top width1088">
		<div class="topblock">
			<div class="top"><?php echo app('translator')->get('contests.description'); ?></div>
			<div class="text"><?php echo $item->desc_text; ?></div>
		</div>
	</div>

	<div class="pay-table width1088">
		<div class="top"><?php echo app('translator')->get('contests.prices'); ?></div>
		<table>
			<?php $__currentLoopData = $item->parts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td>
					  <span class="left">
							<span class="hours"><?php echo e($part->duration_hours); ?> <?php echo app('translator')->get('contests.hours'); ?></span>
							<span class="cost"><?php echo e($part->price_kzt); ?> Тг.</span>
					  </span>
					</td>
					<td>
						<a target="_blank" href="<?php echo e($part->getUploadedUrl('plan')); ?>" download="<?php echo e($part->real_plan_name); ?>">
							<?php echo app('translator')->get('contests.download'); ?>
						</a>
						<?php if($purchasedIds->contains($part->id)): ?>
							<a href="/handouts" class="buy"><?php echo app('translator')->get('contests.read'); ?></a>
						<?php else: ?>
							<a href="<?php echo e(route('buyContestPart', ['contestId' => $item->id, 'partId' => $part->id])); ?>"
								class="buy"><?php echo app('translator')->get('contests.part'); ?></a>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</table>
	</div>

	<?php if(count($item->certificates)): ?>
		<div class="konkurs-benefits">
			<div class="width1088">
				<div class="title"><?php echo app('translator')->get('contests.prizes'); ?></div>
				<div class="items flex between align-top wrap">
					<?php $__currentLoopData = $item->certificates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $certificate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<div class="item">
							<img src="/uploads/certificate/<?php echo e($certificate->picture); ?>" alt="">
							<div class="title"><?php echo e($certificate->name); ?></div>
							<div class="description"><?php echo e($certificate->text); ?></div>
						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div class="konkurs-members">
		<div class="width1088">
			<div class="title"><?php echo app('translator')->get('contests.competitors'); ?></div>
			<table>
				<thead>
				<tr>
					<th><?php echo app('translator')->get('contests.nominations'); ?></th>
					<th><?php echo app('translator')->get('contests.participant'); ?></th>
					<th><?php echo app('translator')->get('contests.work'); ?></th>
					<th><?php echo app('translator')->get('contests.reward'); ?></th>
				</tr>
				</thead>
				<tbody>
					<?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td>
								<a href="#" class="work-title"><?php echo e($testimonial->text); ?></a>
								<div class="work-date"><img src="images/elements/date.svg" alt=""><?php echo e($testimonial->updated_at); ?></div>
							</td>
							<td>
								<div class="member flex start align-center"><img src="<?php echo e($testimonial->user->photoUrl); ?>" alt=""><span><?php echo e($testimonial->user->full_name); ?></span></div>
								<div class="member-organization"><?php echo e($testimonial->user->company_name ?? '-'); ?></div>
								<div class="member-role"><?php echo e($testimonial->user->position ?? '-'); ?></div>
							</td>
							<td>
								<div class="pdf"><img src="images/elements/pdf.svg" alt=""><span><?php echo app('translator')->get('contests.pdf'); ?></span></div>
								<a class="btn bluebtn" href="#"><?php echo app('translator')->get('contests.watch'); ?></a>
							</td>
							<td>
								<div class="pdf"><img src="images/elements/pdf.svg" alt=""><span><?php echo app('translator')->get('contests.reward_file'); ?></span></div>
								<div class="reward-desc"><?php echo app('translator')->get('contests.first'); ?></div>
							</td>
						</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tbody>
			</table>
		</div>
	</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/contestItem.blade.php ENDPATH**/ ?>