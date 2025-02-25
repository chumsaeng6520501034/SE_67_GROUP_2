<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\GuideList;
use App\Models\Tour;
use App\Models\TourHasGuideList;
use App\Models\Payment;
use App\Models\Offer;
use Carbon\Carbon;
class GuideListController extends Controller
{
    function checkTable(){
        if (Schema::hasTable((new GuideList)->getTable())) {
            echo "Guide exists!";
        } 
        else{
            echo "Table does not exist!";
        }
      }
    function checkTourSale(Request $request){
        $userID = session('userID')->account_id_account;
        $tourData = Tour::where('owner_id',$userID)->where('status','ongoing')->get();
        dd($tourData);
    }
    function checkWorkInTour(Request $request){
        $userID = session('userID')->account_id_account;
        $workInTourData = TourHasGuideList::where('guide_list_account_id_account',$userID)->get();//ได้มาหลายข้อมูลเป็น array แน่ๆ
        $toursID =  $workInTourData->pluck('tour_id_tour');//ทำการนำ tourID ทั้งหมดที่ guide เคยทำมารวบอยู่ในตัวแปรเดียวเพื่อนำไป query ต่อ
        $tourData = Tour::whereIn('id_tour',$toursID)->where('status','finish');//เอาทัวร์ที่เสร็จแล้วเพราะเป็นอดีต
        // return view('workHistory',compact('tourData'));
    }
    // function checkAllPayment(Request $request){
    //     $userID = session('userID')->account_id_account;
    //     $toursIOwn = Tour::where('owner_id',$userID)->where('status','ongoing')->get();
    //     $paymentInTour = Payment::where('booking_Tour_id_Tour',);
    // }  
    function Offer(Request $request){
        $requestTourID = 1; // ของจริงจะได้มาจากตอนกด offer  ex $request->requestTourId
        return view('offerPage',compact('requestTourID'));
    }
    function addOffer(Request $request){
        $requestTourID = $request->requestTourID;
        $offerData = [
            "request_tour_id_request_tour" => $requestTourID,
            "from_who_offer" => "guide",
            "id_who_offer" => session('userID')->account_id_account,
            "contect" => $request->contect,
            "price" => $request->price,
            "description" => $request->description,
            "hotel" => $request->hotel,
            "hotel_price" => $request->hotelPrice,
            "travel" => $request->travel,
            "travel_price" => $request->travelPrice,
            "guide_qty" => $request->guideQTY,
            "status" => "new",
            "offer_date" => Carbon::now()->toDateTimeString()
        ];
        // Offer::insert($offerData);
    }
}
