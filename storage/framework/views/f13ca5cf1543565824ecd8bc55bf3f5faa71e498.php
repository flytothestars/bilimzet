<?php $__env->startSection('content'); ?>

    <div class="login flex between align-top width1088 shadow">
        <div class="right" style="flex-basis: 100%;">
            <div class="wrap">
                <div class="title"><?php echo app('translator')->get('auth.password_change'); ?></div>
                <form method="post">
                    <?php echo csrf_field(); ?>
                    <input type="password" name="current_password" placeholder="<?php echo app('translator')->get('auth.password_change_current'); ?>">
                    <input type="password" name="new_password" placeholder="<?php echo app('translator')->get('auth.password_change_new'); ?>">
                    <input type="password" name="new_password_confirmation" placeholder="<?php echo app('translator')->get('auth.password_change_confirmation'); ?>">
                    <?php if($errors->count()): ?>
                        <div class="step2" style="color: red; font-size: 16px; margin-top: 16px">
                            <?php echo e($errors->first()); ?>

                        </div>
                    <?php endif; ?>
                    <button type="submit"><?php echo app('translator')->get('auth.password_change_do'); ?></button>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/passwordEdit.blade.php ENDPATH**/ ?>