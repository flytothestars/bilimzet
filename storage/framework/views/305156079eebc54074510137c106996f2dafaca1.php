<div class="what-will-you-get">
	<div class="width1088" style="height: 360px;">
		<div class="title">
			<span><?php echo app('translator')->get('home.feedback'); ?></span>
			<span class="little"><?php echo app('translator')->get('home.feedback_desc'); ?></span>
		</div>
		<form action="/index.php" method="GET">
			<div class="flex between align-center">
				<input type="text" name="request_name" placeholder="<?php echo app('translator')->get('home.feedback_name'); ?>">
				<input type="phone" name="request_phone" placeholder="<?php echo app('translator')->get('home.feedback_phone'); ?>">
				<input type="email" name="request_email" placeholder="<?php echo app('translator')->get('home.feedback_email'); ?>">
			</div>
			<textarea placeholder="<?php echo app('translator')->get('home.feedback_message'); ?>" name="request_message"></textarea>
			<input type="submit" value="<?php echo app('translator')->get('home.feedback_send'); ?>" class="btn blue">
		</form>
		<img class="image" src="/images/pics/man.png" alt="">
	</div>
</div>
<?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/parts/feedback.blade.php ENDPATH**/ ?>