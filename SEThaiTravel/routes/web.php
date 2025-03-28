<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CorpListController;
use App\Http\Controllers\GuideListController;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\AdminListController;
use App\Models\Account;
use Illuminate\Http\Request;

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

//ข้างล่างมี??
Route::get('/addoffer', function () {
    return view('corporation.addOffer');
});
//ย้ายที่ด้วย
Route::get('/corpProfile', function () {
    return view('corporation.profileCorp');
});
//ข้างล่างมี??
Route::get('/myTour', function () {
    return view('corporation.myTour');
});

Route::get('/us',[UserListController::class,'getRequestTour']);
Route::get('/signUp',[AccountController::class,'viewSignIn']);
Route::post('/signUpCategory',[AccountController::class,'signIn']);
Route::post('/insertUser',[AccountController::class,'insertUser']);
Route::get('/logIn',[AccountController::class,'viewLogin']);
Route::get('/logOut',[AccountController::class,'logOut']);
Route::post('/checkLogIn',[AccountController::class,'checkLogin']);
Route::get('/calendar',[UserListController::class,'viewCalendar']);

Route::get('/myBooking',[UserListController::class,'viewMyBooking']);
Route::get('/customerBooking',[UserListController::class,'viewMyBooking']);

Route::post('/searchBooking',[UserListController::class,'searchBooking']);

Route::get('/myRequest',[UserListController::class,'getAllRequestTour']);
Route::get('/payments',[UserListController::class,'getUserPaymentHistory']);
Route::get('/detailPayment',[UserListController::class,'getPaymentDetails']);
Route::get('/retuntopayment',[UserListController::class,'getUserPaymentHistory']);


Route::get('/deleteAccount',[AccountController::class,'deleteAccount']);
Route::match(['get', 'post'],'/detailBooking',[UserListController::class,'getDetailBooking']);
Route::match(['get', 'post'],'/editAddtour',[UserListController::class,'viewEditRequestTour']);
Route::match(['get', 'post'],'/editAdd',[UserListController::class,'changeRequestTour']);
// Route::match(['get', 'post'],'/detailBooking',[UserListController::class,'getUserBuyHistory']);
Route::get('/history',[UserListController::class,'viewHistory']);
// Route::get('/setSession/{booking_id}', [UserListController::class, 'setSessionAndRedirect'])
//     ->name('setSessionAndRedirect');
Route::get('/de', function () {
    return view('customer.history');
});
Route::get('/addTour',[UserListController::class,'viewAddTour']);
Route::post('/addRequest',[UserListController::class,'insertRequest']);
Route::post('/deleteRequestTour',[UserListController::class,'deleteMyTour']);
Route::match(['get', 'post'],'/requestDetail',[UserListController::class,'getRequestDetail'])->name('requestDetail');
Route::post('/statusApprove',[UserListController::class,'statusApprove']);
Route::post('/statusReject',[UserListController::class,'statusReject']);

Route::get('/customerProfile',[UserListController::class,'viewProfile']);
Route::post('/customerEditProfile',[UserListController::class,'updateUser']);
Route::post('/customerUpdateImage',[UserListController::class,'updateImage']);
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


// Route::post('/toggle-status/{id}', function ($id) {
//     $account = Account::findOrFail($id);
    
//     // สลับค่า status
//     $account->status = ($account->status === 'available') ? 'disappear' : 'available';
//     $account->save();

//     return response()->json(['status' => $account->status]);
// });
//admin section
Route::get('/adminProfile',[UserListController::class,'viewProfile']);
Route::post('/statusAvai',[AdminListController::class,'statusAvai']);
Route::post('/statusDis',[AdminListController::class,'statusDis']);
Route::post('/statusChange',[AdminListController::class,'statusChange']);
Route::get('/account',[AdminListController::class,'viewAccount'])->name('account');
Route::get('/customer', [AdminListController::class, 'viewCustomer'])->name('customer');
Route::get('/guide',[AdminListController::class,'viewGuide'])->name('guide');
Route::get('/corporation',[AdminListController::class,'viewCorporation'])->name('corp');

Route::match(['get', 'post'],'/editCustomer',[AdminListController::class,'viewEditCustomer']);
Route::post('/updateCustomer',[AdminListController::class,'updateCustomer']);
Route::post('/deleteCustomer', [AdminListController::class, 'deleteCustomer'])->name('deleteCustomer');

Route::match(['get', 'post'],'/editGuide',[AdminListController::class,'viewEditGuide']);
Route::post('/updateGuide',[AdminListController::class,'updateGuide']);
Route::post('/deleteGuide', [AdminListController::class, 'deleteGuide'])->name('deleteGuide');

Route::match(['get', 'post'],'/editCorp',[AdminListController::class,'viewEditCorp']);
Route::post('/updateCorp',[AdminListController::class,'updateCorp']);
Route::post('/deleteCorp', [AdminListController::class, 'deleteCorp'])->name('deleteCorp');

//corp section
Route::get('/corpProfile',[CorpListController::class,'viewProfile']);//profile
Route::post('/corpEditProfile',[CorpListController::class,'updateUser']);
Route::post('/corpUpdateImage',[CorpListController::class,'updateImage']);
Route::get('/corpHomepage',[CorpListController::class,'getHomePage']);
Route::get('/corpSearch',[CorpListController::class,'searchAll']);
Route::get('/corpSearchFilter',[CorpListController::class,'searchFilter']);
Route::post('/corpSearchTourDetail',[CorpListController::class,'getSearchTourDetail']);
Route::post('/corpSearchRequestDetail',[CorpListController::class,'getSearchRequestDetail']);
Route::get('/corpAddTourPage',[CorpListController::class,'getAddTour']);
Route::post('/corpAddTour',[CorpListController::class,'addTour']);


//ยังไม่เสร็จ ตั้งแต่ตรงนี้
Route::get('/corpMyTour',[CorpListController::class,'getTour']); //หน้าทัวร์ของฉัน
Route::post('/corpDetailMyTour',[CorpListController::class,'getMyTourDetail']);
Route::get('/corpMyinTour',[CorpListController::class,'getTour']); //หน้าทัวร์ของฉัน
Route::post('/corpDeleteMyTour',[CorpListController::class,'deleteMyTour']);
Route::post('/corpEditTour',[GuideListController::class,'updateMyTour']);

Route::get('/corpHistory',[CorpListController::class,'getHistory']); //หน้าประวัติขาย
Route::post('/corpDetailSellHistory',[CorpListController::class,'getSellHistoryDetail']);
Route::get('/corpSellHistory',[CorpListController::class,'getHistory']);
Route::get('/corpEditTourPage',[CorpListController::class,'editMyTourPage']);

Route::get('/corpToAddtour',[CorpListController::class,'getAddOffer']); //addoffer
Route::post('/corpAddOffer',[CorpListController::class,'addOffer']);
Route::get('/corpOffer',[CorpListController::class,'getOffer']); //หน้าข้อเสนอ
Route::get('/corpOfferDetail',[CorpListController::class,'getOfferDetail']);
Route::get('/corpSearchOffer',[CorpListController::class,'searchOffer']);
Route::get('/corpEditOffer',[CorpListController::class,'toEditOffer']);
Route::get('/corpGetMyOffer',[CorpListController::class,'getOffer']); //หน้าข้อเสนอ
Route::post('/corpUpdateOffer',[CorpListController::class,'updateMyOffer']);



Route::get('/corpStaff',[CorpListController::class,'getStaffInCorp']); //staff list
Route::get('/corpStaffDetail',[CorpListController::class,'staffDetail']);
Route::get('/corpMyStaff',[CorpListController::class,'getStaffInCorp']); //staff list
Route::get('/corpPayments',[CorpListController::class,'getAllPaymentHistory']);//payments
Route::get('/corpSearchAllPayment',[CorpListController::class,'searchPayment']);
Route::get('/corpPaymentDetail',[CorpListController::class,'getPaymentDetail']);
Route::get('/corpStatistic',[CorpListController::class,'getStatistic']);//stat

//guide section
Route::get('/guideProfile',[GuideListController::class,'viewProfile']);//profile
Route::post('/guideEditProfile',[GuideListController::class,'updateUser']);
Route::post('/guideUpdateImage',[GuideListController::class,'updateImage']);
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
Route::get('/guideStatistic',[GuideListController::class,'getStatistic']);
Route::get('/guideAllPayment',[GuideListController::class,'getAllPayment']);
Route::get('/guideSearchAllPayment',[GuideListController::class,'searchPayment']);
Route::get('/guideGetPaymentDetail',[GuideListController::class,'getPaymentDetail']);
Route::get('/guideGetMyOffer',[GuideListController::class,'getOffer']);
Route::get('/guideSearchOffer',[GuideListController::class,'searchOffer']);
Route::get('/guideOfferDetail',[GuideListController::class,'getOfferDetail']);
Route::get('/guideEditOffer',[GuideListController::class,'toEditOffer']);
Route::post('/guideUpdateOffer',[GuideListController::class,'updateOffer']);
Route::post('/guideDeleteOffer',[GuideListController::class,'deleteOffer']);
Route::get('/getAddOfferPage',[GuideListController::class,'getAddOfferPage']);
Route::post('/guideAddOffer',[GuideListController::class,'addOfferS']);
Route::get('/guideSellHistory',[GuideListController::class,'getSellHistory']);
Route::get('/guideSearchSellHistory',[GuideListController::class,'searchSellHistory']);
Route::post('/guideSellHistoryDetail',[GuideListController::class,'sellHistoryDetail']);
Route::get('/guideAddPrivateTour',[GuideListController::class,'addPrivateTourPage']);
Route::post('/guideAddPrivateTour',[GuideListController::class,'addPrivateTour']);




//customer addition
Route::get('/customerReserve',[UserListController::class,'bookingTour']);
Route::get('/customerBooking',[UserListController::class,'insertBooking']);
Route::get('/getPaymentPage',[UserListController::class,'getPaymentPage']);
Route::get('/customerPayBooking',[UserListController::class,'insertPayment']);
Route::post('/insertGuide',[AccountController::class,'insertGuide']);
Route::post('/insertCorp',[AccountController::class,'insertCorp']);