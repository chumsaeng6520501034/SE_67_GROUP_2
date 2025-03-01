<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CorpListController;
use App\Http\Controllers\GuideListController;
use App\Http\Controllers\UserListController;

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
Route::get('/us',[UserListController::class,'getRequestTour']);
// Route::get('/ac',[AccountController::class,'checkTable']);
// Route::get('/bk',[BookingController::class,'checkTable']);
Route::get('/signUp',[AccountController::class,'viewSignIn']);
Route::post('/signUpCategory',[AccountController::class,'signIn']);