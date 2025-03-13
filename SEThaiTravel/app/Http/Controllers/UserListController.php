<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\UserList;
use App\Models\TourHasGuideList;
use App\Models\Booking;
use App\Models\Tour;
use App\Models\Account;
use App\Models\RequestTour;
use App\Models\GuideList;
use App\Models\Review;
use App\Models\Payment;
use App\Models\Offer;
use Carbon\Carbon;
use App\Models\CorpList;
//??รอถาม *ทำใหม่  //พร้อมใช้
class UserListController extends Controller
{
  function checkTable()
  {
    if (Schema::hasTable((new UserList)->getTable())) {
      echo "Userlist exists!";
    } else {
      echo "Table does not exist!";
    }
  }
  //รีวิวทัวร์//
  function reviewForm(Request $request){
    $userID = session('userID')->account_id_account;
    $tourID = $request->tourID; //สมมติความจริงจะได้จากตอนที่กดปุ่มรีวิวทัว(อันนี้เอาไว้ query หา guide ในทัวร์ไว้ให้ลูกค้าเลือกรีวิว) $request->tourID
    $bookingID = $request->bookingID; //สมมติความจริงจะได้จากตอนที่กดปุ่มรีวิวทัว() ex $request->bookingID
    $guideInTour = TourHasGuideList::where('tour_id_tour', $tourID)
      ->join('guide_list', 'Tour_has_guide_list.guide_list_account_id_account ', '=', 'guide_list.account_id_account')
      ->select('Tour_has_guide_list.*', 'guide_list.name as guide_name', 'guide_list.surname as guide_surname')
      ->get(); //เอาไว้ใช้ตอน เลือก รีวิว guide แล้วจะแสดงเป็นชื่อ
    return view('review', compact('guideInTour', 'bookingID', 'userID'));
  }
  //เพิ่มรีวิวในฐานข้อมูล//
  function addReview(Request $request){
    $reviewData = [
      'booking_id_booking' => $request->bookingID,
      'user_list_account_id_account' => session('userID')->account_id_account,
      'guide_list_account_id_account' => $request->guideID,
      'score' => $request->score,
      'message' => $request->message,
      'sp_score' => $request->sp_score
    ];
    // dd($reviewData);
    Review::insert($reviewData);
  }
  function viewMyReview(Request $request)
  { //ดูรีวิวของฉันทั้งหมด
    $myReview = Review::join('booking', 'review.booking_id_booking', '=', 'booking.id_booking')
                      ->join('tour', 'booking.tour_id_tour', '=', 'tour.id_tour')
                      ->join('guide_list', 'review.guide_list_account_id_account', '=', 'guide_list.account_id_account')
                      ->where('review.user_list_account_id_account ', session('userID')->account_id_account)
                      ->select(
                          'review.*',
                          'booking.*',
                          'tour.*',
                          'guide_list.*'
                      )
                      ->get();
    // $myReview = Review::where('user_list_account_id_account', session('userID')->account_id_account)->get();
    // $bookingData = [];
    // $guideData = [];
    // foreach ($myReview as $Review) {
    //   $bookingData[] = Booking::where('id_booking', $Review->booking_id_booking);
    //   $guideData[] = GuideList::find($Review->guide_list_account_id_account);
    // }
    // $tourData = [];
    // foreach ($bookingData as $book) {
    //   $tourData[] = Tour::where('id_tour', $book->tour_id_tour);
    // }
    return view('myReview', compact('myReview'));
  }

  //หน้าแก้ไขรีวิว
  function changeReviewForm(Request $request)
  {
    $bookingID = $request->$bookingID;
    $tourID = $request->tourID;
    $userID = session('userID')->account_id_account;
    $guideID = $request->guideID;
    $guideInTour = TourHasGuideList::where('tour_id_tour', $tourID)
      ->join('guide_list', 'Tour_has_guide_list.guide_list_account_id_account ', '=', 'guide_list.account_id_account')
      ->select('Tour_has_guide_list.*', 'guide_list.name as guide_name', 'guide_list.surname as guide_surname')
      ->get();
    $reviewData = Review::where('booking_id_booking', $bookingID)
      ->where('user_list_account_id_account', $userID)
      ->where('guide_list_account_id_account', $guideID)->first();
    return view('editReview', compact('reviewData', 'guideInTour', 'guideID', '$bookingID'));
  }

  //อัพเดต รีวิว
  function changeReview(Request $request)
  { 
    $reviewData = [
      'booking_id_booking' => $request->bookingID,
      'user_list_account_id_account' => session('userID')->account_id_account,
      'guide_list_account_id_account' => $request->guideID,
      'score' => $request->score,
      'message' => $request->message,
      'sp_score' => $request->sp_score
    ];
    // dd($reviewData);
    Review::where('booking_id_booking', $request->bookingID)
      ->where('user_list_account_id_account', session('userID')->account_id_account)
      ->where('guide_list_account_id_account', $request->guideID)
      ->update($reviewData);
    // return "redirect ไปหน้าที่ต้องการ";
  }
//------------------------------------------------------------------------------------------------------
  function viewMyBooking()
  {
    $bookingData = Booking::join('tour', 'booking.tour_id_tour', '=', 'tour.id_tour')
    ->where('booking.user_list_account_id_account', session('userID')->account_id_account)
    ->select('booking.*', 'tour.name','tour.description as tourDes') // เลือกเฉพาะฟิลด์ที่ต้องการ
    ->get();
    return view('customer.myBooking', compact('bookingData'));
  }

  function searchBooking(Request $request){
    $status = $request->status;
    $name = $request->name;
    $startDate = $request->startDate;
    $endDate = $request->endDate;
    $bookingData = Booking::join('tour', 'booking.tour_id_tour', '=', 'tour.id_tour')
    ->where('booking.user_list_account_id_account',session('userID')->account_id_account)
    ->where('booking.status', 'LIKE', '%'.$status.'%')
    ->where(function ($query) use ($status, $name, $startDate, $endDate) {
        $query->whereRaw('LOWER(tour.name) LIKE LOWER(?)', ['%'.$name.'%'])
              ->orWhereDate('booked_date','LIKE',$startDate)
              ->orWhereDate('payment_date','LIKE',$endDate);
    })
    ->select('booking.*', 'tour.name','tour.description as tourDes') // เลือกเฉพาะฟิลด์ที่ต้องการ
    ->get();
    return view('customer.myBooking', compact('bookingData'));
  }
  function bookingTour(Request $request)
  { // จองทัวร์
    $tourID = $request->tourId; //$request->tourId
    $totalMember = Booking::where('tour_id_tour', $tourID) //TourID ใช้ของที่กดจองมา
      ->where('status', 'NOT LIKE', 'cancel')
      ->selectRaw('SUM(adult_qty + kid_qty) as Total_Member')
      ->value('Total_Member'); // อันนี้คือคำสั่งหาจำนวนของคนที่จองมาทั้งหมดที่ยังไม่ยกเลิกเอาไว้ใช้เช็คตอนกดจองถ้าเต็มก็จะไม่สามารถกดจองได้เพราะเต็ม
    $tourCapacity = $request->Capacity; //$request->Capacity
    //อันนี้ไว้เผื่อตอนกดจองมาในตอนที่ทัวร์เต็ม หรือมีอีกทางแก้ที่ UI คือ ถ้าทัวร์เต็มก็ไม่มีให้กดจอง ได้เเค่ดูรายละเอียด
    if ($totalMember == $tourCapacity) {
      return redirect()->back()->withErrors(['fullBooking' => 'Full Booking']);
    }
    $tourName = $request->tourName; //$request->tourName
    $tourPrice = $request->tourPrice; //$request->tourPrice
    $userID = session('userID')->account_id_account; //$request->userId
    return view('bookingTour', compact('tourID', 'userID', 'tourName', 'tourPrice', 'totalMember', 'tourCapacity'));
  }
  function insertBooking(Request $request)
  { //เพิ่มการจองทัวร์ลงใน database
    if ($request->adultqty == 0 && $request->kidqty == 0) {
      return redirect()->back()->withErrors(['zero_Input' => 'adultqty or kid qty must be greater than 0'])->withInput();
    }
    $tourPrice = $request->tourPrice;
    $totalPeople = $request->adultqty + $request->kidqty;
    //เงื่อนไขไว้เช็คตอนจองเกินจำนวนคนที่เหลือ
    if ($totalPeople + $request->totalMember > $request->tourCapacity) {
      return redirect()->back()->withErrors(['OverBooking' => "You have overbooked by " . $totalPeople + $request->totalMember - $request->tourCapacity . " people. Please reduce the number of reservations."])->withInput();
    }
    $totalPrice = $tourPrice * $totalPeople;
    $bookingData = [
      'user_list_account_id_account' => session('userID')->account_id_account,
      'tour_id_tour' => $request->tourID,
      'booked_date' => Carbon::now()->toDateString(),
      'payment_date' => Carbon::now()->addDays(5)->toDateTimeString(),
      'total_price' => $totalPrice,
      'description' => $request->description,
      'adult_qty' => $request->adultqty,
      'kid_qty' => $request->kidqty,
      'status' => 'In process'
    ];
    // dd($bookingData);
    Booking::insert($bookingData);
    return view('summaryBooking', compact('totalPrice'));
  }
  function cancelBookingTour(Request $request)
  { //ยกเลิกทัวร์
    $bookingID = $request->idBooking; //$request->idBooking
    $bookingData = ['status' => 'cancel'];
    $booking = Booking::where('id_booking', $bookingID)->update($bookingData);
    // dd($booking);
    // return 'update success';
  }
//   public function setSessionAndRedirect($booking_id)
// {
//     // บันทึกค่าลง Session
//     session(['booking_id' => $booking_id]);

//     // เปลี่ยนเส้นทางไปยังหน้ารายละเอียด
//     return view('customer.detailBooking');
// }
//-----------------------------------------------------------------------------------------------------------
  //ตรวจสอบประวัติการซื้อทัวร์ *
  function getDetailBooking(Request $request)
  {
    // dd($request->tourID);
    $name = $request->input('name');
    $idAccount = session('userID')->account_id_account;

    $history = Booking::where('user_list_account_id_account', $idAccount)
        ->join('tour', 'tour.id_tour', '=', 'booking.tour_id_tour')
        ->leftJoin('corp_list', 'corp_list.account_id_account', '=', 'tour.owner_id')  // เชื่อมบริษัท
        ->leftJoin('guide_list', 'guide_list.account_id_account', '=', 'tour.owner_id') // เชื่อมไกด์
        ->where('tour.name', 'LIKE', '%' . $name . '%')
        ->get([
            // ข้อมูล booking
            'booking.id_booking',
            'booking.user_list_account_id_account',
            'booking.tour_id_tour',
            'booking.booked_date',
            'booking.payment_date',
            'booking.total_price',
            'booking.description AS desBook',
            'booking.adult_qty AS adult',
            'booking.kid_qty AS kid',
            'booking.status AS booking_status',

            // ข้อมูล tour
            'tour.from_owner AS type',
            'tour.owner_id AS owner',
            'tour.name AS tour_name',
            'tour.Release_date AS postDate',
            'tour.End_of_sale_date',
            'tour.start_tour_date AS startDate',
            'tour.end_tour_date AS endDate',
            'tour.price AS price',
            'tour.tour_capacity AS tour_capacity',
            'tour.contect',
            'tour.hotel AS hotel',
            'tour.hotel_price AS hotelPrice',
            'tour.description AS desTour',
            'tour.travel_by AS travelBy',
            'tour.status AS tour_status',
            'tour.offer_id_offer',
            'tour.type_tour',

            // ข้อมูลเจ้าของ (บริษัทใช้ name, ไกด์ใช้ name + surname)
            DB::raw('COALESCE(corp_list.name, guide_list.name) AS owner_name'),
            DB::raw('COALESCE(guide_list.surname, "") AS owner_surname')
        ]);

    return view('customer.detailBooking', compact('history'));
  }

  //ทัวร์ที่กำลังวางขายอยู่ *
  function getTourActive()
  {
    $tour = Tour::where('status', 'ongoing')->where('type_tour', 'public')->get();
    dd($tour);
    return view('???', compact('tour'));
  }

  //ค้นหาทัวร์ที่กำลังวางขายอยู่  แต่เอาชื่อหา *
  function searchNameTourActive()
  {
    $name = session('name'); //session ที่เก็บข้อความค้นหา
    $tour = Tour::where('name', $name)->where('status', 'ongoing')
      ->where('type_tour', 'public')->get();

    return view('???', compact('tour'));
  }
  function searchAllTourActive(Request $request){
    $name = $request->searchKey;
    $startDate = $request->startDate;
    $endDate = $request->endDate;
    $capacity = $request->capacity;
    $path = $_SERVER['REQUEST_URI'];
    if(is_numeric($name)){//เช็คว่าเป็นตัวเลขไหมถ้าเป็นจะ search แบบ private 
      $searchTourData = Tour::where(function ($query) use ($name, $startDate, $endDate, $capacity) {
        $query->where('name', 'LIKE', '%'.$name.'%')
              ->orWhere('start_tour_date', '=', $startDate) // เปลี่ยน LIKE เป็น =
              ->orWhere('end_tour_date', '=', $endDate) // เปลี่ยน LIKE เป็น =
              ->orWhere('tour_capacity', '>=', $capacity); // ไม่มี LIKE กับตัวเลข
              })
              ->where('status', 'LIKE', 'ongoing')
              ->where('type_tour', 'LIKE', 'private')
              ->paginate(2)->appends($request->query());
          }
    else{
      $searchTourData =Tour::where(function ($query) use ( $name, $startDate, $endDate,$capacity)  {
      $query->where('start_tour_date', '=', $startDate)
            ->orWhere('end_tour_date', '=',  $endDate)
            ->orWhere('tour_capacity', '>=', $capacity);
            })
            ->whereRaw('LOWER(tour.name) LIKE LOWER(?)', ['%'.$name.'%'])
            ->where('status', 'LIKE', 'ongoing')
            ->where('type_tour', 'LIKE', 'public')
            ->paginate(2)->appends($request->query());
    }
    $ownerData = [];
    $totalMember = [];
    $ownerScore = [];
    foreach($searchTourData as $data){//อันนหาหาข้อมูลของเจ้าของทัวร์นั้นๆแล้วส่งไปใน view ด้วยเผื่อใช้
        switch($data->from_owner){
          case "guide": $ownerData[] = GuideList::find($data->owner_id)->first(); 
                        $ownerScore [] = Review::leftJoin('guide_list', 'review.guide_list_account_id_account', '=', 'guide_list.account_id_account')
                        ->where('guide_list.account_id_account', $data->owner_id) // กรองเฉพาะ owner_id ที่ต้องการ
                        ->selectRaw('COUNT(*) as total_reviews, AVG(review.sp_score) as average_score')
                        ->first();
                        break;
          case "corp": $ownerData[] = CorpList::find($data->owner_id)->first(); 
                       $ownerScore [] = Review::leftJoin('booking', 'review.booking_id_booking', '=', 'booking.id_booking')
                        ->leftJoin('tour', function($join) {
                            $join->on('tour.id_tour', '=', 'booking.tour_id_tour')
                                ->where('tour.from_owner', 'LIKE', 'corp');
                        })
                        ->leftJoin('corp_list', 'corp_list.account_id_account', '=', 'tour.owner_id')
                        ->where('corp_list.account_id_account', $data->owner_id)
                        ->selectRaw('COUNT(*) as total_reviews, AVG(review.sp_score) as average_score')
                        ->first(); // ใช้ `first()` เพราะดึงแค่บริษัทเดียว
                        break;
        }
        $totalMember[]= Booking::where('tour_id_tour', $data->id_tour ) //TourID ใช้ของที่กดจองมา
        ->where('status', 'NOT LIKE', 'cancel')
        ->selectRaw('SUM(adult_qty + kid_qty) as Total_Member')
        ->value('Total_Member');
    }
    return view('customer.search',compact('ownerData','searchTourData','totalMember','ownerScore','path'));
  }
  function searchFilterTourActive(Request $request){
    $name = $request->searchKey;
    $startDate = $request->startDate;
    $endDate = $request->endDate;
    $capacity = $request->capacity;
    $minBudget = $request->minBudget;
    $maxBudget = $request->maxBudget;
    $path = $_SERVER['REQUEST_URI'];
    if(is_numeric($name)){//เช็คว่าเป็นตัวเลขไหมถ้าเป็นจะ search แบบ private 
      $searchTourData = Tour::where(function ($query) use ($name, $startDate, $endDate, $capacity) {
        $query->where('offer_id_offer', '=', $name)
              ->orWhere('start_tour_date', '=', $startDate) // เปลี่ยน LIKE เป็น =
              ->orWhere('end_tour_date', '=', $endDate) // เปลี่ยน LIKE เป็น =
              ->orWhere('tour_capacity', '>=', $capacity); // ไม่มี LIKE กับตัวเลข
              })
              ->where('status', 'LIKE', 'ongoing')
              ->where('type_tour', 'LIKE', 'private')
              ->paginate(2)->appends($request->query());
          }
    else{
      $searchTourData =Tour::where(function ($query) use ( $name, $startDate, $endDate,$capacity)  {
      $query->where('start_tour_date', '=', $startDate)
            ->orWhere('end_tour_date', '=',  $endDate)
            ->orWhere('tour_capacity', '>=', $capacity);
            })
            ->whereRaw('LOWER(tour.name) LIKE LOWER(?)', ['%'.$name.'%'])
            ->where('status', 'LIKE', 'ongoing')
            ->whereBetween('price', [$minBudget, $maxBudget])
            ->where('type_tour', 'LIKE', 'public')
            ->paginate(2)->appends($request->query());
    }
    $ownerData = [];
    $totalMember = [];
    $ownerScore = [];
    foreach($searchTourData as $data){//อันนหาหาข้อมูลของเจ้าของทัวร์นั้นๆแล้วส่งไปใน view ด้วยเผื่อใช้
        switch($data->from_owner){
          case "guide": $ownerData[] = GuideList::find($data->owner_id)->first(); 
                        $ownerScore [] = Review::leftJoin('guide_list', 'review.guide_list_account_id_account', '=', 'guide_list.account_id_account')
                        ->where('guide_list.account_id_account', $data->owner_id) // กรองเฉพาะ owner_id ที่ต้องการ
                        ->selectRaw('COUNT(*) as total_reviews, AVG(review.sp_score) as average_score')
                        ->first();
                        break;
          case "corp": $ownerData[] = CorpList::find($data->owner_id)->first(); 
                       $ownerScore [] = Review::leftJoin('booking', 'review.booking_id_booking', '=', 'booking.id_booking')
                        ->leftJoin('tour', function($join) {
                            $join->on('tour.id_tour', '=', 'booking.tour_id_tour')
                                ->where('tour.from_owner', 'LIKE', 'corp');
                        })
                        ->leftJoin('corp_list', 'corp_list.account_id_account', '=', 'tour.owner_id')
                        ->where('corp_list.account_id_account', $data->owner_id)
                        ->selectRaw('COUNT(*) as total_reviews, AVG(review.sp_score) as average_score')
                        ->first(); // ใช้ `first()` เพราะดึงแค่บริษัทเดียว
                        break;
        }
        $totalMember[]= Booking::where('tour_id_tour', $data->id_tour ) //TourID ใช้ของที่กดจองมา
        ->where('status', 'NOT LIKE', 'cancel')
        ->selectRaw('SUM(adult_qty + kid_qty) as Total_Member')
        ->value('Total_Member');
    }
    return view('customer.search',compact('ownerData','searchTourData','totalMember','ownerScore','path'));
  }
  //ตรวจสอบประวัติการขายทัวร์
  /*function getGuideSellHistory()
  {
    //$userId = Auth::id();
    //$history = Tour::where('owner_id', $userId)->get();
    //$history = Tour::where('owner_id',30)->get(); //test
    //$userId = $request->input('owner_id');
    $idAccount = session('id_account');
    $history = Tour::where('owner_id', $idAccount)->get();

    dd($history);
    return view('???', compact('history'));
  }*/

  // function getCorpSellHistory(){
  //   // เหมือนguide
  //   $idAccount = session('id_account');
  //   $history = Tour::where('owner_id',$idAccount)->get();

  //   return view('???',compact('history'));
  // }

  //ตรวจสอบประวัติการทำงานในทัวร์//
  /*function getGuideWorkTourtHistory()
  {
    $idAccount = session('id_account');
    $history = TourHasGuideList::where('guide_list_account_id_account', $idAccount)->get();

    dd($history);
    return view('???', compact('history'));
  }*/

  //ตรวจสอบการโอนเงินของไกด์
  /*function getTourPaymentHistory()
  {
    //$history = Payment::where('booking_Tour_id_Tour',5)->get();

    //id ทัวร์ เพื่อดูว่าทัวร์นั้นมีคนจ่ายกี่คนยังไง
    $idAccount = session('id_account'); //แก้เป็น session ที่เก็บtour
    $history = Payment::where('booking_Tour_id_Tour', $idAccount)->get();
    dd($history);
    return view('???', compact('history'));
  }*/
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  //ตรวจสอบการโอนเงินลูกค้าทั้งหมด//
  function getUserPaymentHistory(){
    $idAccount = session('userID')->account_id_account;
    $paymentHistory = Payment::where('booking_user_list_account_id_account', $idAccount)->get();

    return view('customer.payments', compact('paymentHistory'));
  }
  //รายละเอียดการโอนเงินครั้งใด ๆ ที่โดนเลือก//
  function getPaymentDetails(Request $request){
    $idAccount = session('userID')->account_id_account;
    $idPayment = $request->paymentID;
    $bill = payment::table('payment as p')
    ->join('booking as b', 'b.id_booking', '=', 'p.booking_Tour_id_Tour')
    ->join('user_list as u', 'u.account_id_account', '=', 'p.booking_user_list_account_id_account')
    ->where('p.booking_user_list_account_id_account', $idAccount)
    ->where('p.id_payment', $idPayment)
    ->get();
    dd($bill);
    return view('???', compact('bill'));
  }

  function getAllRequestTour(){
    $idAccount = session('userID')->account_id_account;
    $All_req = RequestTour::where('user_list_account_id_account', $idAccount)
    ->get();
    return view('customer.myRequest', compact('All_req'));
  }

  //ขอรีเควสท์ที่ลูกค้ากำลังประกาศ//
  function getRequestTourAvailable(){
    $idAccount = session('id_account')->account_id_account;
    $Available_req = RequestTour::where('user_list_account_id_account', $idAccount)
    ->where('request_status', 'ongoing')
    ->get();
    dd($Available_req);
    return view('???', compact('Available_req'));
  }
  //ขอรีเควสท์ที่ลูกค้าเคยสร้าง//
  function getRequestTourHistory(){
    $idAccount = session('id_account')->account_id_account;
    $History_req   = RequestTour::where('user_list_account_id_account', $idAccount)
    ->where('request_status', 'finish')
    ->get();
    dd($History_req);
    return view('???', compact('History_req'));
  }
  //ขอรีเควสท์ที่ลูกค้ายกเลิก//
  function getRequestTourCancel(){
    $idAccount = session('id_account')->account_id_account;
    $Cancal_req = RequestTour::where('user_list_account_id_account', $idAccount)
    ->where('request_status', 'cancal')
    ->get();
    dd($Cancal_req);
    return view('???', compact('Cancal_req'));
  }
  //รายละเอียดรีเควสท์ใด ๆ ที่โดนเลือก//
  function getOfferFromRequest(Request $request){
    $idAccount = session('id_account')->account_id_account;
    $idRequest = $request->requestID;
    $offerList = Offer::table('offer as o')
    ->join(' request_tour as r', 'r.id_request_tour', '=', 'o.request_tour_id_request_tour')
    ->where('r.id_request_tour', $idRequest)
    ->get();
    dd($offerList);
    return view('???', compact('offerList'));
  }

  //แสดงหน้าต่างเตือนว่ากำลังจะลบรีเควสท์//
  function changeStatusRequestTour(Request $request){
    $idRequest = $request->requestID;
    return view('cancelRequest', compact('idRequest'));
  }
  //ลบรีเควสท์//
  function cancelRequestTour(Request $request){
    $idRequest = $request->requestID;
    RequestTour::update('UPDATE request_tour SET request_status = ? WHERE request_tour.id_request_tour = ?'
    , ['cancel', $idRequest]);
    //return view(,);
  }
  //แก้ไขรีเควสท์ในฐานข้อมูล มีแก้อีก
  function changeRequestTour(Request $request){
    $requestData = [
      // 'id_request_tour' => $request->requestID,
      'user_list_account_id_account' => session('userID')->account_id_account,
      'name' => $request->nameRequest,
      // 'end_of_request_date' => $request->endDateRequest,
      'start_tour_date' => $request->startTourDate,
      'end_tour_date' => $request->endTourDate,
      'max_price' => $request->maxPrice,
      'start_price' => $request->startPrice,
      'guide_qty' => $request->guideQty,
      'size_tour' => $request->sizeTour,
      'contect' => $request->contect,
      'hotel_status' => $request->hotelStatus,
      'travel_status' => $request->travelStatus,
      // 'request_status' => $request->requestStatus,
      'description' => $request->description,
      // 'time' => $request->time
    ];
    // dd($requestData);
    $idAccount = session('userID')->account_id_account;
    RequestTour::where('id_request_tour', $request->requestID)
      ->where('user_list_account_id_account', session('userID')->account_id_account)
      ->update($requestData);

      $All_req = RequestTour::where('user_list_account_id_account', $idAccount)
      ->get();
     return redirect('/myRequest');
  }
  //หน้าสำหรับแก้ไขรีเควสท์ มีแก้อีก
  function changeRequestForm(Request $request){
    $bookingID = $request->$bookingID;
    $tourID = $request->tourID;
    $userID = session('userID')->account_id_account;
    $guideID = $request->guideID;
    dd($tourID,$userID);
    $guideInTour = TourHasGuideList::where('tour_id_tour', $tourID)
      ->join('guide_list', 'Tour_has_guide_list.guide_list_account_id_account ', '=', 'guide_list.account_id_account')
      ->select('Tour_has_guide_list.*', 'guide_list.name as guide_name', 'guide_list.surname as guide_surname')
      ->get();
    $reviewData = Review::where('booking_id_booking', $bookingID)
      ->where('user_list_account_id_account', $userID)
      ->where('guide_list_account_id_account', $guideID)->first();
    return view('changeRequest', compact('reviewData', 'guideInTour', 'guideID', '$bookingID'));
  }
  
  function viewEditRequestTour(Request $request){
    $tourID = $request->input('tourID');
    $idAccount = session('userID')->account_id_account;
    $edit = RequestTour::where('user_list_account_id_account', $idAccount)
        ->where('id_request_tour', $tourID)
        ->first(); // ใช้ first() เพื่อให้ได้แค่รายการเดียวที่ตรงกับ tourID
    // dd($edit);
    return view('customer.editAddtour', compact('edit'));
  }
  //หน้าสำหรับเพิ่มรีเควสท์
  //เพิ่มรีเควสท์ใหม่เข้าฐานข้อมูล

  
  function viewCalendar(){
    return view('customer.calendar');
  }
  function fetchCalendar(){//ดึงข้อมูลมาทำปฏิทิน
    $id=session('userID')->account_id_account; 
    $bookingData=Booking::where('user_list_account_id_account',$id)->where('status','NOT LIKE','cancel')->get();
    $tourData=[];
    $tourIds = $bookingData->pluck('tour_id_tour');
  
    // ดึงข้อมูล Tour ทั้งหมดที่อยู่ใน Booking (Query เดียว)
    $tours = Tour::whereIn('id_tour', $tourIds)->get();
  
    // จัดรูปแบบข้อมูลให้เหมาะกับ FullCalendar
    $formattedEvents = $tours->map(function ($tour) {
        return [
            'title' => $tour->name,
            'start' => $tour->start_tour_date,
            'end' => Carbon::parse($tour->end_tour_date)->addDay()->format('Y-m-d'),
        ];
    });
    
    return response()->json($formattedEvents);
  }
  function viewProfile(){
    $id = session('userID')->account_id_account; 
    $accountData = Account::where('id_account', $id)->first();
    $userData = UserList::where('account_id_account',$id)->first();
    return view('customer.profile',compact('accountData','userData'));
  }
  function viewProductDetail(Request $request){
    $tourID = $request->tourID;
    $path = $request->path;
    $tourData = Tour::where('id_tour',$tourID)->first();
    switch($tourData->from_owner){
      case "guide": $productData = Tour::join('guide_list', 'tour.owner_id', '=', 'guide_list.account_id_account')
                                            ->where('tour.id_tour', $tourID)
                                            ->select('tour.*', 'guide_list.name as guide_name', 'guide_list.surname as guide_surname')
                                            ->first(); break;
      case "corp":  $productData = Tour::join('corp_list', 'tour.owner_id', '=', 'corp_list.account_id_account')
                                            ->where('tour.id_tour', $tourID)
                                            ->select('tour.*', 'corp_list.name as corp_name')
                                            ->first(); break; 
    }
    $totalMember = Booking::where('tour_id_tour', $tourID ) //TourID ใช้ของที่กดจองมา
    ->where('status', 'NOT LIKE', 'cancel')
    ->selectRaw('SUM(adult_qty + kid_qty) as Total_Member')
    ->value('Total_Member');
    // $locationInTourData = LocationInTour::where('tour_id_tour',$tourID)->pluck('loc_api');
    // $locationFetchApi = $locationInTourData->map(function ($apiUrl) {
    //   $response = Http::get($apiUrl);
    //   return $response->successful() ? $response->json() : null;
    // })->filter();
    // return view('viewProduct',[
    //   'tour_info' => $productData,
    //   'locations' => $locationFetchApi
    // ]);
    return view('customer.detailSearch',compact('path','totalMember','productData'));
  }
}
