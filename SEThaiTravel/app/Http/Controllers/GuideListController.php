<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\GuideList;
use App\Models\Tour;
use App\Models\TourHasGuideList;
use App\Models\LocationInTour;
use App\Models\Payment;
use App\Models\Offer;
use App\Models\Booking;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class GuideListController extends Controller
{
    function getHomePage()
    {
        return view('guide.home');
    }
    function checkTourSale(Request $request)
    {
        $userID = session('userID')->account_id_account;
        $tourData = Tour::where('owner_id', $userID)->where('status', 'ongoing')->get();
        dd($tourData);
    }
    function checkWorkInTour(Request $request)
    {
        $userID = session('userID')->account_id_account;
        $workInTourData = TourHasGuideList::where('guide_list_account_id_account', $userID)->get(); //ได้มาหลายข้อมูลเป็น array แน่ๆ
        $toursID =  $workInTourData->pluck('tour_id_tour'); //ทำการนำ tourID ทั้งหมดที่ guide เคยทำมารวบอยู่ในตัวแปรเดียวเพื่อนำไป query ต่อ
        $tourData = Tour::whereIn('id_tour', $toursID)->where('status', 'finish'); //เอาทัวร์ที่เสร็จแล้วเพราะเป็นอดีต
        // return view('workHistory',compact('tourData'));
    }
    // function checkAllPayment(Request $request){
    //     $userID = session('userID')->account_id_account;
    //     $toursIOwn = Tour::where('owner_id',$userID)->where('status','ongoing')->get();
    //     $paymentInTour = Payment::where('booking_Tour_id_Tour',);
    // }  
    function Offer(Request $request)
    {
        $requestTourID = 1; // ของจริงจะได้มาจากตอนกด offer  ex $request->requestTourId
        return view('offerPage', compact('requestTourID'));
    }
    function addOffer(Request $request)
    {
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

    public function getProvinces()
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Accept-Language' => 'th',
            'x-api-key' => env('TAT_API_KEY') // ใช้ค่า API Key จาก .env
        ])->get('https://tatdataapi.io/api/v2/location/provinces');

        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            return response()->json(['error' => 'Failed to fetch provinces'], 500);
        }
    }
    public function getHotelsByProvince($provinceId)
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Accept-Language' => 'th',
            'x-api-key' => env('TAT_API_KEY')
        ])->get("https://tatdataapi.io/api/v2/places?province_id=$provinceId&place_category_id=2&limit=300");

        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            return response()->json(['error' => 'ไม่สามารถดึงข้อมูลโรงแรมได้'], 500);
        }
    }
    public function getLocationsByProvince($provinceId)
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Accept-Language' => 'th',
            'x-api-key' => env('TAT_API_KEY')
        ])->get("https://tatdataapi.io/api/v2/places?province_id=$provinceId&place_category_id=3&limit=300");

        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            return response()->json(['error' => 'ไม่สามารถดึงข้อมูลสถานที่ท่องเที่ยวได้'], 500);
        }
    }
    function getAddTour()
    {
        return view('guide.addTour');
    }
    function addTour(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('images', 'public');
        } else {
            $path = NULL;
        }
        $locationInTourAPI = $request->location;
        $tourData = [
            "from_owner" => 'guide',
            "owner_id" => session('userID')->account_id_account,
            "name" => $request->tour_name,
            "Release_date" => Carbon::now()->toDateString(),
            "End_of_sale_date" => Carbon::now()->addDays(7)->toDateString(),
            "start_tour_date" => $request->start_date,
            "end_tour_date" => $request->end_date,
            "price" => $request->price,
            "tour_capacity" => $request->quantity,
            "contect" => $request->contact,
            "hotel" => $request->hotel,
            "hotel_price" => $request->hotelPrice,
            "description" => $request->description,
            "travel_by" => $request->travel_by,
            "status" => 'ongoing',
            "offer_id_offer" => NULL,
            "type_tour" => 'public',
            "tourImage" => $path
        ];
        $tour = new Tour($tourData);
        $tour->save();
        $tourId = $tour->id_tour;
        $tourHasGuideData = [
            "guide_list_account_id_account" => session('userID')->account_id_account,
            "tour_id_tour" => $tourId
        ];
        TourHasGuideList::insert($tourHasGuideData);
        foreach ($locationInTourAPI as $api) {
            $locationInTourData = [
                "loc_api" => "https://tatdataapi.io/api/v2/places/$api",
                "tour_id_tour" => $tourId
            ];
            LocationInTour::insert($locationInTourData);
        }
        return redirect('/guideHomePage');
    }
    function getMytour(Request $request)
    {
        $tourData = Tour::where('owner_id', session('userID')->account_id_account)
            ->paginate(10)->appends($request->query());
        return view('guide.myTour', compact('tourData'));
    }
    function searchMyTour(Request $request)
    {
        $status = $request->status;
        $name = $request->name;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $tourData = Tour::where('owner_id', session('userID')->account_id_account)
            ->where('status', 'LIKE', '%' . $status . '%');
        if (!empty($name)) {
            $tourData->whereRaw('LOWER(tour.name) LIKE LOWER(?)', ["%$name%"]);
        }

        // ✅ กรองวันที่เริ่มต้นทัวร์
        if (!empty($startDate)) {
            $tourData->whereDate('tour.start_tour_date', $startDate);
        }

        // ✅ กรองวันที่สิ้นสุดทัวร์
        if (!empty($endDate)) {
            $tourData->whereDate('tour.end_tour_date', $endDate);
        }
        $tourData = $tourData->paginate(10)->appends($request->query());
        return view('guide.myTour', compact('tourData'));
    }
    function deleteMyTour(Request $request)
    {
        $tourData = [
            "status" => 'cancal'
        ];
        Tour::where('id_tour', $request->tourID)->update($tourData);
        return redirect('/guideMyTour');
    }
    public function editMyTourPage(Request $request){
        $tourId = $request->tourID;
        $locationInTourAPI = LocationInTour::where('tour_id_tour',$tourId)->get();
        $tourData = Tour::where("id_tour",$tourId)->first();
        $locations = [];
        foreach($locationInTourAPI as $api){
            $locations[] = $this->getLocationsById($api->loc_api);
        }
        $provinceId = $locations[0]->original["location"]["province"]["provinceId"];
        return view('guide.editTour',compact('provinceId','locations','tourData'));

    }
    public function getLocationsById($api)
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Accept-Language' => 'th',
            'x-api-key' => env('TAT_API_KEY')
        ])->get("$api");

        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            return response()->json(['error' => 'ไม่สามารถดึงข้อมูลสถานที่ท่องเที่ยวได้'], 500);
        }
    }
    public function updateMyTour(Request $request){
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('images', 'public');
        } else {
            if(is_null($request->tourImage))
                $path = NULL;
            else
                $path = $request->tourImage;
        }
        $locationInTourAPI = $request->location;
        $tourData = [
            "from_owner" => 'guide',
            "owner_id" => session('userID')->account_id_account,
            "name" => $request->tour_name,
            "Release_date" => $request->Release,
            "End_of_sale_date" => $request->End,
            "start_tour_date" => $request->start_date,
            "end_tour_date" => $request->end_date,
            "price" => $request->price,
            "tour_capacity" => $request->quantity,
            "contect" => $request->contact,
            "hotel" => $request->hotel,
            "hotel_price" => $request->hotelPrice,
            "description" => $request->description,
            "travel_by" => $request->travel_by,
            "status" => 'ongoing',
            "offer_id_offer" => NULL,
            "type_tour" => 'public',
            "tourImage" => $path
        ];
        $tourId = $request->tourID;
        Tour::find($tourId)->update($tourData);
        LocationInTour::where('tour_id_tour',$tourId)->delete();
        foreach ($locationInTourAPI as $api) {
            $locationInTourData = [
                "loc_api" => "https://tatdataapi.io/api/v2/places/$api",
                "tour_id_tour" => $tourId
            ];
                LocationInTour::insert($locationInTourData);
            }
        return redirect('/guideMyTour');
    }
    public function getMyTourDetail(Request $request){
        $tourID = $request->tourID;
        $tourData = Tour::where('id_tour', $tourID)->first();
        $totalMember = Booking::where('tour_id_tour', $tourID) //TourID ใช้ของที่กดจองมา
        ->selectRaw('SUM(adult_qty + kid_qty) as Total_Member')
        ->value('Total_Member');
        $anotherReview = Review::join('booking', 'booking.id_booking', '=', 'review.booking_id_booking')
                        ->join('tour', 'tour.id_tour', '=', 'booking.tour_id_tour')
                        ->join('user_list', 'user_list.account_id_account', '=', 'review.user_list_account_id_account')
                        ->where('tour.id_tour', $tourID)
                        ->select('review.*', 'user_list.*') // เลือกเฉพาะคอลัมน์ที่ต้องการ
                        ->get();
        $locationInTourAPI = LocationInTour::where('tour_id_tour',$tourID)->get();
        $locations = [];
        foreach($locationInTourAPI as $api){
            $locations[] = $this->getLocationsById($api->loc_api);
        }
        return view('guide.detailMyTour', compact('totalMember', 'tourData','anotherReview','locations'));
    }
    public function getMyJob(Request $request){
        $tourData = Tour::join('Tour_has_guide_list', 'tour.id_tour', '=', 'Tour_has_guide_list.tour_id_tour')
                ->where('Tour_has_guide_list.guide_list_account_id_account', session('userID')->account_id_account)
                ->where('tour.status','LIKE','ongoing')
                ->paginate(10)->appends($request->query());
        return view('guide.myJob',compact('tourData'));
    }
    public function getMyJobDetail(Request $request){
        $tourID = $request->tourID;
        $tour = Tour::where('id_tour', $tourID)->first();
        switch ($tour->from_owner) {
            case "guide":
              $tourData = Tour::join('guide_list', 'tour.owner_id', '=', 'guide_list.account_id_account')
                ->where('tour.id_tour', $tourID)
                ->select('tour.*', 'guide_list.name as guide_name', 'guide_list.surname as guide_surname')
                ->first();
              break;
            case "corp":
              $tourData = Tour::join('corp_list', 'tour.owner_id', '=', 'corp_list.account_id_account')
                ->where('tour.id_tour', $tourID)
                ->select('tour.*', 'corp_list.name as corp_name')
                ->first();
              break;
        }
        $totalMember = Booking::where('tour_id_tour', $tourID) //TourID ใช้ของที่กดจองมา
        ->selectRaw('SUM(adult_qty + kid_qty) as Total_Member')
        ->value('Total_Member');
        $anotherReview = Review::join('booking', 'booking.id_booking', '=', 'review.booking_id_booking')
                        ->join('tour', 'tour.id_tour', '=', 'booking.tour_id_tour')
                        ->join('user_list', 'user_list.account_id_account', '=', 'review.user_list_account_id_account')
                        ->where('tour.id_tour', $tourID)
                        ->select('review.*', 'user_list.*') // เลือกเฉพาะคอลัมน์ที่ต้องการ
                        ->get();
        $locationInTourAPI = LocationInTour::where('tour_id_tour',$tourID)->get();
        $locations = [];
        foreach($locationInTourAPI as $api){
            $locations[] = $this->getLocationsById($api->loc_api);
        }
        return view('guide.detailMyJob', compact('totalMember', 'tourData','anotherReview','locations'));
    }
    public function searchMyJob(Request $request){
        $status = $request->status;
        $name = $request->name;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $tourData=Tour::join('Tour_has_guide_list', 'tour.id_tour', '=', 'Tour_has_guide_list.tour_id_tour')
            ->where('Tour_has_guide_list.guide_list_account_id_account', session('userID')->account_id_account)
            ->where('tour.status', 'LIKE', '%' . $status . '%');
        if (!empty($name)) {
            $tourData->whereRaw('LOWER(tour.name) LIKE LOWER(?)', ["%$name%"]);
          }
      
          // ✅ กรองวันที่เริ่มต้นทัวร์
        if (!empty($startDate)) {
            $tourData->whereDate('tour.start_tour_date', $startDate);
        }
      
          // ✅ กรองวันที่สิ้นสุดทัวร์
        if (!empty($endDate)) {
            $tourData->whereDate('tour.end_tour_date', $endDate);
        }
        $tourData = $tourData->paginate(10)->appends($request->query());
        return view('guide.myJob',compact('tourData'));
    }
    public function getJobHistory(Request $request){
        $tourData = Tour::join('Tour_has_guide_list', 'tour.id_tour', '=', 'Tour_has_guide_list.tour_id_tour')
        ->where('Tour_has_guide_list.guide_list_account_id_account', session('userID')->account_id_account)
        ->where('tour.status','LIKE','ongoing')
        ->paginate(10)->appends($request->query());
        return view('guide.myJob',compact('tourData'));
    }
}
