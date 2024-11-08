<?php $__env->startSection('content'); ?>
    <div class="centered page-title width1088">
        <h1>Регистрация</h1>
    </div>

    <form method="post" class="registration centered width1088" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="step1 flex start align-center">
            <div class="num">01</div>
            <a href="#" class="upload-photo"><img src="/images/elements/add-photo.svg" alt=""></a>
            <div class="form">
                <input type="text"
                       name="full_name"
                       value="<?php echo e(@old("full_name")); ?>"
                       placeholder="ФИО участника*">
                <input type="text"
                       name="address"
                       value="<?php echo e(@old("address")); ?>"
                       placeholder="Адрес*">
                <input type="text"
                       name="company_name"
                       value="<?php echo e(@old("company_name")); ?>"
                       placeholder="Название компании, место работы">
                <label>Загрузить фото</label>
                <input type="file"
                       name="photo" placeholder="Загрузить фото">
            </div>
        </div>
        <div class="step2 flex between align-center">
            <div class="num">02</div>
            <div class="form">
                <input type="password" name="password" placeholder="Пароль">
                <input type="password" name="password_confirmation" placeholder="Подтвердить пароль">
            </div>
            <div class="form">
                <input type="phone" name="phone" value="<?php echo e(@old("phone")); ?>" placeholder="Контактный телефон">
                <input type="email" name="email" value="<?php echo e(@old("email")); ?>" placeholder="E-mail*">
                <input type="text" name="position" value="<?php echo e(@old("position")); ?>" placeholder="Должность">
                <label>Диплом участника</label>
                <input type="file" name="diploma" placeholder="Диплом участника">
            </div>
        </div>

        <?php if($errors->count()): ?>
            <div class="step2" style="color: red; font-size: 18px;">
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <div class="step3 flex between align-center">
            <div class="checkboxes">
                <label><input name="data_process_accept"
                              <?php echo e(@old('data_process_accept') ? 'checked' : ''); ?>

                              type="checkbox"> Согласие на обработку данных*</label>
                <label>
                    <input name="receive_news_accept"
                           <?php echo e(@old('receive_news_accept') ? 'checked' : ''); ?>

                           type="checkbox" value="true">
                    Получать новости об акциях, скидках и т.д.
                </label>
            </div>

			<p><a href="/politic.docx" target="_blank">Политика конфеденциальности</a><br>
                        <a href="/user_soglas.rtf" target="_blank">Пользовательское соглашение</a></p>

            <button class="btn blue">Создать аккаунт</button>
        </div>
    </form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/reg.blade.php ENDPATH**/ ?>