<?php $__env->startSection('content'); ?>

    <div class="centered page-title width1088">
        <h1><?php echo app('translator')->get('auth.reg'); ?></h1>
    </div>

    <form method="post" class="registration centered width1088" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="step1 flex start align-center">
            <div class="num">01</div>
            <a href="#" class="upload-photo"><img src="/images/elements/add-photo.svg" alt=""></a>
            <div class="form">
                <input type="text" name="full_name" value="<?php echo e(@old("full_name")); ?>" placeholder="<?php echo app('translator')->get('auth.fio'); ?>*">
                <input type="text" name="address" value="<?php echo e(@old("address")); ?>" placeholder="<?php echo app('translator')->get('auth.address'); ?>*">
                <input type="text" name="company_name" value="<?php echo e(@old("company_name")); ?>" placeholder="<?php echo app('translator')->get('auth.company_name'); ?>">
                <label><?php echo app('translator')->get('auth.load'); ?></label>
                <input type="file" name="photo" placeholder="<?php echo app('translator')->get('auth.load'); ?>">
            </div>
        </div>
        <div class="step2 flex between align-center">
            <div class="num">02</div>
            <div class="form">
                <input type="password" name="password" placeholder="<?php echo app('translator')->get('auth.password'); ?>">
                <input type="password" name="password_confirmation" placeholder="<?php echo app('translator')->get('auth.confirmation'); ?>">
            </div>
            <div class="form">
                <input type="phone" name="phone" value="<?php echo e(@old("phone")); ?>" placeholder="<?php echo app('translator')->get('auth.phone'); ?>">
                <input type="email" name="email" value="<?php echo e(@old("email")); ?>" placeholder="E-mail*">
                <input type="text" name="position" value="<?php echo e(@old("position")); ?>" placeholder="<?php echo app('translator')->get('auth.position'); ?>">
                <label><?php echo app('translator')->get('auth.diploma'); ?></label>
                <input type="file" name="diploma" placeholder="<?php echo app('translator')->get('auth.diploma'); ?>"><br>
                <label for="querylec">Стать лектором</label>
                <input type="checkbox" id="querylec" name="querylec" value="true">
            </div>
        </div>

        <?php if($errors->count()): ?>
            <div class="step2" style="color: red; font-size: 18px;">
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <div class="step3 flex between align-center">
            <div class="checkboxes">
                <label><input name="data_process_accept" <?php echo e(@old('data_process_accept') ? 'checked' : ''); ?>

                              type="checkbox"> <?php echo app('translator')->get('auth.consent'); ?>*</label>
                <label>
                    <input name="receive_news_accept" <?php echo e(@old('receive_news_accept') ? 'checked' : ''); ?>

                           type="checkbox" value="true">
						 <?php echo app('translator')->get('auth.get_news'); ?>
                </label>
            </div>

			<p><a href="/politic.docx" target="_blank"><?php echo app('translator')->get('auth.policy'); ?></a><br>
            <a href="/user_soglas.rtf" target="_blank"><?php echo app('translator')->get('auth.agreement'); ?></a></p>

            <button class="btn blue"><?php echo app('translator')->get('auth.create'); ?></button>
        </div>
    </form>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/reg.blade.php ENDPATH**/ ?>