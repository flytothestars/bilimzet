<tr class="row">
    <?php if(!empty($header)): ?>
        <th class="col-4"><?php echo e($key); ?></th>
        <th class="col-8"><?php echo e($value); ?></th>
    <?php else: ?>
        <td class="col-4"><?php echo e($key); ?></td>
        <td class="col-8">
            <?php if(!empty($value)): ?>
                <?php echo e($value); ?>

            <?php elseif(!empty($fileUrl)): ?>
                <a target="_blank" href="<?php echo e($fileUrl); ?>">файл</a>
            <?php endif; ?>
        </td>
    <?php endif; ?>
</tr>
<?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/admin/parts/userViewRow.blade.php ENDPATH**/ ?>