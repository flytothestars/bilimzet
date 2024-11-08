<?php $__env->startSection('content'); ?>
   

   <div class="text-block-section centered page-title width1088">
       

       <div class="top-olimpic-text">
           <div class="centered pate-title width1088">
               <div class="top-info">
                   <h1 class="olimp-title"><?php echo app('translator')->get('olympics.title'); ?></h1>

                   <div class="top-block-info flex between align-center">
                       <div>
                           <?php echo app('translator')->get('olympics.top_block_one'); ?>
                       </div>
                       <div class="price-text"><?php echo app('translator')->get('olympics.price'); ?></div>
                       <lottie-player src="https://assets3.lottiefiles.com/packages/lf20_xcpxkfnu.json" background="transparent"  speed="1"  style="width: 300px; height: 250px;"  loop autoplay></lottie-player>
                   </div>
                   <div class="bottom-info-block flex align-center between">
                       <?php echo app('translator')->get('olympics.middle_text'); ?>
                   </div>
               </div>
           </div>
           <h2><?php echo app('translator')->get('olympics.requires'); ?></h2>
           <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_kcixdxqk/animations/lf30_editor_opilardo.json" class="olimp-lottie-player second-block" background="transparent"  speed="1"  style="width: 300px; height: 250px;"  loop autoplay></lottie-player>
           <?php echo app('translator')->get('olympics.requires_block'); ?>
       </div>
       <div class="olympics width1088 flex between wrap align-top" id="app">
          <div class="box-shadow p-30 width1088 white-background">
             <?php if($currentSession): ?>
                  <p class="olympic-alert info">
                      <?php echo app('translator')->get('olympics.session_exist'); ?><br/>
                      <a href="<?php echo e(route('olympic.start') . '?token=' . $currentSession->token); ?>"><?php echo e(route('olympic.start') . '?token=' . $currentSession->token); ?></a>
                  </p>
             <?php else: ?>
                  <olympic-main-list></olympic-main-list>
             <?php endif; ?>
          </div>
       </div>
   </div>

   <?php $__env->startPush('scripts'); ?>
      <script src="<?php echo e(mix('/js/app.min.js')); ?>"></script>
      <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
   <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/olympics/index.blade.php ENDPATH**/ ?>