<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\UserList;
use App\Models\TourHasGuideList;
use App\Models\Booking;
use App\Models\Tour;
use App\Models\RequestTour;
use App\Models\GuideList;
use App\Models\Review;
use App\Models\Payment;
use App\Models\Offer;
use Carbon\Carbon;
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

//-----------------------------------------------------------------------------------------------------------
  //ตรวจสอบประวัติการซื้อทัวร์ *
  function getUserBuyHistory()
  {
    //$history = Booking::where('user_list_account_id_account',19)->get();
    // $buy = Booking::where('tour_id_tour',1)->get();
    //$userId = $request->input('user_list_account_id_account');

    $idAccount = session('id_account');
    //if (!$idAccount) {
    // return redirect()->route('login')->with('error', 'You must be logged in to view your sales history');
    //}
    $history = Booking::where('user_list_account_id_account', $idAccount)->get();

    dd($history);
    return view('???', compact('history'));
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
    $idAccount = session('id_account')->account_id_account;
    $paymentHistory = Payment::where('booking_user_list_account_id_account', $idAccount)->get();
    dd($paymentHistory);
    return view('???', compact('paymentHistory'));
  }
  //รายละเอียดการโอนเงินครั้งใด ๆ ที่โดนเลือก//
  function getPaymentDetails(Request $request){
    $idAccount = session('id_account')->account_id_account;
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
    $idAccount = session('')->account_id_account;
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
      'id_request_tour ' => $request->requestID,
      'user_list_account_id_account' => session('userID')->account_id_account,
      'name' => $request->nameRequest,
      'end_of_request_date' => $request->endDateRequest,
      'start_tour_date' => $request->startTourDate,
      'end_tour_date' => $request->endTourDate,
      'max_price' => $request->maxPrice,
      'start_price' => $request->startPrice,
      'guide_qty' => $request->guideQty,
      'size_tour' => $request->sizeTour,
      'contect' => $request->contect,
      'hotel_status' => $request->hotelStatus,
      'travel_status' => $request->travelStatus,
      'request_status' => $request->requestStatus,
      'description' => $request->description,
      'time' => $request->time
    ];
    // dd($requestData);
    RequestTour::where('id_request_tour', $request->bookingID)
      ->where('user_list_account_id_account', session('userID')->account_id_account)
      ->update($requestData);
    // return "redirect ไปหน้าที่ต้องการ";
  }
  //หน้าสำหรับแก้ไขรีเควสท์ มีแก้อีก
  function changeRequestForm(Request $request){
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
    return view('changeRequest', compact('reviewData', 'guideInTour', 'guideID', '$bookingID'));
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
}
