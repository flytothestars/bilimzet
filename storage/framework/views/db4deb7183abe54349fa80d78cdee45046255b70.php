<?php $__env->startSection('content'); ?>

	<?php

		require("classes/classes.php");
		require("functions/functions.php");
		try {
			$request_name = $_REQUEST["request_name"];
			$request_phone = $_REQUEST["request_phone"];
			$request_email = $_REQUEST["request_email"];
			$request_message = $_REQUEST["request_message"];

			///отправка сообщения
			if ($request_name != "" and $request_email != "" and $request_message != "") {


				///отправка сообщения
				$mess = "Здравствуйте!<br><br>Вам на сайте поступило сообщение от $request_name ($request_email, $request_email):<br><br>$request_message";

				send_mail_from_gmail("info2@kcppk.kz", "Сообщение на сайте", $mess);
				echo "
				<script>
					alert('Ваше сообщение успешно отправлено');
				</script>
				";
			}

		} catch (exception $e) {
			//code to handle the exception
		} finally {


		}
	?>

	<div class="centered page-title width1088">
		<h1><?php echo app('translator')->get('contacts.title'); ?></h1>
	</div>

	<!---

<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d16434.44475681874!2d76.9510226683963!3d43.26762346503022!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38836ea1773f7ef1%3A0xa6c17b8bc2c48d1c!2z0YPQu9C40YbQsCDQltC10LvRgtC-0LrRgdCw0L0gMzcsINCQ0LvQvNCw0YLRiyAwNTAwMDAsINCa0LDQt9Cw0YXRgdGC0LDQvQ!5e0!3m2!1sru!2sru!4v1573529873435!5m2!1sru!2sru" width="1366" height="460" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
	<br><br>
	<br><br>
	<br><br><br><br>
	<br><br>
	<br><br><br><br>
	<br><br>
	<br><br><br><br>
	<br><br>
	<br><br> --->
	<div class="map">

		<iframe
			src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d16434.44475681874!2d76.9510226683963!3d43.26762346503022!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38836ea1773f7ef1%3A0xa6c17b8bc2c48d1c!2z0YPQu9C40YbQsCDQltC10LvRgtC-0LrRgdCw0L0gMzcsINCQ0LvQvNCw0YLRiyAwNTAwMDAsINCa0LDQt9Cw0YXRgdGC0LDQvQ!5e0!3m2!1sru!2sru!4v1573529873435!5m2!1sru!2sru"
			width="1366" height="460" frameborder="0" style="border:0;" allowfullscreen=""></iframe>


		<br><br>
		<br><br>
		<br><br><br><br>
		<br><br>
		<br><br><br><br>
		<br><br>
		<br><br><br><br>
		<br><br>
		<br><br>

		<div class="contacts-block width1088" style="width:1200px">
			<div class="contacts-body" style="width:1200px">
				<div class="top flex between align-top wrap" style="width:100%">

					<?php $__currentLoopData = $contact_pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php echo $page; ?>

					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				</div>
				<div class="form">
					<form class="flex between align-top wrap" action="/contacts" method="GET">

						<input type="text" name="request_name" placeholder="<?php echo app('translator')->get('contacts.name'); ?>" style="width: 300px;">
						<input type="phone" name="request_phone" placeholder="<?php echo app('translator')->get('contacts.phone'); ?>" style="width: 300px;">
						<input type="email" name="request_email" placeholder="<?php echo app('translator')->get('contacts.email'); ?>" style="width: 300px;">

						<textarea placeholder="<?php echo app('translator')->get('contacts.message'); ?>" name="request_message"></textarea>
						<div class="bottom flex end align-top">
							<button class="btn black"><?php echo app('translator')->get('contacts.send'); ?></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="contspec">
		<div class="contspec__title"><?php echo app('translator')->get('contacts.contacts'); ?></div>
		<div class="cont-tb-wrap">
			<div class="cont-tb">
				<?php $__currentLoopData = $contact_stuff_pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php echo $page; ?>

				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>
		</div>
	</div>

	<?php echo $__env->make('parts.guide', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/contacts.blade.php ENDPATH**/ ?>