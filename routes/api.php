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
use App\Http\Controllers\Api\CommentController;

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
Route::post('/feedback', [MainController::class, 'feedback'])->name('feedback');

Route::prefix('{lang}')->middleware('locale')->group(function () {
    Route::get('/news', [NewsController::class, 'list'])->name('news.list');
    Route::get('/news/{id}', [NewsController::class, 'detail'])->name('news.detail');
    
    Route::get('article/list', [ArticleController::class, 'index'])->name('article.index');
    Route::get('article/{id}', [ArticleController::class, 'show'])->name('article.show');
    
    Route::get('/category/list', [CourseController::class, 'getCategory'])->name('category.list');
    Route::get('/category', [CourseController::class, 'category'])->name('category');
    Route::get('/category/{id}', [CourseController::class, 'courseList'])->name('course.list');
    Route::get('/course/part/{id}', [CourseController::class, 'coursePartList'])->name('course.part.list');
    Route::get('/popular/course', [CourseController::class, 'coursePopular'])->name('course.popular.list');

});

Route::get('course/buy/success', [BuyController::class,'success'])->name('course.success.buy');
Route::get('course/buy/result', [BuyController::class,'result'])->name('course.result.buy');

Route::get('/search', [MainController::class, 'search'])->name('search');
Route::get('/search/article', [MainController::class, 'searchArticle'])->name('search.article');

        
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('{lang}')->middleware('locale')->group(function () {
        
        Route::get('course/{course_id}/part/{part_id}/module/list', [CourseController::class,'coursePartModuleList'])->name('course.part.module.list');
        Route::get('module/{module_id}/lesson/{lesson_id}', [CourseController::class,'coursePartModule'])->name('course.part.module');
        Route::get('lesson/{lesson_id}/lecture/list', [CourseController::class,'coursePartModuleLectureList'])->name('course.part.module.lecture.list');
        Route::get('lesson/{lesson_id}/lecture/{lecture_id}', [CourseController::class,'moduleLecture'])->name('course.part.module.lecture');
        Route::get('lesson/{lesson_id}/video', [CourseController::class,'moduleVideo'])->name('course.part.module.video');
        Route::get('lesson/{lesson_id}/present', [CourseController::class,'modulePresent'])->name('course.part.module.present');

        Route::get('test/get/course/{course_id}/part/{part_id}', [TestController::class,'getTest'])->name('course.test.get');

        Route::get('/profile/certificate', [ProfileController::class, 'certificate'])->name('profile.certificate');
        Route::get('/profile/course', [ProfileController::class, 'course'])->name('profile.course');
        Route::get('/profile/notification', [ProfileController::class, 'notification'])->name('profile.notification');        

        Route::get('article/list/user', [ArticleController::class, 'showUserArticle'])->name('article.user');    

        Route::get('article/comment/list/{article_id}', [CommentController::class, 'list'])->name('article.comment.list');
        Route::post('article/comment/create', [CommentController::class, 'create'])->name('article.comment.create');
        Route::get('article/comment/delete/{comment_id}', [CommentController::class, 'delete'])->name('article.comment.delete');

        Route::get('course/comment/list/{course_id}/{part_id}', [CommentController::class, 'courseList'])->name('course.comment.list');
    });
    Route::get('progress/course/{course_id}/{part_id}', [CourseController::class,'courseProcess'])->name('course.part.process.');
    Route::get('progress/lesson/{module_id}/{lesson_id}', [CourseController::class,'courseModuleLessonProcess'])->name('course.module.process');

    Route::get('/profile/get', [ProfileController::class, 'get'])->name('profile.get');
    Route::post('course/comment/create', [CommentController::class, 'courseCreate'])->name('course.comment.create'); 
    Route::post('article/comment/edit', [CommentController::class, 'edit'])->name('article.comment.edit');
    Route::post('article/create', [ArticleController::class, 'create'])->name('article.create');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('test/send', [TestController::class,'sendResultTest'])->name('course.test.send');
    Route::post('process', [CourseController::class,'process'])->name('course.process');
    Route::post('course/part/buy', [BuyController::class,'generateFrame'])->name('course.part.pay');
    Route::get('/auth/token', [AuthController::class, 'token'])->name('auth.token');
    Route::get('/profile/document/delete/{document_id}', [ProfileController::class, 'deleteDocument'])->name('profile.document.delete');
    Route::post('/profile/notification/delete', [ProfileController::class, 'deleteNotification'])->name('profile.notification.delete');
    Route::post('/profile/notification/update', [ProfileController::class, 'updateNotification'])->name('profile.notification.update');

});