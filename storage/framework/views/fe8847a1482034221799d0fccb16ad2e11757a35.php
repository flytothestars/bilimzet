<?php $__env->startSection('content'); ?>
    <h2 class="mt-4 mb-3">Просмотр пользователя</h2>
    <div>
        <table class="table">
            <thead>
            <?php echo $__env->make('admin.parts.userViewRow', [
                'key' => 'Поле',
                'value' => 'Значение',
                'header' => true
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </thead>
            <tbody>
            <?php echo $__env->make('admin.parts.userViewRow', [
                'key' => 'ФИО',
                'value' => $item->full_name
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin.parts.userViewRow', [
                'key' => 'Остаток на счёте (тенге)',
                'value' => $item->money_amount_kzt
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin.parts.userViewRow', [
                'key' => 'Адрес',
                'value' => $item->address
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin.parts.userViewRow', [
                'key' => 'Название компании, место работы',
                'value' => $item->company_name
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin.parts.userViewRow', [
                'key' => 'Фото',
                'fileUrl' => empty($item->photo) ? '' : $item->photoUrl
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin.parts.userViewRow', [
                'key' => 'Контактный телефон',
                'value' => $item->phone
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin.parts.userViewRow', [
                'key' => 'E-mail',
                'value' => $item->email
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin.parts.userViewRow', [
                'key' => 'Должность',
                'value' => $item->position
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin.parts.userViewRow', [
                'key' => 'Диплом участника',
                'fileUrl' => empty($item->diploma) ? '' : $item->diplomaUrl
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin.parts.userViewRow', [
                'key' => 'Получать новости об акциях, скидках и т.д.',
                'value' => $item->receive_news_accept ? 'Да' : 'Нет'
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/admin/userView.blade.php ENDPATH**/ ?>