<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LocaleMiddleware;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Admin\ContestsController as AContestsController;

Route::get('setlocale/{lang}', [ LocaleController::class, 'set' ])->name('setlocale');

Route::group(['prefix' => LocaleMiddleware::getLocale()], function() {

	Route::get('/', 'MainController@index')->name('index');
	Route::get('/about', 'MainController@about')->name('about');
	Route::get('/contacts', 'MainController@contacts')->name('contacts');

//Страница пользователей
	Route::get('/user/{id}', 'ProfileController@user')->name('profileUser');

	Route::get('/specialities', 'CourseSpecialitiesController@index')->name('specialities');
	Route::get('/specialities/{id}', 'CourseSpecialitiesController@show')->name('speciality');
	Route::get('/courses/{id}', 'CoursesController@show')->name('course');

// Конкурсы фронт
	Route::get('/contests', 'ContestsController@index')->name('contests');
	Route::get('/contest/{id}', 'ContestsController@show')->name('contest');

// Новости фронт
	Route::get('/news', 'NewsController@index')->name('news');
	Route::get('/new/{id}', 'NewsController@show')->name('newPost');

	Route::get('/search', 'SearchController@index')->name('search');

//CHAT
	Route::post('/chat/{chatroom}', 'ChatController@store')->name('chat.store');
	Route::get('/chat/fetch/{chatroom}', 'ChatController@fetch')->name('chat.fetch');
	Route::post('/courses/{id}/testimonials', 'CoursesController@storeCourseTestimonial')->name('storeCourseTestimonial');
	Route::group(['middleware' => ['auth']], function () {
		Route::get('/profile', 'ProfileController@index')->name('profile');
		Route::get('/profile/edit', 'ProfileController@edit')->name('editProfile');
		Route::post('/profile/update', 'ProfileController@update')->name('updateProfile');

		Route::post('/profile/freeMoney', 'ProfileController@freeMoney')->name('freeMoney');

		Route::get('/profile/password', 'ProfileController@editPassword')->name('editPassword');
		Route::post('/profile/password', 'ProfileController@updatePassword')->name('updatePassword');

		Route::post('/logout', 'AuthController@logout')->name('logout');

		Route::get('/library', 'LibraryController@index')->name('library');
		Route::get('/library/item/{id}', 'LibraryController@show')->name('showLibraryItem');
		Route::get('/library/apply', 'LibraryController@applyItem')->name('applyLibraryItem');
		Route::post('/library/apply/add', 'LibraryController@doApplyItem')->name('doApplyItem');

		Route::get('/lecture/item/{id}', 'LectureController@show')->name('showLectureItem');
		Route::get('/lecture/apply', 'LectureController@applyItem')->name('applyLectureItem');
		Route::post('/lecture/apply/add', 'LectureController@doApplyItem')->name('doApplyLecItem');

		Route::get('/profile/contests', 'ProfileContestsController@index')->name('myContests');
		Route::post('/profile/contests/{id}', 'ProfileContestsController@store')->name('myContests.store');
		Route::post('/profile/contests/delete-file/{id}', 'ProfileContestsController@deleteFile')->name('myContests.deleteFile');
		Route::post('/profile/contests/delete-video/{id}', 'ProfileContestsController@deleteVideo')->name('myContests.deleteVideo');

		Route::get('/tests', 'CourseTestsController@index')->name('myTests');
		Route::get('/tests/{id}', 'CourseTestsController@view')->name('viewTest');
		Route::post('/tests/{id}/answer', 'CourseTestsController@step')->name('stepTest');
		Route::get('/tests/{id}/done', 'CourseTestsController@done')->name('doneTest');
		Route::post('/tests/{id}/timeout', 'CourseTestsController@timeout')->name('timeoutTest');


		Route::get('/courses/{courseId}/parts/{partId}/buy', 'CoursesController@buyPart')->name('buyCoursePart');
		Route::post('/courses/{courseId}/parts/{partId}/buy', 'CoursesController@doBuyPart')->name('doBuyCoursePart');
		Route::get('/courses/{courseId}/parts/{partId}/buyThanks', 'CoursesController@buyPartThanks')->name('buyCoursePartThanks');
		Route::get('/courses/{courseId}/parts/{partId}/download', 'CoursesController@downloadPartFile')->name('downloadCoursePartFile');

		Route::post('/contests/{id}/testimonials', 'ContestsController@storeContestTestimonial')->name('storeContestTestimonial');
		Route::get('/contests/{contestId}/parts/{partId}/buy', 'ContestsController@buyPart')->name('buyContestPart');
		Route::post('/contests/{contestId}/parts/{partId}/buy', 'ContestsController@doBuyPart')->name('doBuyContestPart');
		Route::get('/contests/{contestId}/parts/{partId}/buyThanks', 'ContestsController@buyPartThanks')->name('buyContestPartThanks');
		Route::get('/contests/{contestId}/parts/{partId}/download', 'ContestsController@downloadPartFile')->name('downloadContestPartFile');

		Route::get('/certificates', 'CertificatesController@index')->name('certificates');
		Route::get('/handouts', 'HandoutsController@index')->name('handouts');

		Route::get('/notifications', 'NotificationsController@index')->name('notifications');
	});

	Route::group(['middleware' => ['guest']], function () {
		Route::get('/login', 'AuthController@loginIndex')->name('login');
		Route::post('/login', 'AuthController@doLogin')->name('doLogin');

		Route::get('/reg', 'AuthController@regIndex')->name('reg');
		Route::post('/reg', 'AuthController@doReg')->name('doReg');
	});

});

Route::group(['middleware' => ['is_admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
	Route::get('/', 'Admin\DashboardController@index')->name('index');

	Route::get('/support', 'Admin\SupportController@index')->name('support');
	Route::get('/chat/{chatroom}', 'Admin\SupportController@chat')->name('chat');
	Route::post('/chat/{chatroom}', 'Admin\SupportController@store')->name('chat.store');

	Route::get('/edit', 'Admin\EditController@index')->name('edit');
	Route::post('/edit', 'Admin\EditController@store')->name('edit.store');

	Route::get('/gallery', 'Admin\GalleryController@index')->name('gallery');
	Route::post('/gallery', 'Admin\GalleryController@store')->name('gallery.store');
	Route::post('/gallery/delete', 'Admin\GalleryController@deletePhoto')->name('gallery.delete');

	Route::get('/letters', 'Admin\LettersController@index')->name('letters');
	Route::post('/letters', 'Admin\LettersController@store')->name('letters.store');
	Route::post('/letters/delete', 'Admin\LettersController@deletePhoto')->name('letters.delete');

	//Гид
	Route::get('/gid', 'Admin\DashboardController@gid')->name('gid');
	Route::post('/gid/update', 'Admin\DashboardController@update')->name('updateGid');

	Route::get('/guides', 'Admin\GuideController@index')->name('guides');
	Route::get('/guides/create', 'Admin\GuideController@create')->name('guide.create');
	Route::get('/guides/{id}', 'Admin\GuideController@edit')->name('guide.edit');
	Route::post('/guides/store', 'Admin\GuideController@store')->name('guide.store');
	Route::post('/guides/update/{id}', 'Admin\GuideController@update')->name('guide.update');
	Route::post('/guides/{id}', 'Admin\GuideController@destroy')->name('guide.destroy');

	// Новости бек
	Route::get('/new/create', 'Admin\NewsController@create')->name('createNew');
	Route::get('/news', 'Admin\NewsController@index')->name('news');
	Route::get('/new/{id}', 'Admin\NewsController@edit')->name('newPost');
	Route::post('/new/store', 'Admin\NewsController@store')->name('storeNew');
	Route::post('/new/update/{id}', 'Admin\NewsController@update')->name('updateNew');
	Route::post('/new/{id}', 'Admin\NewsController@destroy')->name('destroyNew');

	Route::get('/library', 'Admin\LibraryController@index')->name('library');
	Route::get('/library/{id}/edit', 'Admin\LibraryController@edit')->name('editLibraryItem');
	Route::post('/library/{id}/update', 'Admin\LibraryController@update')->name('updateLibraryItem');
	Route::post('/library/{id}/destroy', 'Admin\LibraryController@destroy')->name('destroyLibraryItem');

	Route::get('/lectures', 'Admin\LectureController@index')->name('lectures');
	Route::get('/lectures/{id}/edit', 'Admin\LectureController@edit')->name('editLecturesItem');
	Route::post('/lectures/{id}/update', 'Admin\LectureController@update')->name('updateLecturesItem');
	Route::post('/lectures/{id}/destroy', 'Admin\LectureController@destroy')->name('destroyLecturesItem');

	Route::get('/querylec', 'Admin\QuerylecController@index')->name('querylec');
	Route::get('/querylec/{id}', 'Admin\UsersController@view')->name('viewUser');
	Route::post('/querylec/{id}/addLec', 'Admin\QuerylecController@addLec')->name('addLec');
	Route::post('/querylec/{id}/delLec', 'Admin\QuerylecController@delLec')->name('delLec');
	Route::get('/users', 'Admin\UsersController@index')->name('users');
	Route::get('/users/{id}', 'Admin\UsersController@view')->name('viewUser');
	Route::post('/users/{id}/destroy', 'Admin\UsersController@destroy')->name('destroyUser');
	Route::post('/exportUsers', 'Admin\UsersController@exportAll')->name('exportUsers');

	// contests
	Route::get('/contests', [ AContestsController::class, 'index' ])->name('contests');
	Route::get('/contests/create', [ AContestsController::class, 'create' ])->name('createContest');
	Route::post('/contests/store', [ AContestsController::class, 'store' ])->name('storeContest');
	Route::get('/contest/{contest}/edit', [ AContestsController::class, 'edit' ])->name('editContest');
	Route::post('/contests/{contest}/update', [ AContestsController::class, 'update' ])->name('updateContest');
	Route::post('/contests/{contest}/destroy', [ AContestsController::class, 'destroy' ])->name('destroyContest');
	Route::get('/contests/{contest}/certificates', [ AContestsController::class, 'certificates' ])->name('contestsCertificates');
	Route::post('/contests/{contest}/certificates', [ AContestsController::class, 'updateCertificates' ])->name('updateCertificateContest');
	// parts
	Route::get('/contests/{contest}/parts', [ AContestsController::class, 'parts' ])->name('contestParts');
	Route::get('/contests/{contest}/parts/create', [ AContestsController::class, 'createPart' ])->name('createContestPart');
	Route::post('/contests/{contest}/parts/store', [ AContestsController::class, 'storePart' ])->name('storeContestPart');
	Route::get('/contests/{contest}/parts/{part}/edit', [ AContestsController::class, 'editPart' ])->name('editContestPart');
	Route::post('/contests/{contest}/parts/{part}/update', [ AContestsController::class, 'updatePart' ])->name('updateContestPart');
	Route::post('/contests/{contest}/parts/{part}/destroy', [ AContestsController::class, 'destroyPart' ])->name('destroyContestPart');
	Route::get('/contests/{contest}/parts/{part}/downloadFile', [ AContestsController::class, 'downloadFilePart' ])->name('downloadContestPartFile');

	// specialities
	Route::get('/specialities', 'Admin\CourseSpecialitiesController@index')->name('specialities');
	Route::get('/specialities/create', 'Admin\CourseSpecialitiesController@create')->name('createSpeciality');
	Route::post('/specialities/store', 'Admin\CourseSpecialitiesController@store')->name('storeSpeciality');
	Route::get('/specialities/{speciality}/edit', 'Admin\CourseSpecialitiesController@edit')->name('editSpeciality');
	Route::post('/specialities/{speciality}/update', 'Admin\CourseSpecialitiesController@update')->name('updateSpeciality');
	Route::post('/specialities/{speciality}/destroy', 'Admin\CourseSpecialitiesController@destroy')->name('destroySpeciality');

	// courses
	Route::get('/specialities/{speciality}/courses', 'Admin\CoursesController@index')->name('courses');
	Route::get('/specialities/{speciality}/courses/create', 'Admin\CoursesController@create')->name('createCourse');
	Route::post('/specialities/{speciality}/courses/store', 'Admin\CoursesController@store')->name('storeCourse');
	Route::get('/specialities/{speciality}/courses/{course}/edit', 'Admin\CoursesController@edit')->name('editCourse');
	Route::post('/specialities/{speciality}/courses/{course}/update', 'Admin\CoursesController@update')->name('updateCourse');
	Route::post('/specialities/{speciality}/courses/{course}/destroy', 'Admin\CoursesController@destroy')->name('destroyCourse');

	// parts
	Route::get('/specialities/{speciality}/courses/{course}/parts', 'Admin\CoursePartsController@index')->name('courseParts');
	Route::get('/specialities/{speciality}/courses/{course}/parts/create', 'Admin\CoursePartsController@create')->name('createCoursePart');
	Route::post('/specialities/{speciality}/courses/{course}/parts/store', 'Admin\CoursePartsController@store')->name('storeCoursePart');
	Route::get('/specialities/{speciality}/courses/{course}/parts/{part}/edit', 'Admin\CoursePartsController@edit')->name('editCoursePart');
	Route::post('/specialities/{speciality}/courses/{course}/parts/{part}/update', 'Admin\CoursePartsController@update')->name('updateCoursePart');
	Route::post('/specialities/{speciality}/courses/{course}/parts/{part}/destroy', 'Admin\CoursePartsController@destroy')->name('destroyCoursePart');
	Route::get('/specialities/{speciality}/courses/{course}/parts/{part}/downloadFile', 'Admin\CoursePartsController@downloadFile')->name('downloadCoursePartFile');

	// tests
	Route::get('/specialities/{speciality}/courses/{course}/tests', 'Admin\CourseTestsController@index')->name('courseTests');
	Route::get('/specialities/{speciality}/courses/{course}/tests/create', 'Admin\CourseTestsController@create')->name('createCourseTest');
	Route::post('/specialities/{speciality}/courses/{course}/tests/store', 'Admin\CourseTestsController@store')->name('storeCourseTest');
	Route::get('/specialities/{speciality}/courses/{course}/tests/{test}/edit', 'Admin\CourseTestsController@edit')->name('editCourseTest');
	Route::post('/specialities/{speciality}/courses/{course}/tests/{test}/update', 'Admin\CourseTestsController@update')->name('updateCourseTest');
	Route::post('/specialities/{speciality}/courses/{course}/tests/{test}/destroy', 'Admin\CourseTestsController@destroy')->name('destroyCourseTest');

	//test questions
	Route::get('/specialities/{speciality}/courses/{course}/tests/{test}/questions/create','Admin\CourseTestQuestionsController@create')->name('createCourseTestQuestion');
	Route::post('/specialities/{speciality}/courses/{course}/tests/{test}/questions/store','Admin\CourseTestQuestionsController@store')->name('storeCourseTestQuestion');
	Route::get('/specialities/{speciality}/courses/{course}/tests/{test}/questions/{question}/edit','Admin\CourseTestQuestionsController@edit')->name('editCourseTestQuestion');
	Route::post('/specialities/{speciality}/courses/{course}/tests/{test}/questions/{question}/update','Admin\CourseTestQuestionsController@update')->name('updateCourseTestQuestion');
	Route::post('/specialities/{speciality}/courses/{course}/tests/{test}/questions/{question}/destroy','Admin\CourseTestQuestionsController@destroy')->name('destroyCourseTestQuestion');

	//test results
	Route::get('/testResults', 'Admin\CourseTestResultsController@index')->name('testResults');
	Route::post('/testResults/{id}/destroy', 'Admin\CourseTestResultsController@destroy')->name('destroyTestResult');

	// test result certificates
	Route::get('/testResults/{id}/createCertificate', 'Admin\CourseTestResultsController@createCertificate')->name('createCertificate');
	Route::post('/testResults/{id}/storeCertificate', 'Admin\CourseTestResultsController@storeCertificate')->name('storeCertificate');
	Route::get('/testResults/{id}/editCertificate/{certId}', 'Admin\CourseTestResultsController@editCertificate')->name('editCertificate');
	Route::post('/testResults/{id}/updateCertificate/{certId}', 'Admin\CourseTestResultsController@updateCertificate')->name('updateCertificate');
	Route::get('/testResults/{id}/previewCertificate/{certId}', 'Admin\CourseTestResultsController@previewCertificate')->name('previewCertificate');
	Route::post('/testResults/{id}/processCertificate/{certId}', 'Admin\CourseTestResultsController@processCertificate')->name('processCertificate');

	Route::get('/contestFiles', [ AContestsController::class, 'files' ])->name('contestFiles');
	Route::post('/contestFiles/{contestFile}/destroy', [ AContestsController::class, 'destroyFile' ])->name('contestDestroyFile');

	Route::get('/contestFiles/{contestFile}/createAward', [ AContestsController::class, 'createAward' ])->name('createAward');
	Route::post('/contestFiles/{contestFile}/storeAward', [ AContestsController::class, 'storeAward' ])->name('storeAward');
	Route::get('/contestFiles/{contestFile}/previewAward/{award}', [ AContestsController::class, 'previewAward' ])->name('previewAward');
	Route::post('/contestFiles/{contestFile}/deleteAward/{award}', [ AContestsController::class, 'deleteAward' ])->name('deleteAward');

	// certificates
	Route::get('/certificates', 'Admin\CertificatesController@index')->name('certificates');
	Route::post('/certificates/{id}/destroy', 'Admin\CertificatesController@destroy')->name('destroyCertificate');

	// testimonials
	Route::get('/testimonials', 'Admin\TestimonialsController@index')->name('testimonials');
	Route::post('/testimonials/{id}/viewed', 'Admin\TestimonialsController@viewed')->name('viewedTestimonial');
	Route::post('/testimonials/{id}/viewed-contest', 'Admin\TestimonialsController@viewedContest')->name('viewedContestTestimonial');
	Route::post('/testimonials/{id}/destroy', 'Admin\TestimonialsController@destroy')->name('destroyTestimonial');
	Route::post('/testimonials/{id}/destroy-contest', 'Admin\TestimonialsController@destroyContest')->name('destroyContestTestimonial');

});

Route::group(['middleware' => ['is_admin'], 'prefix' => 'admin/olympic', 'as' => 'admin.olympic.'], function () {
// Olympics
    Route::resources([
        'courses' => 'Admin\Olympic\CoursesController',
    ]);
	 Route::post('/question/delete', 'Admin\Olympic\CoursesController@deleteQuestion')->name('question.delete');
});
Route::get('/seminar', 'MainController@seminar')->name('seminar');

/*Route::get('/t', function () {
    $fullName = 'aaaaaaaaaaaaaaaaaaaa';
    $surname = 'asdasdsadasdas';
    $courseTitle = 'Обновленное содержание: Художественный труд (ИЗО)';
    $day = \Illuminate\Support\Carbon::now()->day . '.';
    $month = \Illuminate\Support\Carbon::now()->month . '.';
    $year = \Illuminate\Support\Carbon::now()->year;
    $regNum = rand(100000, 999999);

    $data = new \App\Data\DiplomaData(
        $fullName,
        $surname,
        $courseTitle,
        $day,
        $month,
        $year,
        $regNum,
        22
    );

    $uploads = \App\Data\Diploma::getPublicUploadsDir();
    $name = $uploads->generateName('png');
    $path = $uploads->getPathFor($name);
    $imageMaker = new \App\Interactors\DiplomaGradeImageMaker('diploma', '1_grade.png');
    $imageMaker->makeImage($data, $path);
    $imageMaker->close();

    echo '<img src="/uploads/courses/diploma/' . $name . '">';
});
*/
