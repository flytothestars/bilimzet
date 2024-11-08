<?php $__env->startSection('content'); ?>

	<div class="centered page-title width1088">
		<h1><?php echo app('translator')->get('library.title'); ?> <span class="doc-title"><?php echo e($item->title); ?></span></h1>
	</div>

	<div class="document-opened width1088">
		<div class="doc-body">
			<div class="top flex between align-center">
				<div class="left">
					<div class="doc-type"><img src="/images/files/word.png" alt=""></div>
					<div class="doc-title"><?php echo e($item->title); ?></div>
					<div class="doc-extension docx"><?php echo e($item->document_extension); ?></div>
				</div>
				<div class="right">
					<a href="<?php echo e($item->documentUrl); ?>" target="_blank" download
						class="btn download shadow blue"><?php echo app('translator')->get('library.download'); ?></a>
				</div>
			</div>
			<div class="text">
				<p><?php echo e($item->text); ?></p>
			</div>
		</div>
		<div class="bottom flex between align-center">
			<div class="author flex start align-center">
				<p><?php echo app('translator')->get('library.author'); ?></p>
				<img style="max-width: 28px; max-height: 28px" src="<?php echo e($item->author->photoUrl); ?>" alt="">
				<a href="<?php echo e(route('profileUser', [ 'id' => $item->author->id ])); ?>"
					class="author-name"><?php echo e($item->author->full_name); ?></a>
			</div>
			<a href="#" class="readmore"><?php echo app('translator')->get('library.more'); ?></a>
			<div class="char flex end align-center">
				<span class="saves">1</span>
				<span class="date"><?php echo e($item->created_at->format('d.m.Y')); ?></span>
			</div>
		</div>
	</div>

	<div class="themes centered">
		<h2>Похожие темы</h2>
		<?php $__currentLoopData = $similars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<div class="row">
				<div class="left flex between align-top">
					<div class="extension"><span class="docx"><?php echo e($item->document_extension); ?></span></div>
					<div class="doc">
						<div class="doc-title"><?php echo e($item->title); ?></div>
						<div class="flex start align-center">
							<span class="saves">1</span>
							<span class="date"><?php echo e($item->created_at->format('d.m.Y')); ?></span>
						</div>
					</div>
				</div>
				<div class="right flex between align-center">
					<div class="author">
						<p><?php echo app('translator')->get('library.author'); ?></p>
						<img style="max-width: 28px; max-height: 28px;" src="<?php echo e($item->author->photoUrl); ?>" alt="">
						<a href="<?php echo e(route('profileUser', [ 'id' => $item->author->id ])); ?>" class="author-name"><?php echo e($item->author->full_name); ?></a>
					</div>
					<div class="link">
						<a href="<?php echo e(route('showLibraryItem', [ 'id' => $item->id ])); ?>" class="btn transparent"><?php echo app('translator')->get('library.go'); ?></a>
					</div>
				</div>
			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/libraryItem.blade.php ENDPATH**/ ?>