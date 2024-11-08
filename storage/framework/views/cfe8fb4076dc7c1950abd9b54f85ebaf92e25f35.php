<?php $__env->startSection('content'); ?>
	<div class="text-block-section centered page-title width1088 seminar">
		<?php if(Session::has('error')): ?>
			<div class="error">
				<span class="alert alert-danger"><?php echo e(Session::get('error')); ?></span>
			</div>
		<?php endif; ?>
		<div class="player">
			<lottie-player src="https://assets3.lottiefiles.com/packages/lf20_h0wlwb3f/Nuova cartella con elementi/Pecora_insegna.json" class="preview" background="transparent"  speed="1"  loop autoplay></lottie-player>
		</div>
		<?php if(empty(auth()->user()->seminar)): ?>
		<div class="image-seminar">
			<img src="/images/seminar.png" alt="Семинар">
		</div>
		<?php endif; ?>
		<?php if(empty(auth()->user()->seminar)): ?>
			<form action="<?php echo e(route('seminar')); ?>" method="GET">
				<input type="hidden" name="start" value="seminar">
				<button type="submit" class="btn btn-custom">Пройти семинар</button>
			</form>
		<?php else: ?>
			<form action="<?php echo e(route('seminar')); ?>" method="GET">
				<input type="hidden" name="start" value="seminar">
				<input type="hidden" name="download" value="certificate">
				<button type="submit" class="btn btn-custom">Скачать сертификат</button>
			</form>
			<div class="video">
				<iframe width="560" height="315" src="https://www.youtube.com/embed/hmDOWSf-Umk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
		<?php endif; ?>
	</div>

	<?php $__env->startPush('scripts'); ?>
		<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
	<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/seminar.blade.php ENDPATH**/ ?>