<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CorpListController;
use App\Http\Controllers\GuideListController;
use App\Http\Controllers\LocationInTourController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RequestTourController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\TourHasGuideListController;
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
Route::get('/ac',[AccountController::class,'checkTable']);
Route::get('/bk',[BookingController::class,'checkTable']);
Route::get('/cl',[CorpListController::class,'checkTable']);
Route::get('/gl',[GuideListController::class,'checkTable']);
Route::get('/lo',[LocationInTourController::class,'checkTable']);
Route::get('/of',[OfferController::class,'checkTable']);
Route::get('/py',[PaymentController::class,'checkTable']);
Route::get('/rq',[RequestTourController::class,'checkTable']);
Route::get('/rv',[ReviewController::class,'checkTable']);
Route::get('/to',[TourController::class,'checkTable']);
Route::get('/thg',[TourHasGuideListController::class,'checkTable']);
Route::get('/ul',[UserListController::class,'checkTable']);
