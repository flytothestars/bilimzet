<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('parts.profileMenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="centered page-title width1088">
        <h1><?php echo app('translator')->get('profile.editing'); ?></h1>
    </div>

    <form method="post" action="<?php echo e(route('updateProfile')); ?>" class="registration centered width1088" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="step1 flex start align-center">
            <div class="num">01</div>
            <a href="#" class="upload-photo">
                <img style="width: 100px; margin-top: -35px;" src="<?php echo e($user->photoUrl); ?>" alt="">
            </a>
            <div class="form">
                <input type="text" name="full_name" value="<?php echo e($user->full_name); ?>" placeholder="<?php echo app('translator')->get('profile.fio'); ?>*">
                <input type="text" name="address" value="<?php echo e($user->address); ?>" placeholder="<?php echo app('translator')->get('profile.address'); ?>*">
                <input type="text" name="company_name" value="<?php echo e($user->company_name); ?>" placeholder="<?php echo app('translator')->get('profile.company'); ?>">
                <label><?php echo app('translator')->get('profile.load'); ?></label>
                <input type="file" name="photo" placeholder="<?php echo app('translator')->get('profile.load'); ?>">
            </div>
        </div>
        <div class="step2 flex between align-center">
            <div class="num">02</div>
            <div class="form">
                <input type="phone" name="phone" value="<?php echo e($user->phone); ?>" placeholder="<?php echo app('translator')->get('profile.phone'); ?>">
                <input type="text" name="position" value="<?php echo e($user->position); ?>" placeholder="<?php echo app('translator')->get('profile.position'); ?>">
                <label><?php echo app('translator')->get('profile.diploma'); ?></label>
                <input type="file" name="diploma" placeholder="<?php echo app('translator')->get('profile.diploma'); ?>">
                <?php if($user->diploma): ?>
                    <p><?php echo app('translator')->get('profile.use'); ?>:
                        <a href="<?php echo e($user->diplomaUrl); ?>" target="_blank"><?php echo app('translator')->get('profile.file'); ?></a>
                    </p>
                <?php endif; ?>
                <?php if($user->status_lector!=1): ?>
                <label for="querylec">Стать лектором</label>
                <input type="checkbox" id="querylec" name="querylec" value="true">
                <?php endif; ?>
            </div>
        </div>

        <?php if($errors->count()): ?>
            <div class="step2" style="color: red; font-size: 18px;">
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <div class="step3 flex between align-center">
            <div class="checkboxes">
                <label>
                    <input name="receive_news_accept" <?php echo e($user->receive_news_accept ? 'checked' : ''); ?> type="checkbox" value="true">
						 <?php echo app('translator')->get('profile.receive'); ?>
                </label>
            </div>
            <button class="btn blue"><?php echo app('translator')->get('profile.save'); ?></button>
        </div>
    </form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/profileEdit.blade.php ENDPATH**/ ?>