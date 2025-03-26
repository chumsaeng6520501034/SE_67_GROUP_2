<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\GuideListController;
use App\Http\Controllers\CorpListController;

Route::get('/guidesInprovince/{provinceId}', [CorpListController::class, 'getGuidesByProvince']);

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['web'])->group(function () {
    Route::get('/Calendar', [UserListController::class, 'fetchCalendar']);
    Route::get('/guideGetCalendar', [GuideListController::class, 'fetchCalendar']);
    Route::get('/getGuideInTour',[UserListController::class,'getGuideInTour']);
    Route::get('/provinces', [GuideListController::class, 'getProvinces']);
    Route::get('/hotelsInprovince/{provinceId}', [GuideListController::class, 'getHotelsByProvince']);
    Route::get('/locationsInprovince/{provinceId}', [GuideListController::class, 'getLocationsByProvince']);
});
