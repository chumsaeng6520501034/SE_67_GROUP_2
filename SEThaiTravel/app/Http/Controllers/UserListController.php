<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\UserList;
use App\Models\TourHasGuideList;
use App\Models\Booking;
use Carbon\Carbon;
class UserListController extends Controller
{
    function checkTable(){
        if (Schema::hasTable((new UserList)->getTable())) {
            echo "Userlist exists!";
        } 
        else{
            echo "Table does not exist!";
        }
      }
      function review(Request $request){
            $userID=session('userID')->account_id_account;
            $tourID=1;//สมมติความจริงจะได้จากตอนที่กดปุ่มรีวิวทัว(อันนี้เอาไว้ query หา guide ในทัวร์ไว้ให้ลูกค้าเลือกรีวิว) $request->tourID
            $bookingID=1;//สมมติความจริงจะได้จากตอนที่กดปุ่มรีวิวทัว() ex $request->bookingID
            // $guideInTour= TourHasGuideList::where('tour_id_tour', $tourID)
            //               ->join('guide_list', 'Tour_has_guide_list.guide_list_account_id_account ', '=', 'guide_list.account_id_account')
            //               ->select('Tour_has_guide_list.*', 'guide_list.name as guide_name', 'guide_list.surname as guide_surname')
            //               ->get();
            return view('review');
            // view('review',compact('guideInTour','bookingID','userID'))
      }
      function insertReviewTour(Request $request){
            $reviewData=[
                'booking_id_booking'=> $request->bookingID,
                'user_list_account_id_account'=> session('userID')->account_id_account,
                'guide_list_account_id_account'=> $request->guideID,
                'score'=> $request->score,
                'message'=>$request->message,
                'sp_score'=>$request->sp_score
            ];
            dd($reviewData);
            // Review::insert($reviewData);
      }
      function bookingTour(Request $request){
        $tourID=1;//$request->tourId
        $totalMember = Booking::where('tour_id_tour', 1) //TourID ใช้ของที่กดจองมา
                        ->where('status', 'NOT LIKE', 'cancel')  
                        ->selectRaw('SUM(adult_qty + kid_qty) as Total_Member')
                        ->value('Total_Member'); // อันนี้คือคำสั่งหาจำนวนของคนที่จองมาทั้งหมดที่ยังไม่ยกเลิกเอาไว้ใช้เช็คตอนกดจองถ้าเต็มก็จะไม่สามารถกดจองได้เพราะเต็ม
        $tourCapacity = 25;//$request->Capacity
        //อันนี้ไว้เผื่อตอนกดจองมาในตอนที่ทัวร์เต็ม หรือมีอีกทางแก้ที่ UI คือ ถ้าทัวร์เต็มก็ไม่มีให้กดจอง ได้เเค่ดูรายละเอียด
        if($totalMember==$tourCapacity){
          return redirect()->back()->withErrors(['fullBooking' => 'Full Booking']);
        }
        $tourName="Markky";//$request->tourName
        $tourPrice=35000;//$request->tourPrice
        $userID=session('userID')->account_id_account;//$request->userId
        return view('bookingTour',compact('tourID','userID','tourName','tourPrice','totalMember','tourCapacity'));
      }
      function insertBooking(Request $request){
        if($request->adultqty==0 && $request->kidqty==0) 
        {
          return redirect()->back()->withErrors(['zero_Input' => 'adultqty or kid qty must be greater than 0'])->withInput(); 
        } 
        $tourPrice=$request->tourPrice;
        $totalPeople=$request->adultqty+$request->kidqty;
        //เงื่อนไขไว้เช็คตอนจองเกินจำนวนคนที่เหลือ
        if($totalPeople+$request->totalMember>$request->tourCapacity) 
        {
          return redirect()->back()->withErrors(['OverBooking' => "You have overbooked by ".$totalPeople+$request->totalMember-$request->tourCapacity." people. Please reduce the number of reservations."])->withInput(); 
        } 
        $totalPrice=$tourPrice*$totalPeople;
        $bookingData=[
            'user_list_account_id_account'=>session('userID')->account_id_account,
            'tour_id_tour'=>$request->tourID,
            'booked_date'=> Carbon::now()->toDateString(),
            'payment_date'=> Carbon::now()->addDays(5)->toDateTimeString(),
            'total_price'=>$totalPrice,
            'description'=>$request->description,
            'adult_qty'=>$request->adultqty,
            'kid_qty'=>$request->kidqty,
            'status'=>'In process'
        ];
        dd($bookingData);
        //Booking::insert($bookingData);
        return view('summaryBooking',compact('totalPrice'));
      }
      function cancelBookingTour(Request $request){
            $bookingID = 1;//$request->idBooking
            $bookingData=['status'=>'cancel'];
            $booking=Booking::where('id_booking',$bookingID)->update($bookingData);
            // dd($booking);
            // return 'update success';
      }
      
}
