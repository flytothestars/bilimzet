<div class="centered <?php echo e(isset($templateNarrow) ? 'width1088' : ''); ?> ">
    <h2><?php echo app('translator')->get('recommendations.title'); ?></h2>
</div>

<div class="favorites <?php echo e(isset($templateNarrow) ? 'width1088' : ''); ?>">
    <div class="centered">
        <div class="navi-parent">
            <div class="swiper-button-next nextFav"><img src="/images/elements/arrow-black-right.svg" alt=""></div>
            <div class="swiper-button-prev prevFav"><img src="/images/elements/arrow-black-left.svg" alt=""></div>
            <div class="swiper-container swiper-favorites">
                <ul class="swiper-wrapper">
                    <?php $__currentLoopData = \App\Data\RecommendedCourses::get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="swiper-slide">
                            <div style="width: 100%; height: 221px; display: flex; align-items: center; justify-content: center;
                                    background: <?php echo e($course->speciality->picture_background); ?>">
                                <img style="max-width: 90px; max-height: 90px;" src="<?php echo e($course->speciality->getUploadedUrl('picture')); ?>" alt="">
                            </div>
                            <div class="category">
                                <?php echo e($course->speciality->getParentCategory()); ?>

                                : <?php echo e($course->speciality->getChildCategory()); ?>

                            </div>
                            <div class="title">
                                <a href="<?php echo e(route('course', ['id' => $course->id])); ?>"><?php echo e($course->title); ?></a>
                            </div>
                            <div class="chars">
                                <span class="lessons"><?php echo app('translator')->get('recommendations.parts'); ?>: <?php echo e($course->parts->count()); ?></span>
                                <span class="hours"> <?php echo e($course->parts->sum('duration_hours')); ?> ч</span>
                            </div>
                            <div class="link">
                                <a href="<?php echo e(route('course', ['id' => $course->id])); ?>"
                                   class="btn blue"><?php echo app('translator')->get('recommendations.go'); ?></a>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/vhosts/kcppk.kz/httpdocs/resources/views/parts/recommendations.blade.php ENDPATH**/ ?>