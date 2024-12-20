<?php

declare(strict_types=1);

use App\Models\CourseTestResult;
use App\Orchid\Screens\Examples\ExampleActionsScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleGridScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;
use App\Orchid\Screens\News\NewsScreen;
use App\Orchid\Screens\Article\ArticleScreen;
use App\Orchid\Screens\Category\CategoryScreen;
use App\Orchid\Screens\CourseSpeciality\CourseSpecialityScreen;
use App\Orchid\Screens\Course\CourseScreen;
use App\Orchid\Screens\CoursePart\CoursePartScreen;
use App\Orchid\Screens\CourseTest\CourseTestScreen;
use App\Orchid\Screens\CourseQuestion\CourseQuestionScreen;
use App\Orchid\Screens\CourseModule\CourseModuleScreen;
use App\Orchid\Screens\CourseTestResult\CourseTestResultScreen;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/


Route::screen('news', NewsScreen::class)
    ->name('platform.news.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Новости'), route('platform.news.list')));


Route::screen('article', ArticleScreen::class)
    ->name('platform.article.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Статья'), route('platform.article.list')));
 
Route::screen('category', CategoryScreen::class)
    ->name('platform.category.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Категория'), route('platform.category.list')));

Route::screen('course_test_result', CourseTestResultScreen::class)
    ->name('platform.course_test_result.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Сертификат'), route('platform.course_test_result.list')));


Route::screen('/settings/form/basic', \App\Orchid\Screens\Setting\SettingFieldScreen::class)->name('platform.settings.basic');
Route::screen('/settings/form/advanced', \App\Orchid\Screens\Setting\SettingsFieldsAdvancedScreen::class)->name('platform.settings.advanced');

Route::screen('course_speciality', CourseSpecialityScreen::class)
    ->name('platform.course_speciality.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Специализации'), route('platform.course_speciality.list')));
 
Route::screen('course', CourseScreen::class)
    ->name('platform.course.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Специализации'), route('platform.course_speciality.list'))
        ->push(__('Курс'), route('platform.course.list')));

Route::screen('course_part', CoursePartScreen::class)
    ->name('platform.course_part.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Специализации'), route('platform.course_speciality.list'))
        ->push(__('Курс '), route('platform.course.list', ['courseSpeciality' => request()->get('courseSpeciality')]))
        ->push(__('Части курса '), route('platform.course_part.list')));
    
Route::screen('course_test', CourseTestScreen::class)
    ->name('platform.course_test.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Специализации'), route('platform.course_speciality.list'))
        ->push(__('Курс '), route('platform.course.list', ['courseSpeciality' => request()->get('courseSpeciality')]))
        ->push(__('Тест '), route('platform.course_test.list')));
        
Route::screen('course_question', CourseQuestionScreen::class)
    ->name('platform.course_question.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Специализации'), route('platform.course_speciality.list'))
        ->push(__('Курс '), route('platform.course.list', ['courseSpeciality' => request()->get('courseSpeciality')]))
        ->push(__('Тест '), route('platform.course_test.list', ['course' => request()->get('course'), 'courseSpeciality' => request()->get('courseSpeciality')]))
        ->push(__('Вопросы '), route('platform.course_question.list')));

Route::screen('course_module', CourseModuleScreen::class)
    ->name('platform.course_module.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Специализации'), route('platform.course_speciality.list'))
        ->push(__('Курс '), route('platform.course.list', ['courseSpeciality' => request()->get('courseSpeciality')]))
        ->push(__('Части курса'), route('platform.course_test.list', ['course' => request()->get('course'), 'courseSpeciality' => request()->get('courseSpeciality')]))
        ->push(__('Модули '), route('platform.course_module.list')));
    
        // ===========================


// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Example Screen'));

Route::screen('/examples/form/fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('/examples/form/advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');
Route::screen('/examples/form/editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
Route::screen('/examples/form/actions', ExampleActionsScreen::class)->name('platform.example.actions');

Route::screen('/examples/layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
Route::screen('/examples/grid', ExampleGridScreen::class)->name('platform.example.grid');
Route::screen('/examples/charts', ExampleChartsScreen::class)->name('platform.example.charts');
Route::screen('/examples/cards', ExampleCardsScreen::class)->name('platform.example.cards');

//Route::screen('idea', Idea::class, 'platform.screens.idea');
