<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link href="<?php echo e(get_resource_url('/css/dashboard.css')); ?>" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="<?php echo e(route('profile')); ?>">На сайт</a>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <form id="logout-form" style="display: inline-block" method="post" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <a class="nav-link" href="#"
                   onclick="document.getElementById('logout-form').submit(); return false;">Выйти</a>
            </form>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.users' ? 'active' : ''); ?>"
                           href="<?php echo e(route('admin.users')); ?>">
                            <span data-feather="user"></span>
                            Пользователи
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.specialities' ? 'active' : ''); ?>"
                           href="<?php echo e(route('admin.specialities')); ?>">
                            <span data-feather="file-text"></span>
                            Курсы
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.contests' ? 'active' : ''); ?>"
                           href="<?php echo e(route('admin.contests')); ?>">
                            <span data-feather="file-text"></span>
                            Конкурсы
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.news' ? 'active' : ''); ?>"
                           href="<?php echo e(route('admin.news')); ?>">
                            <span data-feather="file-text"></span>
                            Новости
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.library' ? 'active' : ''); ?>"
                           href="<?php echo e(route('admin.library')); ?>">
                            <span data-feather="book-open"></span>
                            Библиотека
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.gid' ? 'active' : ''); ?>"
                           href="<?php echo e(route('admin.gid')); ?>">
                            <span data-feather="book-open"></span>
                            Гид
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.testResults' ? 'active' : ''); ?>"
                           href="<?php echo e(route('admin.testResults')); ?>">
                            <span data-feather="archive"></span>
                            Результаты тестов
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.certificates' ? 'active' : ''); ?>"
                           href="<?php echo e(route('admin.certificates')); ?>">
                            <span data-feather="award"></span>
                            Сертификаты
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.testimonials' ? 'active' : ''); ?>"
                           href="<?php echo e(route('admin.testimonials')); ?>">
                            <span data-feather="smile"></span>
                            Отзывы
                        </a>
                    </li>
					   <li class="nav-item">
                        <a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.edit' ? 'active' : ''); ?>"
                           href="<?php echo e(route('admin.edit')); ?>">
                            <span data-feather="smile"></span>
                            Редактирование сайта
                        </a>
                    </li>
					<li class="nav-item">
                        <a class="nav-link <?php echo e(Route::currentRouteName() === 'admin.gallery' ? 'active' : ''); ?>"
                           href="<?php echo e(route('admin.gallery')); ?>">
                            <span data-feather="smile"></span>
                           Галлерея на главной
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 mb-4">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.26.0/feather.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script src="<?php echo e(get_resource_url('/js/dashboard.js')); ?>"></script>
</body>
</html>
<?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/admin/base.blade.php ENDPATH**/ ?>