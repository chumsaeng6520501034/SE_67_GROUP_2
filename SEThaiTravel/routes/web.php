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

Route::get('/customer', function () {
    return view('customer.myRequest');
});

Route::get('/addTour', function () {
    return view('corporation.addTour');
});
Route::get('/myTour', function () {
    return view('corporation.myTour');
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
Route::get('/userProfile',[UserListController::class,'viewProfile']);
Route::get('/myRequest',[UserListController::class,'getAllRequestTour']);
Route::get('/payments',[UserListController::class,'getUserPaymentHistory']);
Route::get('/deleteAccount',[AccountController::class,'deleteAccount']);
Route::match(['get', 'post'],'/detailBooking',[UserListController::class,'getDetailBooking']);
Route::match(['get', 'post'],'/editAddtour',[UserListController::class,'viewEditRequestTour']);
Route::match(['get', 'post'],'/editAdd',[UserListController::class,'changeRequestTour']);
Route::match(['get', 'post'],'/detailBooking',[UserListController::class,'getUserBuyHistory']);
Route::get('/history',[UserListController::class,'viewHistory']);
// Route::get('/setSession/{booking_id}', [UserListController::class, 'setSessionAndRedirect'])
//     ->name('setSessionAndRedirect');
Route::get('/de', function () {
    return view('customer.history');
});



Route::get('/customerSearch',[UserListController::class,'searchAllTourActive']);
Route::get('/customerFilterSearch',[UserListController::class,'searchFilterTourActive']);
Route::get('/userSearch',[AccountController::class,'search']);
Route::get('/userFilterSearch',[AccountController::class,'searchFilterTourActive']);
Route::post('/customerViewProductDetail',[UserListController::class,'viewProductDetail']);
Route::post('/userViewProductDetail',[AccountController::class,'viewProduct']);
Route::post('/addRequest',[UserListController::class,'insertRequest']);
Route::post('/submitReview',[UserListController::class,'addReview']);
Route::post('/customerViewReview',[UserListController::class,'viewReviewDetail']);
Route::get('/searchHistory',[UserListController::class,'searchHistory']);

//corp section
Route::get('/corpHomepage',[CorpListController::class,'getHomePage']);
Route::get('/corpAddTourPage',[CorpListController::class,'getAddTour']);
Route::post('/corpAddTour',[CorpListController::class,'addTour']);
Route::get('/corpMyTour',[CorpListController::class,'getTour']);
Route::get('/corpHistory',[CorpListController::class,'getHistory']);
Route::get('/corpOffer',[CorpListController::class,'getOffer']);
Route::get('/corpStaff',[CorpListController::class,'getStaffInCorp']);
Route::get('/corpPayments',[CorpListController::class,'getAllPaymentHistory']);



//guide section
Route::get('/guideHomePage',[GuideListController::class,'getHomePage']);
Route::get('/guideAddTourPage',[GuideListController::class,'getAddTour']);
Route::post('/guideAddTour',[GuideListController::class,'addTour']);
Route::get('/guideMyTour',[GuideListController::class,'getMytour']);
Route::get('/guideSearchMyTour',[GuideListController::class,'searchMyTour']);
Route::post('/guideDeleteMyTour',[GuideListController::class,'deleteMyTour']);
Route::get('/guideEditTourPage',[GuideListController::class,'editMyTourPage']);
Route::post('/guideEditTour',[GuideListController::class,'updateMyTour']);
Route::post('/guideDetailMyTour',[GuideListController::class,'getMyTourDetail']);
Route::get('/guideMyJop',[GuideListController::class,'getMyJob']);
Route::post('/guideMyJopDetail',[GuideListController::class,'getMyJobDetail']);
Route::get('/guideSearchMyJob',[GuideListController::class,'searchMyJob']);
Route::get('/guideJobHistory',[GuideListController::class,'getJobHistory']);
Route::post('/guideMyJopHistoryDetail',[GuideListController::class,'getJobHistoryDetail']);
Route::get('/guideSearchMyJobHistory',[GuideListController::class,'searchMyJobHistory']);
Route::get('/guideCalendar',[GuideListController::class,'viewCalendar']);
Route::get('/guideSearch',[GuideListController::class,'searchAll']);
Route::get('/guideSearchFilter',[GuideListController::class,'searchFilter']);
Route::post('/guideSearchTourDetail',[GuideListController::class,'getSearchTourDetail']);
Route::post('/guideSearchRequestDetail',[GuideListController::class,'getSearchRequestDetail']);