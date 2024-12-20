<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\ProfileController;

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

Route::get('/specialities', [CourseController::class, 'specialities'])->name('specialities');


Route::get('sbp', [NewsController::class, 'sbp'])->name('news.sbp');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/token', [AuthController::class, 'token'])->name('auth.token');

    Route::get('/profile/get', [ProfileController::class, 'get'])->name('profile.get');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');



    Route::get('article/list', [ArticleController::class, 'index'])->name('article.index');
    Route::get('article/{id}', [ArticleController::class, 'show'])->name('article.show');
    Route::post('article/create', [ArticleController::class, 'create'])->name('article.create');
    Route::get('article/list/user', [ArticleController::class, 'showUserArticle'])->name('article.user');


});