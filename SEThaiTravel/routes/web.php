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
    return view('user.home');
});

Route::get('/home', function () {
    return view('customer.home');
});

Route::get('/us',[UserListController::class,'getRequestTour']);
// Route::get('/ac',[AccountController::class,'checkTable']);
// Route::get('/bk',[BookingController::class,'checkTable']);
Route::get('/signUp',[AccountController::class,'viewSignIn']);
Route::post('/signUpCategory',[AccountController::class,'signIn']);
Route::post('/insertUser',[AccountController::class,'insertUser']);
Route::get('/logIn',[AccountController::class,'viewLogin']);
Route::get('/logOut',[AccountController::class,'logOut']);
Route::post('/checkLogIn',[AccountController::class,'checkLogin']);
Route::get('/calendar',[UserListController::class,'viewCalendar']);
Route::get('/myBooking',[UserListController::class,'viewMyBooking']);
Route::post('/searchBooking',[UserListController::class,'searchBooking']);
Route::get('/payments',[UserListController::class,'getUserPaymentHistory']);


