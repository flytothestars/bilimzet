<?php $__env->startSection('content'); ?>

	<h2 class="mt-4 mb-3">Редактирование страниц сайта</h2>
	<?php if(\Session::has('message')): ?>
		<div class="alert alert-success" role="alert">
			<?php echo \Session::get('message'); ?>

		</div>
	<?php endif; ?>

	<form action="<?php echo e(route('admin.edit')); ?>" id='select_predmet_form' method='GET'>
		<table>
			<tr>
				<td>
					<select name="page_filt" onChange="document.getElementById('select_predmet_form').submit();">
						<option value="footer" <?php echo e($page_filt == 'footer' ? 'selected' : ''); ?>>Нижняя часть сайта, footer
						</option>
						<option value="contacts" <?php echo e($page_filt == 'contacts' ? 'selected' : ''); ?>>Страница контакты, общие, до
							формы отправки заявки
						</option>
						<option value="contacts_stuff" <?php echo e($page_filt == 'contacts_stuff' ? 'selected' : ''); ?>>Страница
							контакты, контакты сотрудников
						</option>
						<option value="about_text" <?php echo e($page_filt == 'about_text' ? 'selected' : ''); ?>>Страница О компании
						</option>
						<option value="about_text_main" <?php echo e($page_filt == 'about_text_main' ? 'selected' : ''); ?>>Главная, текст
							о Центре
						</option>
					</select>
				</td>
			</tr>
		</table>
	</form>

	<form action="<?php echo e(route('admin.edit.store')); ?>" id='update_page' method='post'>
		<?php echo csrf_field(); ?> <!-- <?php echo e(csrf_field()); ?> -->
		<input type="hidden" name="page_filt" value="<?php echo e($page_filt); ?>">
			<div class="title">ru</div>
		<textarea class="summernote" name="pages_text" style="width:700px;height:550px"><?php echo e($content); ?></textarea>
		<br>
			<div class="title">kz</div>
		<textarea class="summernote" name="pages_text_kz" style="width:700px;height:550px"><?php echo e($content_kz); ?></textarea>
		<br>
		<input type="button" style="background-color:#1ab394;border-color:#1ab394;color:#FFFFFF;border-radius:3px;font-size:14px;font-weight:400;line-height:1.42857143;text-align:center;vertical-align:middle;width:330px;margin:0px;height:40px;cursor:pointer"
				 onClick="document.getElementById('update_page').submit();" value="Сохранить Страницу">
	</form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/admin/edit.blade.php ENDPATH**/ ?>