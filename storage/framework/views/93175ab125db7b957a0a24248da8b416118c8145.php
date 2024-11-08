<!doctype html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<title>Dashboard</title>

	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

	<link href="<?php echo e(mix('/css/admin.min.css')); ?>" rel="stylesheet">
</head>
<body>

	<?php echo $__env->make('admin.parts.top-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<div class="container-fluid">
		<div class="row">

			<?php echo $__env->make('admin.parts.sidebar-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 mb-4">
				<?php echo $__env->yieldContent('content'); ?>
			</main>
		</div>
	</div>

	<script src="<?php echo e(mix('/js/admin.min.js')); ?>"></script>
	<?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html>
<?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/layouts/admin.blade.php ENDPATH**/ ?>