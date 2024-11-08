<?php $__env->startSection('content'); ?>

	<nav aria-label="breadcrumb" class="mt-4">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo e(route('admin.testResults')); ?>">Результаты тестов</a></li>
			<li class="breadcrumb-item active" aria-current="page">
				<?php echo e($item ? 'Редактировать' : 'Добавить'); ?> сертификат
			</li>
		</ol>
	</nav>

	<h2 class="mt-4 mb-3"><?php echo e($item ? 'Редактировать' : 'Добавить'); ?> сертификат</h2>

	<div>
		<form id="form" method="post" action="<?php echo e(route(($certId ? 'admin.updateContestCertificate' : 'admin.storeContestCertificate'), [ 'contestFile' => $contestFile->id, 'certId' => $certId ])); ?>" enctype="multipart/form-data">
			<?php echo csrf_field(); ?>
			<input type="hidden" name="contest_id" value="<?php echo e($contestFile->contest->id); ?>">
			<?php if($errors->any()): ?>
				<div class="alert alert-danger" role="alert">
					<?php echo e($errors->first()); ?>

				</div>
			<?php endif; ?>

			<div class="form-group">
				<label for="course_title">Название конкурса</label>
				<input value="<?php echo e($contestFile->contest->title ?? old('contest_title')); ?>"
						 class="form-control <?php $__errorArgs = ['contest_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
						 type="text" name="contest_title" id="contest_title" placeholder="">
				<?php $__errorArgs = ['contest_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
					<div class="invalid-feedback">
						<?php echo e($errors->first('contest_title')); ?>

					</div>
				<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
			</div>

			<div class="cert" style="line-height:1;">
				<div class="cert-head">
					<div class="cert-head__left">
						Қазақстан Республикасының <br>
						Білім және Ғылым Министрлігінің <br>
						Бұйрығына сәйкес <br>
						Қазақстандық Қайта Даярлау және Біліктілікті <br>
						Арттыру Орталығы
					</div>
					<img src="/img/223.png" alt="" class="cert-head__img">
					<div class="cert-head__right">
						Согласно Приказу <br>
						Министерства Образования и Науки <br>
						Республики Казахстан <br>
						Казахстанский Центр Переподготовки и <br>
						Повышения Квалификации
					</div>
				</div>
				<div class="cert__title">
					СЕРТИФИКАТ
				</div>
				<div class="cert__disc">
					Қазақстан Республикасы Білім және Ғылым Министрлігінің <br>
					2016 жылғы 28 қаңтардағы № 95 бұйрығына сәйкес
				</div>
				<div class="name-wrap">
					<div class="name-lab">Осы сертификат</div>
					<input type="text" class="name-inp" value="<?php echo e($item->fio ?? old('fio')); ?>" name="fio" id="fio">
					<div class="name-hint">(тегі аты, әкесінің аты/фамилия, имя, отчество)</div>
				</div>
				<div class="accept-wrap">
					<div class="accept-lab">Данный сертификат подтверждает, что</div>
					<input type="text" class="accept-inp" value="<?php echo e($item->title ?? old('title')); ?>" name="title" id="title">
					<div class="accept-hint">прошел(ла) курс повышения квалификации на тему / тақырыбында</div>
				</div>
				<div class="clock-wrap">
					<input type="text" class="clock-inp" value="<?php echo e($item->duration ?? old('duration')); ?>" name="duration" id="duration">
					<div class="clock-hint">в объеме часов / сағат көлемінде біліктілікті арттыру курсынан өткенін растайды</div>
				</div>
				<div class="sign-wrap">
					<div class="sign-left">
						<div class="sign-name">ҚҚДБАО</div>
						<div class="sign-wr">
							<div class="sign-lab">Бас директоры:</div>
							<label>
								<input type="text" id="sign-inp" class="sign-inp">
								<div class="sign-hint">қолы/подпись</div>
								<span>/</span>
							</label>
							<label>
								<input type="text" id="sign-inp" name="sign1" class="sign-inp">
								<div class="sign-hint">аты-жөні/Ф.И.О</div>
								<span>/</span>
							</label>
						</div>
					</div>
					<div class="sign-right">
						<div class="sign-name">Директордың ОӘЖ</div>
						<div class="sign-wr">
							<div class="sign-lab">Бас директоры:</div>
							<label>
								<input type="text" id="sign-inp" class="sign-inp">
								<div class="sign-hint">қолы/подпись</div>
								<span>/</span>
							</label>
							<label>
								<input type="text" id="sign-inp" name="sign2" class="sign-inp">
								<div class="sign-hint">аты-жөні/Ф.И.О</div>
								<span>/</span>
							</label>
						</div>
					</div>
				</div>
				<div class="foot">
					<div class="foot-date">
						<div class="foot-labs">
							<div class="foot-lab">Берілген күні</div>
							<div class="foot-lab">Дата выдачи</div>
						</div>
						<div class="foot-wrap">
					<span>“<input type="text" id="foot-inp" value="<?php echo e($item->day ?? old('day')); ?>" name="day" id="day" class="foot-inp foot-inp_d">”</span>
							<input type="text" id="foot-inp" value="<?php echo e($item->month ?? old('month')); ?>" name="month" id="month" class="foot-inp foot-inp_m">
							<div class="foot-year"><?php echo e($item->year ?? old('year')); ?> ж/г</div>
						</div>
					</div>
					<div class="foot-mo">
						М.О.
					</div>
					<div class="foot-reg">
						<div>Тіркеу</div>
						<div>Регистрационный №
							<input type="text" id="foot-inp" alue="" name="reg_number" id="month" class="sign-inp"></div>
					</div>
				</div>

				<input value="<?php echo e($item->year); ?>" type="hidden" name="year" id="year">

			</div>






























































































			<br><br>

			<button type="submit" name="_save_opt" value="create" class="btn btn-primary">Создать сертификат</button>
		</form>

	</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/admin/contestCertificate.blade.php ENDPATH**/ ?>