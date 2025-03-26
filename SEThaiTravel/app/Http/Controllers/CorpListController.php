<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\CorpList;
use Carbon\Carbon;
use App\Models\RequestTour;
use App\Models\TourHasGuideList;
use App\Models\Tour;
use App\Models\Offer;
use App\Models\GuideList;
use App\Models\Booking;
use App\Models\UserList;
use App\Models\Review;
use App\Models\Account;
use App\Models\LocationInTour;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CorpListController extends Controller
{
    function checkTable()
    {
        if (Schema::hasTable((new CorpList)->getTable())) {
            echo "Corp exists!";
        } else {
            echo "Table does not exist!";
        }
    }
    //เสร็จแล้ว
    function getHomePage()
    {
        return view('corporation.home');
    }

    public function searchAll(Request $request)
    {
        $name = $request->searchKey;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $type = $request->type;
        $path = $_SERVER['REQUEST_URI'];
        if ($type == "tour") {
            $searchTourData = Tour::where('status', 'LIKE', 'ongoing');
            if (is_numeric($name)) {
                $searchTourData->where('offer_id_offer', '=', $name)->where('type_tour', 'LIKE', 'private');
                if (!empty($startDate)) {
                    $searchTourData->whereDate('tour.start_tour_date', $startDate);
                }
                // ✅ กรองวันที่สิ้นสุดทัวร์
                if (!empty($endDate)) {
                    $searchTourData->whereDate('tour.end_tour_date', $endDate);
                }
            } else {
                if (!empty($name)) {
                    $searchTourData->whereRaw('LOWER(tour.name) LIKE LOWER(?)', ["%$name%"]);
                }
                if (!empty($startDate)) {
                    $searchTourData->whereDate('tour.start_tour_date', $startDate);
                }
                // ✅ กรองวันที่สิ้นสุดทัวร์
                if (!empty($endDate)) {
                    $searchTourData->whereDate('tour.end_tour_date', $endDate);
                }
                $searchTourData->where('type_tour', 'LIKE', 'public');
            }
            $searchTourData = $searchTourData->paginate(5)->appends($request->query());
            $totalData = $searchTourData->count();
            $ownerData = [];
            $totalMember = [];
            $ownerScore = [];
            for ($i = 0; $i < $totalData; $i++) { //อันนหาหาข้อมูลของเจ้าของทัวร์นั้นๆแล้วส่งไปใน view ด้วยเผื่อใช้
                switch ($searchTourData[$i]->from_owner) {
                    case "guide":
                        $ownerData[] = GuideList::where('account_id_account', '=', $searchTourData[$i]->owner_id)->first();
                        $ownerScore[] = Review::leftJoin('guide_list', 'review.guide_list_account_id_account', '=', 'guide_list.account_id_account')
                            ->where('guide_list.account_id_account', $searchTourData[$i]->owner_id) // กรองเฉพาะ owner_id ที่ต้องการ
                            ->selectRaw('COUNT(*) as total_reviews, AVG(review.sp_score) as average_score')
                            ->first();
                        break;
                    case "corp":
                        $ownerData[] = CorpList::find($searchTourData[$i]->owner_id)->first();
                        $ownerScore[] = Review::leftJoin('booking', 'review.booking_id_booking', '=', 'booking.id_booking')
                            ->leftJoin('tour', function ($join) {
                                $join->on('tour.id_tour', '=', 'booking.tour_id_tour')
                                    ->where('tour.from_owner', 'LIKE', 'corp');
                            })
                            ->leftJoin('corp_list', 'corp_list.account_id_account', '=', 'tour.owner_id')
                            ->where('corp_list.account_id_account', $searchTourData[$i]->owner_id)
                            ->selectRaw('COUNT(*) as total_reviews, AVG(review.sp_score) as average_score')
                            ->first(); // ใช้ `first()` เพราะดึงแค่บริษัทเดียว
                        break;
                }
                $totalMember[] = Booking::where('tour_id_tour', $searchTourData[$i]->id_tour) //TourID ใช้ของที่กดจองมา
                    ->where('status', 'NOT LIKE', 'cancel')
                    ->selectRaw('SUM(adult_qty + kid_qty) as Total_Member')
                    ->value('Total_Member');
            }
            return view('corporation.searchTour', compact('ownerData', 'searchTourData', 'totalMember', 'ownerScore', 'path'));
        } else {
            $searchRequestData = RequestTour::where('request_status', 'ongoing');
            if (!empty($name)) {
                $searchRequestData->whereRaw('LOWER(request_tour.name) LIKE LOWER(?)', ["%$name%"]);
            }
            if (!empty($startDate)) {
                $searchRequestData->whereDate('request_tour.start_tour_date', $startDate);
            }
            // ✅ กรองวันที่สิ้นสุดทัวร์
            if (!empty($endDate)) {
                $searchRequestData->whereDate('request_tour.end_tour_date', $endDate);
            }
            $searchRequestData = $searchRequestData->paginate(5)->appends($request->query());
            $ownerData = [];
            foreach ($searchRequestData as $data) { //อันนหาหาข้อมูลของเจ้าของทัวร์นั้นๆแล้วส่งไปใน view ด้วยเผื่อใช้
                $ownerData[] =  UserList::where('account_id_account', $data->user_list_account_id_account)->first();
            }
            return view('corporation.searchRequest', compact('ownerData', 'searchRequestData', 'path'));
        }
    }
    public function searchFilter(Request $request)
    {
        $name = $request->searchKey;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $type = $request->type;
        $minBudget = $request->minBudget;
        $maxBudget = $request->maxBudget;
        $path = $_SERVER['REQUEST_URI'];
        if ($type == "tour") {
            $searchTourData = Tour::where('status', 'LIKE', 'ongoing');
            if (is_numeric($name)) {
                $searchTourData->where('offer_id_offer', '=', $name)->where('type_tour', 'LIKE', 'private');
                if (!empty($startDate)) {
                    $searchTourData->whereDate('tour.start_tour_date', $startDate);
                }
                // ✅ กรองวันที่สิ้นสุดทัวร์
                if (!empty($endDate)) {
                    $searchTourData->whereDate('tour.end_tour_date', $endDate);
                }
            } else {
                if (!empty($name)) {
                    $searchTourData->whereRaw('LOWER(tour.name) LIKE LOWER(?)', ["%$name%"]);
                }
                if (!empty($startDate)) {
                    $searchTourData->whereDate('tour.start_tour_date', $startDate);
                }
                // ✅ กรองวันที่สิ้นสุดทัวร์
                if (!empty($endDate)) {
                    $searchTourData->whereDate('tour.end_tour_date', $endDate);
                }
                $searchTourData->whereBetween('tour.price', [floatval($minBudget), floatval($maxBudget)])
                    ->where('type_tour', 'LIKE', 'public');
            }
            $searchTourData = $searchTourData->paginate(5)->appends($request->query());
            $totalData = $searchTourData->count();
            $ownerData = [];
            $totalMember = [];
            $ownerScore = [];
            for ($i = 0; $i < $totalData; $i++) { //อันนหาหาข้อมูลของเจ้าของทัวร์นั้นๆแล้วส่งไปใน view ด้วยเผื่อใช้
                switch ($searchTourData[$i]->from_owner) {
                    case "guide":
                        $ownerData[] = GuideList::where('account_id_account', '=', $searchTourData[$i]->owner_id)->first();
                        $ownerScore[] = Review::leftJoin('guide_list', 'review.guide_list_account_id_account', '=', 'guide_list.account_id_account')
                            ->where('guide_list.account_id_account', $searchTourData[$i]->owner_id) // กรองเฉพาะ owner_id ที่ต้องการ
                            ->selectRaw('COUNT(*) as total_reviews, AVG(review.sp_score) as average_score')
                            ->first();
                        break;
                    case "corp":
                        $ownerData[] = CorpList::find($searchTourData[$i]->owner_id)->first();
                        $ownerScore[] = Review::leftJoin('booking', 'review.booking_id_booking', '=', 'booking.id_booking')
                            ->leftJoin('tour', function ($join) {
                                $join->on('tour.id_tour', '=', 'booking.tour_id_tour')
                                    ->where('tour.from_owner', 'LIKE', 'corp');
                            })
                            ->leftJoin('corp_list', 'corp_list.account_id_account', '=', 'tour.owner_id')
                            ->where('corp_list.account_id_account', $searchTourData[$i]->owner_id)
                            ->selectRaw('COUNT(*) as total_reviews, AVG(review.sp_score) as average_score')
                            ->first(); // ใช้ `first()` เพราะดึงแค่บริษัทเดียว
                        break;
                }
                $totalMember[] = Booking::where('tour_id_tour', $searchTourData[$i]->id_tour) //TourID ใช้ของที่กดจองมา
                    ->where('status', 'NOT LIKE', 'cancel')
                    ->selectRaw('SUM(adult_qty + kid_qty) as Total_Member')
                    ->value('Total_Member');
            }
            return view('corporation.searchTour', compact('ownerData', 'searchTourData', 'totalMember', 'ownerScore', 'path'));
        } else {
            $searchRequestData = RequestTour::where('request_status', 'ongoing');
            if (!empty($name)) {
                $searchRequestData->whereRaw('LOWER(request_tour.name) LIKE LOWER(?)', ["%$name%"]);
            }
            if (!empty($startDate)) {
                $searchRequestData->whereDate('request_tour.start_tour_date', $startDate);
            }
            // ✅ กรองวันที่สิ้นสุดทัวร์
            if (!empty($endDate)) {
                $searchRequestData->whereDate('request_tour.end_tour_date', $endDate);
            }
            $searchRequestData->where('start_price', '>=', floatval($minBudget))
                ->where('max_price', '<=', floatval($maxBudget));
            $searchRequestData = $searchRequestData->paginate(5)->appends($request->query());
            $ownerData = [];
            foreach ($searchRequestData as $data) { //อันนหาหาข้อมูลของเจ้าของทัวร์นั้นๆแล้วส่งไปใน view ด้วยเผื่อใช้
                $ownerData[] =  UserList::where('account_id_account', $data->user_list_account_id_account)->first();
            }
            return view('corporation.searchRequest', compact('ownerData', 'searchRequestData', 'path'));
        }
    }
    public function getSearchTourDetail(Request $request)
    {
        $tourID = $request->tourID;
        $path = $request->path;
        $tour = Tour::where('id_tour', $tourID)->first();
        switch ($tour->from_owner) {
            case "guide":
                $tourData = Tour::join('guide_list', 'tour.owner_id', '=', 'guide_list.account_id_account')
                    ->where('tour.id_tour', $tourID)
                    ->select('tour.*', 'guide_list.name as guide_name', 'guide_list.surname as guide_surname', 'guide_list.phonenumber')
                    ->first();
                $Review =  Review::join('user_list', 'review.user_list_account_id_account', '=', 'user_list.account_id_account')
                    ->where('guide_list_account_id_account', $tour->owner_id)
                    ->select('review.*', 'user_list.*') // เลือกคอลัมน์ทั้งหมดจากทั้ง 2 ตาราง
                    ->get();
                break;
            case "corp":
                $tourData = Tour::join('corp_list', 'tour.owner_id', '=', 'corp_list.account_id_account')
                    ->where('tour.id_tour', $tourID)
                    ->select('tour.*', 'corp_list.name as corp_name', 'corp_list.phone_number')
                    ->first();
                $Review = Review::select('user_list.name', 'user_list.surname', 'tour.from_owner', 'tour.owner_id', 'review.score', 'review.message')
                    ->join('booking', 'booking.id_booking', '=', 'review.booking_id_booking')
                    ->join('tour', 'tour.id_tour', '=', 'booking.tour_id_tour')
                    ->join('user_list', 'user_list.account_id_account', '=', 'review.user_list_account_id_account')
                    ->where('tour.owner_id', $tour->owner_id)
                    ->get();
                break;
        }
        $totalMember = Booking::where('tour_id_tour', $tourID) //TourID ใช้ของที่กดจองมา
            ->selectRaw('SUM(adult_qty + kid_qty) as Total_Member')
            ->value('Total_Member');
        $locationInTourAPI = LocationInTour::where('tour_id_tour', $tourID)->get();
        $locations = [];
        foreach ($locationInTourAPI as $api) {
            $locations[] = $this->getLocationsById($api->loc_api);
        }
        return view('corporation.detailSearchTour', compact('totalMember', 'tourData', 'Review', 'locations', 'path'));
    }
    public function getSearchRequestDetail(Request $request)
    {
        $requestID = $request->requestID;
        $path = $request->path;
        $requestData = RequestTour::join('user_list', 'request_tour.user_list_account_id_account', '=', 'user_list.account_id_account')
            ->where('id_request_tour', $requestID)
            ->select('request_tour.*', 'user_list.name as uName', 'user_list.surname', 'user_list.phonenumber')  // เลือกคอลัมน์ทั้งหมดจากทั้ง 2 ตาราง
            ->first();
        return view('corporation.detailSearchRequest', compact('requestData', 'path'));
    }

    //เสร็จแล้ว
    function getAddTour()
    {
        $idAccount = session('userID')->account_id_account;
        $guides = DB::table('guide_list')
            ->where('corp_list_account_id_account', $idAccount)
            ->get();
        return view('corporation.addTour', compact('guides'));
    }
    //เสร็จแล้ว
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
        $guideInCorp = $request->guideList;
        $tourData = [
            "from_owner" => 'corp',
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
        foreach ($guideInCorp as $guide) {
            $guideInTour = [
                "guide_list_account_id_account" => $guide,
                "tour_id_tour" => $tourId
            ];
            TourHasGuideList::insert($guideInTour);
        }
        // dd($locationInTourAPI);
        foreach ($locationInTourAPI as $api) {
            $locationInTourData = [
                "loc_api" => "https://tatdataapi.io/api/v2/places/$api",
                "tour_id_tour" => $tourId
            ];
            LocationInTour::insert($locationInTourData);
        }

        return redirect('/corpHomepage');
    }

    //เอารายการสินค้าทั้งหมด ทำเเล้ว
    function getTour(Request $request)
    {
        $idAccount = session('userID')->account_id_account;
        $tours = DB::table('tour')
            ->where('from_owner', 'LIKE', 'corp')
            ->where('owner_id', $idAccount)
            ->where('end_tour_date', '>', now())
            ->paginate(10)->appends($request->query());
        // dd($tours);
        return view('corporation.myTour', compact('tours'));
    }

    function viewProductDetail(Request $request)
    {
        $tourID = $request->tourID;
        $path = $request->path;
        $tourData = Tour::where('id_tour', $tourID)->first();
        switch ($tourData->from_owner) {
            case "guide":
                $productData = Tour::join('guide_list', 'tour.owner_id', '=', 'guide_list.account_id_account')
                    ->where('tour.id_tour', $tourID)
                    ->select('tour.*', 'guide_list.name as guide_name', 'guide_list.surname as guide_surname')
                    ->first();
                break;
            case "corp":
                $productData = Tour::join('corp_list', 'tour.owner_id', '=', 'corp_list.account_id_account')
                    ->where('tour.id_tour', $tourID)
                    ->select('tour.*', 'corp_list.name as corp_name')
                    ->first();
                break;
        }
        $totalMember = Booking::where('tour_id_tour', $tourID) //TourID ใช้ของที่กดจองมา
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
        return view('customer.detailSearch', compact('path', 'totalMember', 'productData'));
    }
    // แสดงรายละเอียดของสินค้าของ tour ที่เลือก
    function getMyTourDetail(Request $request)
    {
        $tourID = $request->tourID;
        $tourData = Tour::where('id_tour', $tourID)->first();
        $totalMember = Booking::where('tour_id_tour', $tourID) //TourID ใช้ของที่กดจองมา
            ->selectRaw('SUM(adult_qty + kid_qty) as Total_Member')
            ->value('Total_Member');
        // $anotherReview = Review::join('booking', 'booking.id_booking', '=', 'review.booking_id_booking')
        //                 ->join('tour', 'tour.id_tour', '=', 'booking.tour_id_tour')
        //                 ->join('user_list', 'user_list.account_id_account', '=', 'review.user_list_account_id_account')
        //                 ->where('tour.id_tour', $tourID)
        //                 ->select('review.*', 'user_list.*') // เลือกเฉพาะคอลัมน์ที่ต้องการ
        //                 ->get();
        $guideintour = DB::table('Tour_has_guide_list')
            ->join('guide_list', 'guide_list.account_id_account', '=', 'Tour_has_guide_list.guide_list_account_id_account')
            ->where('Tour_has_guide_list.tour_id_tour', $tourID)
            ->get();

        $locationInTourAPI = LocationInTour::where('tour_id_tour', $tourID)->get();
        $locations = [];
        foreach ($locationInTourAPI as $api) {
            $locations[] = $this->getLocationsById($api->loc_api);
        }

        return view('corporation.detailMyTour', compact('totalMember', 'tourData', 'guideintour', 'locations'));
    }


    public function editMyTourPage(Request $request)
    {

        $tourId = $request->tourID;
        // dd( $tourId);
        $locationInTourAPI = LocationInTour::where('tour_id_tour', $tourId)->get();
        $tourData = Tour::where("id_tour", $tourId)->first();
        $locations = [];
        // $guideintour = [];
        $guideintour = DB::table('Tour_has_guide_list')
            ->join('guide_list', 'guide_list.account_id_account', '=', 'Tour_has_guide_list.guide_list_account_id_account')
            ->where('Tour_has_guide_list.tour_id_tour', $tourId)
            ->get();
        // dd($guideintour);
        foreach ($locationInTourAPI as $api) {
            $locations[] = $this->getLocationsById($api->loc_api);
        }
        $provinceId = $locations[0]->original["location"]["province"]["provinceId"];
        return view('corporation.editTour', compact('provinceId', 'locations', 'tourData', 'guideintour'));
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

    function getLocationsById($api)
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

    //เอารายการสินค้าที่หมดอายุทั้งหมด
    function getHistory(Request $request)
    {
        $idAccount = session('userID')->account_id_account;
        $histours = DB::table('tour')
            ->where('from_owner', 'LIKE', 'corp')
            ->where('owner_id', $idAccount)
            ->where('end_tour_date', '<', now())
            ->paginate(10)->appends($request->query());
        //dd($histours);
        return view('corporation.sellHistory', compact('histours'));
    }

    //เสร็จแล้ว
    function getAddOffer(Request $request)
    {
        $offer = $request->tourID;
        // dd($offer);
        $requestTour = RequestTour::where('id_request_tour', $offer)->first();
        // dd($requestTour);
        return view('corporation.addOffer', compact('requestTour'));
    }

    //เสร็จแล้ว
    function addOffer(Request $request)
    {
        $idAccount = session('userID')->account_id_account;
        $offerData = [
            'request_tour_id_request_tour' => $request->request_tourID,
            'from_who_offer' => 'corp',
            'id_who_offer' => $idAccount,
            'contect' => $request->contect,
            'price' => $request->price,
            'description' => $request->description,
            'hotel' => $request->hotel,
            'hotel_price' => $request->hotel_price,
            'travel' => $request->travel,
            'travel_price' => $request->travel_price,
            'guide_qty' => $request->guide_qty,
            'status' => 'new',
            'offer_date' => Carbon::now()->toDateString(),
        ];
        Offer::insert($offerData);
        return redirect('/corpOffer');
    }
//
    
    
   
//



    //เสร็จแล้ว
    function getOffer(Request $request){
        $idAccount = session('userID')->account_id_account;
        $requestTours = RequestTour::join('offer as o', 'o.request_tour_id_request_tour', '=', 'request_tour.id_request_tour')
            ->where('o.id_who_offer', $idAccount)
            ->select('request_tour.*')
            ->paginate(10)->appends($request->query());
        return view('corporation.myOffer', compact('requestTours'));
    }
    //เสร็จแล้ว
    function getOfferDetail(Request $request){
        $idAccount = session('userID')->account_id_account;
        $offerByMe = DB::table('offer')
            ->where('id_who_offer', $idAccount)
            ->where('request_tour_id_request_tour', $request->requestID)
            ->get();
        $offerInRequest= DB::table('offer')
            ->where('request_tour_id_request_tour', $request->requestID)
            ->get();
        $RequestDetail = DB::table('request_tour')
            ->where('id_request_tour', $request->requestID)
            ->first();
            dd($offerByMe, $offerInRequest,$RequestDetail);
        return view('corporation.detailMyOffer', compact('offerByMe'), compact('RequestDetail'), compact('offerInRequest'));
    }

    //เสร็จแล้ว
    function toEditOffer(Request $request){
        $OfferID = $request->offerID;
        return view('corporation.editOffer', compact('OfferID'));
    }
    //เสร็จแล้ว
    function updateMyOffer(Request $request){
        $idOffer = $request->offerID;
        $validated = $request->validate([
            'contect' => $request->contect,
            'price' => $request->price,
            'description' => $request->description,
            'hotel' => $request->hotel,
            'hotel_price' => $request->hotel_price,
            'travel' => $request->travel,
            'travel_price' => $request->travel_price,
            'guide_qty' => $request->guide_qty,
            'status' => 'new'
        ]);
        DB::table('offer')
            ->where('id_offer', $idOffer)
            ->update($validated);
        return redirect('/corpOffer');
    }
    //เสร็จแล้ว
    function getStaffInCorp(Request $request){
        $idAccount = session('userID')->account_id_account;
        $guides = DB::table('guide_list')
            ->where('corp_list_account_id_account', $idAccount)
            ->paginate(25)->appends($request->query());
        // dd($guides);
        return view('corporation.myStaf', compact('guides'));
    }
    //ยังไม่เทส
    function staffDetail(Request $request){
        $guideID = $request->guideID;
        $idAccount = session('userID')->account_id_account;
        $guideInfo = GuideList::where('account_id_account', $guideID)->get();
        $guideWork = DB::table('guide_list as g')
            ->join('Tour_has_guide_list as thg', 'thg.guide_list_account_id_account', '=', 'g.account_id_account')
            ->join('tour as t', 't.id_tour', '=', 'thg.tour_id_tour')
            ->where('g.account_id_account', $guideID)
            ->where('t.owner_id', $idAccount)
            ->select('g.*', 't.*', 'thg.*')
            ->get();

        $guideScore = Review::leftJoin('guide_list', 'review.guide_list_account_id_account', '=', 'guide_list.account_id_account')
            ->where('guide_list.account_id_account', $idAccount)
            ->selectRaw('COUNT(*) as total_reviews, AVG(review.sp_score) as average_score')
            ->first();
        //dd($guideWork);
        return view('corporation.profile', compact('guideInfo', 'guideWork', 'guideScore'));
    }
    //เสร็จแล้ว
    function getAllPaymentHistory(Request $request){
        $idAccount = session('userID')->account_id_account;
        $payments = DB::table('payment as p')
            ->join('booking as b', 'b.id_booking', '=', 'p.booking_Tour_id_Tour')
            ->join('tour as t', 't.id_tour', '=', 'b.tour_id_tour')
            ->join('user_list', 'user_list.account_id_account', '=', 'p.booking_user_list_account_id_account')
            ->join('corp_list as c', function ($join) {
                $join->on('c.account_id_account', '=', 't.owner_id')
                    ->where('t.from_owner', 'LIKE', 'corp');
            })
            ->where('c.account_id_account', $idAccount)
            ->select(
                'p.id_payment',
                'p.booking_Tour_id_Tour',
                'p.booking_user_list_account_id_account',
                'p.payment_date',
                'p.checknumber',
                'p.total_price',
                'b.tour_id_tour',
                'b.id_booking',
                'user_list.name',
                'user_list.surname'
            )
            ->paginate(25)->appends($request->query());
        //dd($payments);
        return view('corporation.allPayments', compact('payments'));
    }
    //เสร็จแล้ว
    function getPaymentDetail(Request $request){
        $userID = $request->userID;
        $tourID = $request->tourID;
        $paymentID = $request->paymentID;
        $bookingID = $request->bookingID;
        $paymentData = Payment::where('id_payment', $paymentID)->first();
        $tourData = Tour::where('id_tour', $tourID)->first();
        $userData = UserList::where('account_id_account', $userID)->first();
        $bookingData = Booking::where('id_booking', $bookingID)->first();
        return view('corporation.paymentDetail', compact('paymentData', 'tourData', 'userData', 'bookingData'));
    }
    public function searchPayment(Request $request){
        $searchKey = $request->searchKey;
        $date = $request->paymentDate;
        $idAccount = session('userID')->account_id_account;
        $payments = DB::table('payment as p')
            ->join('booking as b', 'b.id_booking', '=', 'p.booking_Tour_id_Tour')
            ->join('tour as t', 't.id_tour', '=', 'b.tour_id_tour')
            ->join('user_list', 'user_list.account_id_account', '=', 'p.booking_user_list_account_id_account')
            ->join('corp_list as c', function ($join) {
                $join->on('c.account_id_account', '=', 't.owner_id')
                    ->where('t.from_owner', 'LIKE', 'corp');
            })
            ->where('c.account_id_account', $idAccount);
        if (!empty($date)) {
            $payments->whereDate('p.payment_date', $date);
        }
        if (!empty($searchKey)) {
            $payments->where('t.id_tour', 'LIKE', "%$searchKey%")
                ->orWhere('p.checknumber', 'LIKE', "%$searchKey%");
        }
        $payments = $payments->select(
            'p.id_payment',
            'p.booking_Tour_id_Tour',
            'p.booking_user_list_account_id_account',
            'p.payment_date',
            'p.checknumber',
            'p.total_price',
            'b.tour_id_tour',
            'b.id_booking',
            'user_list.name',
            'user_list.surname'
        )->get();
        // dd($payments);
        return view('corporation.allPayments', compact('payments'));
    }
    //เสร็จแล้ว
    public function getStatistic(){
        $userID = session('userID')->account_id_account;
        $touristPerMonth = Booking::selectRaw("DATE_FORMAT(booked_date, '%Y-%m') as YM, SUM(adult_qty + kid_qty) as tourListPerMonth")
            ->where('status', 'paid')
            ->groupBy('YM')
            ->orderBy('YM')
            ->get();
        $touristPerYear = DB::table('booking')
            ->selectRaw("DATE_FORMAT(booking.booked_date, '%Y') as YM, SUM(booking.adult_qty + booking.kid_qty) as tourListPerYear")
            ->where('booking.status', 'paid')
            ->whereRaw("DATE_FORMAT(booking.booked_date, '%Y') = YEAR(NOW())")
            ->groupBy(DB::raw("DATE_FORMAT(booking.booked_date, '%Y')"))
            ->orderBy('YM')
            ->get();
        $revenuePerMonth = Booking::join('tour', 'tour.id_tour', '=', 'booking.tour_id_tour')
            ->join('guide_list', 'guide_list.account_id_account', '=', 'tour.owner_id')
            ->selectRaw("DATE_FORMAT(booking.booked_date, '%Y-%m') as YM, SUM(booking.total_price) as RevenuePerMonth")
            ->where('booking.status', 'paid')
            ->where('tour.owner_id', session('userID')->account_id_account)
            ->groupBy('YM')
            ->orderByDesc('YM')
            ->get();
        $revenuePerYear = DB::table(DB::raw("(
            SELECT
                DATE_FORMAT(booking.booked_date, \"%Y-%m\") as YM,
                SUM(booking.total_price) as RevenuePerMonth
            FROM booking
            INNER JOIN tour ON tour.id_tour = booking.tour_id_tour
            INNER JOIN guide_list ON guide_list.account_id_account = tour.owner_id
            WHERE booking.status = \"paid\"
            AND tour.owner_id = $userID
            AND DATE_FORMAT(booking.booked_date, \"%Y\") = YEAR(NOW())
            GROUP BY YM
            ORDER BY YM DESC
        ) AS revenue"))
            ->selectRaw('SUM(revenue.RevenuePerMonth) AS revenuePerYear')
            ->get();

        $avgTourist = DB::table(DB::raw('(SELECT DATE_FORMAT(booking.booked_date, "%Y-%m") as YM, 
                SUM(booking.adult_qty + booking.kid_qty) as tourListPerMonth 
                FROM booking
                WHERE booking.status = "paid"
                GROUP BY YM
                ORDER BY YM DESC) AS Tourist'))
            ->selectRaw('SUM(Tourist.tourListPerMonth) / 12 AS avgTourist')
            ->get();
        $avgRevenue = DB::table(DB::raw("(
            SELECT
                DATE_FORMAT(booking.booked_date, \"%Y-%m\") as YM,
                SUM(booking.total_price) as RevenuePerMonth
            FROM booking
            INNER JOIN tour ON tour.id_tour = booking.tour_id_tour
            INNER JOIN guide_list ON guide_list.account_id_account = tour.owner_id
            WHERE booking.status = \"paid\"
            AND tour.owner_id = $userID
            AND DATE_FORMAT(booking.booked_date, \"%Y\") = YEAR(NOW())
            GROUP BY YM
            ORDER BY YM DESC
        ) AS revenue"))
            ->selectRaw('SUM(revenue.RevenuePerMonth) /12 AS avgRevenue')
            ->get();
        //dd($revenuePerYear);
        return view('corporation.statistic', compact('touristPerMonth', 'touristPerYear', 'revenuePerMonth', 'revenuePerYear', 'avgTourist', 'avgRevenue'));
    }


    function viewProfile(){
        $id = session('userID')->account_id_account;
        $accountData = Account::where('id_account', $id)->first();
        $userData = CorpList::where('account_id_account', $id)->first();
        $countrys =  AccountController::getCountry();
        return view('corporation.profile', compact('accountData', 'userData', 'countrys'));
    }
    function updateUser(Request $request){

        $idAccount = session('userID')->account_id_account;
        $user = CorpList::where('account_id_account', $idAccount)->first();
        $acc = Account::where('id_account', $idAccount)->first();
        if (!$acc) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'country' => $request->country,
            'postcode' => $request->postcode,
        ]);
        $acc->update([
            'username' => $request->username
        ]);

        return redirect('/corpProfile');
    }
    function updateImage(Request $request)
    {
        // ตรวจสอบว่ามี user อยู่หรือไม่
        $idAccount = session('userID')->account_id_account;
        $user = CorpList::where('account_id_account', $idAccount)->first();


        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('images', 'public');
        } else {
            if (is_null($request->image))
                $path = NULL;
            else
                $path = $request->image;
        }
        // อัปเดตข้อมูล
        $user->update([
            'logo' => $path
        ]);

        return redirect('/corpProfile');
    }
}
