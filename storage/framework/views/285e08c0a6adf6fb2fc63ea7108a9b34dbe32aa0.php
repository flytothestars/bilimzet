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

				$out = send_mail_from_gmail("info2@kcppk.kz", "Сообщение на сайте", $mess);
				if ($out === false) {
					$error = curl_getinfo();
					echo "<script> alert('Не удалось отправить сообщение, ";
					echo $error;
					echo "'); </script>";
				} else {
					echo "<script> alert('Ваше сообщение успешно отправлено'); </script>";
				}
			}

		} catch (exception $e) {
			//code to handle the exception
		}
	?>

	<div class="slider flex align-center top-block">
		<div class="centered">
			<div class="moz flex between align-top">
				<!---<div class="left-side">
					<div class="events">
						<img src="/images/events.png" alt="">
						<a href="/ru/novosti/anons-predstoyashchikh-meropriyatii" class="rotate">Предстоящие события</a>
					</div>
					<div class="socials">
						<a href="http://facebook.com/" target="_blank"><img src="/images/fb.svg" alt=""></a>
						<a href="http://instagram.com/" target="_blank"><img src="/images/instagram.svg" alt=""></a>
					</div>
				</div>--->
			</div>
		</div>
	</div>

	<div class="slider-block">
		<div class="centered flex between align-bottom">
			<div class="panel">
				<div class="swiper-pagination"></div>
				<!---<ul class="social">
					<li><a href="#"><img src="/images/elements/facebook.svg" alt=""></a></li>
					<li><a href="#"><img src="/images/elements/vk.svg" alt=""></a></li>
					<li><a href="#"><img src="/images/elements/instagram.svg" alt=""></a></li>
				</ul>--->
			</div>
			<div class="slider">
				<div class="swiper-container swiper-mainslider">
					<div class="swiper-wrapper">
						<div class="slide swiper-slide">
							<div class="slide-body" style="background:url('/images/slider/slide1.svg') no-repeat;">
								<div class="text-block">
									<div class="num num_1">01</div>
									<div class="title"><?php echo app('translator')->get('home.title1'); ?></div>
									<div class="text"><?php echo app('translator')->get('home.text1'); ?></div>
								</div>
								<img class="slider-image" src="/images/pics/teacher.png" alt="">
							</div>
						</div>
						<div class="slide swiper-slide">
							<div class="slide-body" style="background:url(/images/slider/slide2.svg) no-repeat;">
								<div class="text-block">
									<div class="num num_2">02</div>
									<div class="title"><?php echo app('translator')->get('home.title2'); ?></div>
									<div class="text"><?php echo app('translator')->get('home.text2'); ?></div>
								</div>
								<img class="slider-image" src="/images/pics/teacher2.png" alt="">
							</div>
						</div>
						<div class="slide swiper-slide">
							<div class="slide-body" style="background:url(/images/slider/slide3.svg) no-repeat;">
								<div class="text-block">
									<div class="num num_3">03</div>
									<div class="title title_big"><?php echo app('translator')->get('home.title3'); ?></div>
								</div>
								<img class="slider-image" src="/images/pics/teacher3.png" alt="">
							</div>
						</div>
					</div>
				</div>
				<div class="bottom-navi flex between align-center">
					<span class="swiper-button-next prevMSlide left"><img src="/images/elements/white-arrow-left.svg" alt=""></span>
					<span class="swiper-button-next nextMSlide right"><img src="/images/elements/white-arrow-right.svg" alt=""></span>
				</div>
			</div>
		</div>
	</div>

	<div class="news">
		<div class="centered top flex between align-bottom">
			<div class="title"><?php echo app('translator')->get('home.news_events'); ?></div>
			<a href="<?php echo e(route('news')); ?>"><?php echo app('translator')->get('home.news'); ?></a>
		</div>
		<div class="news-row">
			<?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $new): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="news-item">
					<div class="image"><img src="<?php echo e('/uploads/news/' . $new->miniature); ?>" alt=""></div>
					<div class="date"><img src="images/elements/date.svg" alt=""><span><?php echo e($new->date); ?></span></div>
					<div class="title"><a href="<?php echo e(route('newPost', ['id' => $new->id])); ?>"><?php echo e($new->name); ?></a></div>
					<div class="link"><a href="<?php echo e(route('newPost', ['id' => $new->id])); ?>"><?php echo app('translator')->get('home.more'); ?></a></div>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
	</div>






	<div class="company">
		<div class="centered">
			<div class="title-image flex align-center">
				<div class="title"><?php echo app('translator')->get('home.about'); ?></div>
				<img src="/images/logo-w-rounds.svg" alt="">
			</div>
			<div class="text">
				<?php $__currentLoopData = $about_pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php echo $page; ?>

				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>
		</div>
	</div>

	<div class="course-benefits">
		<div class="width1088">
			<div class="title"><?php echo app('translator')->get('home.benefits'); ?></div>
			<div class="items flex between align-top wrap">
				<div class="item">
					<img src="/images/courses/benefits/1.svg" alt="">
					<div class="title"><?php echo app('translator')->get('home.benefit1'); ?></div>
					<div class="num">01</div>
				</div>
				<div class="item">
					<img src="/images/courses/benefits/2.svg" alt="">
					<div class="title"><?php echo app('translator')->get('home.benefit2'); ?></div>
					<div class="num">02</div>
				</div>
				<div class="item">
					<img src="/images/courses/benefits/3.svg" alt="">
					<div class="title"><?php echo app('translator')->get('home.benefit3'); ?></div>
					<div class="num">03</div>
				</div>
				<div class="item">
					<img src="/images/courses/benefits/4.svg" alt="">
					<div class="title title_big"><?php echo app('translator')->get('home.benefit4'); ?></div>
					<div class="num">04</div>
				</div>
				<div class="item">
					<img src="/images/courses/benefits/5.svg" alt="">
					<div class="title"><?php echo app('translator')->get('home.benefit5'); ?></div>
					<div class="num">05</div>
				</div>
				<div class="item">
					<img src="/images/courses/benefits/6.svg" alt="">
					<div class="title title_small"><?php echo app('translator')->get('home.benefit6'); ?></div>
					<div class="num">06</div>
				</div>
			</div>
		</div>
	</div>

	<div class="steps">
		<div class="width1088">
			<div class="title"><?php echo app('translator')->get('home.steps'); ?></div>
			<ul>
				<li class="item">
					<div class="flex between align-center">
						<img src="/images/steps/step1.svg" alt="">
						<p><?php echo app('translator')->get('home.step1'); ?></p>
					</div>
					<div class="num"><span>01</span></div>
				</li>
				<li class="item">
					<div class="flex between align-center">
						<img src="/images/steps/step2.svg" alt="">
						<p><?php echo app('translator')->get('home.step2'); ?></p>
					</div>
					<div class="num"><span>02</span></div>
				</li>
				<li class="item">
					<div class="flex between align-center">
						<img src="/images/steps/step3.svg" alt="">
						<p><?php echo app('translator')->get('home.step3'); ?></p>
					</div>
					<div class="num"><span>03</span></div>
				</li>
				<li class="item">
					<div class="flex between align-center">
						<img src="/images/steps/step4.svg" alt="">
						<p><?php echo app('translator')->get('home.step4'); ?></p>
					</div>
					<div class="num"><span>04</span></div>
				</li>
				<li class="item">
					<div class="flex between align-center">
						<img src="/images/steps/step5.svg" alt="">
						<p><?php echo app('translator')->get('home.step5'); ?></p>
					</div>
					<div class="num"><span>05</span></div>
				</li>
				<li class="item">
					<div class="flex between align-center">
						<img src="/images/steps/step6.svg" alt="">
						<p><?php echo app('translator')->get('home.step6'); ?></p>
					</div>
					<div class="num"><span>06</span></div>
				</li>
				<li class="item">
					<div class="flex between align-center">
						<img src="/images/steps/step7.svg" alt="">
						<p><?php echo app('translator')->get('home.step7'); ?></p>
					</div>
					<div class="num"><span>07</span></div>
				</li>
				<li class="item">
					<div class="flex between align-center">
						<img src="/images/steps/step8.svg" alt="">
						<p><?php echo app('translator')->get('home.step8'); ?></p>
					</div>
					<div class="num"><span>08</span></div>
				</li>
			</ul>
		</div>
	</div>

	<div class="subjects-block">
		<div class="centered">
			<div class="title"><?php echo app('translator')->get('home.course'); ?></div>
			<div class="subjects flex center align-top wrap">
				<a href="/specialities?tab=1" class="subject choose-curse-qualification">
					<img src="/images/bgs/choose-curse-qualification.png" alt="">
					<span><?php echo app('translator')->get('home.training'); ?></span>
				</a>
				<a href="/specialities?tab=2" class="subject choose-curse-retraining">
					<img src="/images/bgs/choose-curse-retraining.png" alt="">
					<span><?php echo app('translator')->get('home.retraining'); ?></span>
				</a>
			</div>
		</div>
	</div>

	<?php echo $__env->make('parts.feedback', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/index.blade.php ENDPATH**/ ?>