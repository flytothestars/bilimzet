<?php $__env->startSection('content'); ?>
    <div class="login flex between align-top width1088 shadow">
        <div class="right" style="flex-basis: 100%;">
            <div class="wrap">
			<div style="width:900px;">
                <div class="title">Покупка части курса</div>
                <?php if(session('errorMessage')): ?>
                    <div style="margin-bottom: 32px;color: red;font-size: 18px;">
                        <?php echo e(session('errorMessage')); ?>

                    </div>
                <?php endif; ?>
                <p>
                    <a href="<?php echo e(route('course', ['id' => $item->course_id])); ?>">Назад</a>
                </p>
                <p>Вы собираетесь купить часть курса <b>"<?php echo e($item->course->title); ?>".</b></p>
                <p>Длительность: <b><?php echo e($item->duration_hours); ?> Ак.ч.</b></p>
                <p>Стоимость: <b><?php echo e($item->price_kzt); ?> Tг.</b></p>
                <br>
                <p>На счету вашего аккаунта: <b><?php echo e($availableMoneyKZT); ?> Tг.</b></p>
                <form id="buyCourseForm" method="post">
                    <?php echo csrf_field(); ?>
                    <?php if($item->price_kzt <= $availableMoneyKZT): ?>
                        <a class="buy" href="#"
                           onclick="document.getElementById('buyCourseForm').submit(); return false;"><b>Купить</b></a>
                    <?php else: ?>
                        <br>
                        <p>
                            Недостаточно денег для покупки.
                            Пополнить счёт можно в <a href="<?php echo e(route('profile')); ?>"><b>профиле</b></a>
                        </p>
                    <?php endif; ?>
                </form>
            </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/buyCoursePart.blade.php ENDPATH**/ ?>