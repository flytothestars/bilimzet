<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\BuyController;
use App\Http\Controllers\Api\TestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/auth/send', [AuthController::class, 'send'])->name('auth.send');
Route::post('/auth/verify', [AuthController::class, 'verify'])->name('auth.verify');

Route::get('/news', [NewsController::class, 'list'])->name('news.list');
Route::get('/news/{id}', [NewsController::class, 'detail'])->name('news.detail');

Route::post('/feedback', [MainController::class, 'feedback'])->name('feedback');

Route::get('/category/list', [CourseController::class, 'getCategory'])->name('category.list');
Route::get('/category', [CourseController::class, 'category'])->name('category');
Route::get('/category/{id}', [CourseController::class, 'courseList'])->name('course.list');
Route::get('/course/part/{id}', [CourseController::class, 'coursePartList'])->name('course.part.list');

Route::get('course/buy/success', [BuyController::class,'success'])->name('course.success.buy');
Route::get('course/buy/result', [BuyController::class,'result'])->name('course.result.buy');

Route::get('/search', [MainController::class, 'search'])->name('search');
Route::get('/search/article', [MainController::class, 'searchArticle'])->name('search.article');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/token', [AuthController::class, 'token'])->name('auth.token');

    Route::post('course/part/buy', [BuyController::class,'generateFrame'])->name('course.part.pay');
    
    Route::get('course/{course_id}/part/{part_id}/module/list', [CourseController::class,'coursePartModuleList'])->name('course.part.module.list');
    Route::get('course/{course_id}/part/{part_id}/module/{module_id}', [CourseController::class,'coursePartModule'])->name('course.part.module');
    Route::get('course/part/module/{module_id}/lecture/list', [CourseController::class,'coursePartModuleLectureList'])->name('course.part.module.lecture.list');
    Route::get('course/part/module/{module_id}/lecture/{lecture_id}', [CourseController::class,'moduleLecture'])->name('course.part.module.lecture');
    Route::get('course/part/module/{module_id}/video', [CourseController::class,'moduleVideo'])->name('course.part.module.video');
    Route::get('course/part/module/{module_id}/present', [CourseController::class,'modulePresent'])->name('course.part.module.present');

    Route::post('process', [CourseController::class,'process'])->name('course.process');
    Route::get('course/process/{part_id}', [CourseController::class,'courseProcess'])->name('course.part.process.');
    Route::get('course/module/process/{module_id}', [CourseController::class,'courseModuleProcess'])->name('course.module.process');

    Route::get('test/get/{part_id}', [TestController::class,'getTest'])->name('course.test.get');
    Route::post('test/send', [TestController::class,'sendResultTest'])->name('course.test.send');


    Route::get('/profile/get', [ProfileController::class, 'get'])->name('profile.get');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/certificate', [ProfileController::class, 'certificate'])->name('profile.certificate');
    Route::get('/profile/course', [ProfileController::class, 'course'])->name('profile.course');
    Route::get('/profile/notification', [ProfileController::class, 'notification'])->name('profile.notification');




    Route::get('article/list', [ArticleController::class, 'index'])->name('article.index');
    Route::get('article/{id}', [ArticleController::class, 'show'])->name('article.show');
    Route::post('article/create', [ArticleController::class, 'create'])->name('article.create');
    Route::get('article/list/user', [ArticleController::class, 'showUserArticle'])->name('article.user');


});