<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CertificateController;
use App\Http\Controllers\Api\MainController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pdf', [CertificateController::class, 'index']);
Route::get('/sbp', [MainController::class, 'sbp']);
