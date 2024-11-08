<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Olympic\{
    OlympicController,
    OlympicStartController,
    OlympicQuestionController,
    OlympicEndController
};

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [OlympicController::class, 'index'])->name('olympic');

    Route::get('/getClassificationsList', [OlympicController::class, 'getClassificationsList']);
    Route::get('/getMembersList', [OlympicController::class, 'getMembersList']);
    Route::get('/getSubjectsList', [OlympicController::class, 'getSubjectsList']);
    Route::get('/getCourseDetail', [OlympicController::class, 'getCourseDetail']);

    // Start
    Route::get('/start', [OlympicStartController::class, 'start'])->name('olympic.start');
    Route::post('/getToken', [OlympicStartController::class, 'generateSessionToken']);

    // Questions
    Route::get('/getQuestion', [OlympicQuestionController::class, 'getQuestion']);
    Route::post('/setAnswer', [OlympicQuestionController::class, 'setAnswer']);
    Route::get('/getResults', [OlympicQuestionController::class, 'getResults']);
    Route::get('/end', [OlympicEndController::class, 'index']);

    Route::get('/result/{id}', [OlympicController::class, 'showResult'])->name('olympic.show.result');

    // Download
    Route::get('/download/{id}', [OlympicController::class, 'download'])->name('olympic.download');
});
