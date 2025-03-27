<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\GuideList;
use App\Models\Tour;
use App\Models\TourHasGuideList;
use App\Models\LocationInTour;
use App\Models\Payment;
use App\Models\Offer;
use App\Models\Booking;
use App\Models\Review;
use App\Models\RequestTour;
use App\Models\UserList;
use App\Models\CorpList;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

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
        $totalMember = [];
        foreach ($tourData as $tour) {
            $totalMember[] = Booking::where('tour_id_tour', $tour->id_tour) //TourID ใช้ของที่กดจองมา
                ->where('status','NOT LIKE','cancel')
                ->selectRaw('SUM(adult_qty + kid_qty) as Total_Member')
                ->value('Total_Member');
        }
        return view('guide.myTour', compact('tourData', 'totalMember'));
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
    public function editMyTourPage(Request $request)
    {
        $tourId = $request->tourID;
        $locationInTourAPI = LocationInTour::where('tour_id_tour', $tourId)->get();
        $tourData = Tour::where("id_tour", $tourId)->first();
        $locations = [];
        foreach ($locationInTourAPI as $api) {
            $locations[] = $this->getLocationsById($api->loc_api);
        }
        $provinceId = $locations[0]->original["location"]["province"]["provinceId"];
        return view('guide.editTour', compact('provinceId', 'locations', 'tourData'));
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
    public function updateMyTour(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('images', 'public');
        } else {
            if (is_null($request->tourImage))
                $path = NULL;
            else
                $path = $request->tourImage;
        }
        $locationInTourAPI = $request->location;
        $tourData = [
            "from_owner" => 'corp',
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
        LocationInTour::where('tour_id_tour', $tourId)->delete();
        foreach ($locationInTourAPI as $api) {
            $locationInTourData = [
                "loc_api" => "https://tatdataapi.io/api/v2/places/$api",
                "tour_id_tour" => $tourId
            ];
            LocationInTour::insert($locationInTourData);
        }

        $selectedGuides = $request->input('guideintour', []);

        // ลบข้อมูลไกด์เก่าก่อน
        DB::table('Tour_has_guide_list')->where('tour_id_tour', $tourId)->delete();

        // เพิ่มข้อมูลไกด์ที่เลือกใหม่เข้าไป
        foreach ($selectedGuides as $guideId) {
            DB::table('Tour_has_guide_list')->insert([
                'tour_id_tour' => $tourId,
                'guide_list_account_id_account' => $guideId
            ]);
        }
        return redirect('/corpMyTour');
    }
    public function getMyTourDetail(Request $request)
    {
        $tourID = $request->tourID;
        $tourData = Tour::where('id_tour', $tourID)->first();
        $totalMember = Booking::where('tour_id_tour', $tourID) //TourID ใช้ของที่กดจองมา
            ->where('status','NOT LIKE','cancel')
            ->selectRaw('SUM(adult_qty + kid_qty) as Total_Member')
            ->value('Total_Member');
        $bookingInTour = Booking::join('user_list', 'user_list.account_id_account', '=', 'booking.user_list_account_id_account')
            ->where('booking.tour_id_tour', $tourID)
            ->where('booking.status', 'not like', 'cancel')
            ->get();
        $anotherReview = Review::join('booking', 'booking.id_booking', '=', 'review.booking_id_booking')
            ->join('tour', 'tour.id_tour', '=', 'booking.tour_id_tour')
            ->join('user_list', 'user_list.account_id_account', '=', 'review.user_list_account_id_account')
            ->where('tour.id_tour', $tourID)
            ->select('review.*', 'user_list.*') // เลือกเฉพาะคอลัมน์ที่ต้องการ
            ->get();
        $locationInTourAPI = LocationInTour::where('tour_id_tour', $tourID)->get();
        $locations = [];
        foreach ($locationInTourAPI as $api) {
            $locations[] = $this->getLocationsById($api->loc_api);
        }
        return view('guide.detailMyTour', compact('totalMember', 'tourData', 'anotherReview', 'locations', 'bookingInTour'));
    }
    public function getMyJob(Request $request)
    {
        $tourData = Tour::join('Tour_has_guide_list', 'tour.id_tour', '=', 'Tour_has_guide_list.tour_id_tour')
            ->where('Tour_has_guide_list.guide_list_account_id_account', session('userID')->account_id_account)
            ->where('tour.status', 'LIKE', 'ongoing')
            ->paginate(10)->appends($request->query());
        return view('guide.myJob', compact('tourData'));
    }
    public function getMyJobDetail(Request $request)
    {
        $tourID = $request->tourID;
        $tour = Tour::where('id_tour', $tourID)->first();
        switch ($tour->from_owner) {
            case "guide":
                $tourData = Tour::join('guide_list', 'tour.owner_id', '=', 'guide_list.account_id_account')
                    ->where('tour.id_tour', $tourID)
                    ->select('tour.*', 'guide_list.name as guide_name', 'guide_list.surname as guide_surname', 'guide_list.phonenumber')
                    ->first();
                break;
            case "corp":
                $tourData = Tour::join('corp_list', 'tour.owner_id', '=', 'corp_list.account_id_account')
                    ->where('tour.id_tour', $tourID)
                    ->select('tour.*', 'corp_list.name as corp_name', 'corp_list.phone_number')
                    ->first();
                break;
        }
        $totalMember = Booking::where('tour_id_tour', $tourID) //TourID ใช้ของที่กดจองมา
            ->where('status','NOT LIKE','cancel')
            ->selectRaw('SUM(adult_qty + kid_qty) as Total_Member')
            ->value('Total_Member');
        $anotherReview = Review::join('booking', 'booking.id_booking', '=', 'review.booking_id_booking')
            ->join('tour', 'tour.id_tour', '=', 'booking.tour_id_tour')
            ->join('user_list', 'user_list.account_id_account', '=', 'review.user_list_account_id_account')
            ->where('tour.id_tour', $tourID)
            ->select('review.*', 'user_list.*') // เลือกเฉพาะคอลัมน์ที่ต้องการ
            ->get();
        $locationInTourAPI = LocationInTour::where('tour_id_tour', $tourID)->get();
        $locations = [];
        foreach ($locationInTourAPI as $api) {
            $locations[] = $this->getLocationsById($api->loc_api);
        }
        return view('guide.detailMyJob', compact('totalMember', 'tourData', 'anotherReview', 'locations'));
    }
    public function searchMyJob(Request $request)
    {
        $status = $request->status;
        $name = $request->name;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $tourData = Tour::join('Tour_has_guide_list', 'tour.id_tour', '=', 'Tour_has_guide_list.tour_id_tour')
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
        return view('guide.myJob', compact('tourData'));
    }
    public function getJobHistory(Request $request)
    {
        $tourData = Tour::join('Tour_has_guide_list', 'tour.id_tour', '=', 'Tour_has_guide_list.tour_id_tour')
            ->where('Tour_has_guide_list.guide_list_account_id_account', session('userID')->account_id_account)
            ->where('tour.status', 'LIKE', 'finish')
            ->paginate(10)->appends($request->query());
        return view('guide.jobHistory', compact('tourData'));
    }
    public function getJobHistoryDetail(Request $request)
    {
        $tourID = $request->tourID;
        $tour = Tour::where('id_tour', $tourID)->first();
        switch ($tour->from_owner) {
            case "guide":
                $tourData = Tour::join('guide_list', 'tour.owner_id', '=', 'guide_list.account_id_account')
                    ->where('tour.id_tour', $tourID)
                    ->select('tour.*', 'guide_list.name as guide_name', 'guide_list.surname as guide_surname', 'guide_list.phonenumber')
                    ->first();
                break;
            case "corp":
                $tourData = Tour::join('corp_list', 'tour.owner_id', '=', 'corp_list.account_id_account')
                    ->where('tour.id_tour', $tourID)
                    ->select('tour.*', 'corp_list.name as corp_name', 'corp_list.phone_number')
                    ->first();
                break;
        }
        $totalMember = Booking::where('tour_id_tour', $tourID) //TourID ใช้ของที่กดจองมา
            ->where('status','NOT LIKE','cancel')
            ->selectRaw('SUM(adult_qty + kid_qty) as Total_Member')
            ->value('Total_Member');
        $anotherReview = Review::join('booking', 'booking.id_booking', '=', 'review.booking_id_booking')
            ->join('tour', 'tour.id_tour', '=', 'booking.tour_id_tour')
            ->join('user_list', 'user_list.account_id_account', '=', 'review.user_list_account_id_account')
            ->where('tour.id_tour', $tourID)
            ->select('review.*', 'user_list.*') // เลือกเฉพาะคอลัมน์ที่ต้องการ
            ->get();
        $locationInTourAPI = LocationInTour::where('tour_id_tour', $tourID)->get();
        $locations = [];
        foreach ($locationInTourAPI as $api) {
            $locations[] = $this->getLocationsById($api->loc_api);
        }
        return view('guide.detailJobHistory', compact('totalMember', 'tourData', 'anotherReview', 'locations'));
    }
    public function searchMyJobHistory(Request $request)
    {
        $status = $request->status;
        $name = $request->name;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $tourData = Tour::join('Tour_has_guide_list', 'tour.id_tour', '=', 'Tour_has_guide_list.tour_id_tour')
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
        return view('guide.jobHistory', compact('tourData'));
    }
    function viewCalendar()
    {
        return view('guide.calendar');
    }
    function fetchCalendar()
    { //ดึงข้อมูลมาทำปฏิทิน
        $tourDatas = Tour::join('Tour_has_guide_list', 'tour.id_tour', '=', 'Tour_has_guide_list.tour_id_tour')
            ->where('Tour_has_guide_list.guide_list_account_id_account', session('userID')->account_id_account)
            ->where('tour.status', 'LIKE', 'ongoing')->get();
        // ดึงข้อมูล Tour ทั้งหมดที่อยู่ใน Booking (Query เดียว)

        // จัดรูปแบบข้อมูลให้เหมาะกับ FullCalendar
        $formattedEvents = $tourDatas->map(function ($tour) {
            return [
                'title' => $tour->name,
                'start' => $tour->start_tour_date,
                'end' => Carbon::parse($tour->end_tour_date)->addDay()->format('Y-m-d'),
            ];
        });

        return response()->json($formattedEvents);
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
            return view('guide.searchTour', compact('ownerData', 'searchTourData', 'totalMember', 'ownerScore', 'path'));
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
            return view('guide.searchRequest', compact('ownerData', 'searchRequestData', 'path'));
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
            return view('guide.searchTour', compact('ownerData', 'searchTourData', 'totalMember', 'ownerScore', 'path'));
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
            return view('guide.searchRequest', compact('ownerData', 'searchRequestData', 'path'));
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
            ->where('status','NOT LIKE','cancel')
            ->selectRaw('SUM(adult_qty + kid_qty) as Total_Member')
            ->value('Total_Member');
        $locationInTourAPI = LocationInTour::where('tour_id_tour', $tourID)->get();
        $locations = [];
        foreach ($locationInTourAPI as $api) {
            $locations[] = $this->getLocationsById($api->loc_api);
        }
        return view('guide.detailSearchTour', compact('totalMember', 'tourData', 'Review', 'locations', 'path'));
    }
    public function getSearchRequestDetail(Request $request)
    {
        $requestID = $request->requestID;
        $path = $request->path;
        $offerInRequest = Offer::where('request_tour_id_request_tour', $requestID)->get();
        $offerData = [];
        foreach ($offerInRequest as $offer) {
            switch ($offer->from_who_offer) {
                case 'corp':
                    $offerData[] = $offer->join('corp_list', 'corp_list.account_id_account', '=', 'offer.id_who_offer')
                        ->where('corp_list.account_id_account', $offer->id_who_offer)
                        ->first();
                    break;
                case 'guide':
                    $offerData[] = $offer->join('guide_list', 'guide_list.account_id_account', '=', 'offer.id_who_offer')
                        ->where('guide_list.account_id_account', $offer->id_who_offer)
                        ->first();
                    break;
            }
        }
        $requestData = RequestTour::join('user_list', 'request_tour.user_list_account_id_account', '=', 'user_list.account_id_account')
            ->where('id_request_tour', $requestID)
            ->select('request_tour.*', 'user_list.name as uName', 'user_list.surname', 'user_list.phonenumber')  // เลือกคอลัมน์ทั้งหมดจากทั้ง 2 ตาราง
            ->first();
        return view('guide.detailSearchRequest', compact('requestData', 'path', 'offerData'));
    }
    public function getStatistic()
    {
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
        return view('guide.statistic', compact('touristPerMonth', 'touristPerYear', 'revenuePerMonth', 'revenuePerYear', 'avgTourist', 'avgRevenue'));
    }
    public function getAllPayment(Request $request)
    {
        $idAccount = session('userID')->account_id_account;
        $payments = DB::table('payment as p')
            ->join('booking as b', 'b.id_booking', '=', 'p.booking_Tour_id_Tour')
            ->join('tour as t', 't.id_tour', '=', 'b.tour_id_tour')
            ->join('user_list', 'user_list.account_id_account', '=', 'p.booking_user_list_account_id_account')
            ->join('guide_list as c', function ($join) {
                $join->on('c.account_id_account', '=', 't.owner_id')
                    ->where('t.from_owner', 'LIKE', 'guide');
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
            )->get();
        return view('guide.allPayment', compact('payments'));
    }
    public function searchPayment(Request $request)
    {
        $searchKey = $request->searchKey;
        $date = $request->paymentDate;
        $idAccount = session('userID')->account_id_account;
        $payments = DB::table('payment as p')
            ->join('booking as b', 'b.id_booking', '=', 'p.booking_Tour_id_Tour')
            ->join('tour as t', 't.id_tour', '=', 'b.tour_id_tour')
            ->join('user_list', 'user_list.account_id_account', '=', 'p.booking_user_list_account_id_account')
            ->join('guide_list as c', function ($join) {
                $join->on('c.account_id_account', '=', 't.owner_id')
                    ->where('t.from_owner', 'LIKE', 'guide');
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
        return view('guide.allPayment', compact('payments'));
    }
    public function getPaymentDetail(Request $request)
    {
        $userID = $request->userID;
        $tourID = $request->tourID;
        $paymentID= $request->paymentID;
        $bookingID= $request->bookingID;
        $paymentData = Payment::where('id_payment',$paymentID)->first();
        $tourData = Tour::where('id_tour',$tourID)->first();
        $userData = UserList::where('account_id_account',$userID)->first();
        $bookingData = Booking::where('id_booking',$bookingID)->first();
        return view('guide.receipt',compact('paymentData','tourData','userData','bookingData'));
  }
  function getOffer(Request $request)
  {
      $idAccount = session('userID')->account_id_account;
      $requestTours = RequestTour::join('offer as o', 'o.request_tour_id_request_tour', '=', 'request_tour.id_request_tour')
          ->where('o.id_who_offer', $idAccount)
          ->select('request_tour.*','o.*')
          ->paginate(10)->appends($request->query());
      $tourPrivate = [];
      foreach($requestTours as $offer){
        $tourPrivate[$offer->id_offer] = Tour::where('offer_id_offer',$offer->id_offer)->first();
      }
      return view('guide.myOffer', compact('requestTours','tourPrivate'));
  }
  function searchOffer(Request $request)
  {
      $name = $request->name;
      $startDate = $request->startDate;
      $endDate = $request->endDate;
      $status = $request->status;
      $idAccount = session('userID')->account_id_account;
      $requestTours = RequestTour::join('offer as o', 'o.request_tour_id_request_tour', '=', 'request_tour.id_request_tour')
          ->where('o.id_who_offer', $idAccount);
      if(!empty($name)){
        $requestTours->whereRaw('LOWER(request_tour.name) LIKE LOWER(?)', ["%$name%"]);
      }
      if(!empty($startDate)){
        $requestTours->whereDate('request_tour.request_date', $startDate);
      }
      if(!empty($endDate)){
        $requestTours->whereDate('request_tour.end_of_request_date', $endDate);
      }
      if(!empty($status)){
        $requestTours->where('o.status','LIKE',$status);
      }
      $requestTours=$requestTours->select('request_tour.*','o.*')
          ->paginate(10)->appends($request->query());
      return view('guide.myOffer', compact('requestTours'));
  } 
    function getOfferDetail(Request $request)
    {
        $idAccount = session('userID')->account_id_account;
        $offerByMe = DB::table('offer')
            ->where('id_who_offer', $idAccount)
            ->where('request_tour_id_request_tour', $request->requestID)
            ->get();
        $RequestDetail = RequestTour::join('user_list', 'request_tour.user_list_account_id_account', '=', 'user_list.account_id_account')
            ->where('id_request_tour', $request->requestID)
            ->select('request_tour.*', 'user_list.name as uName', 'user_list.surname', 'user_list.phonenumber')  // เลือกคอลัมน์ทั้งหมดจากทั้ง 2 ตาราง
            ->first();
        $offerInRequest = Offer::where('request_tour_id_request_tour', $request->requestID)->get();
        $offerData = [];
        foreach ($offerInRequest as $offer) {
            switch ($offer->from_who_offer) {
                case 'corp':
                    $offerData[] = $offer->join('corp_list', 'corp_list.account_id_account', '=', 'offer.id_who_offer')
                        ->where('corp_list.account_id_account', $offer->id_who_offer)
                        ->where('id_offer',$offer->id_offer)
                        ->first();
                    break;
                case 'guide':
                    $offerData[] = $offer->join('guide_list', 'guide_list.account_id_account', '=', 'offer.id_who_offer')
                        ->where('guide_list.account_id_account', $offer->id_who_offer)
                        ->where('request_tour_id_request_tour',$request->requestID)
                        ->where('id_offer',$offer->id_offer)
                        ->first();
                    break;
            }
        }
        return view('guide.detailMyOffer', compact('offerByMe', 'RequestDetail', 'offerData'));
    }
    function toEditOffer(Request $request)
    {
        $OfferID = $request->offerID;
        $offerData = Offer::join('request_tour', 'request_tour.id_request_tour', '=', 'offer.request_tour_id_request_tour')
            ->where('id_offer', $OfferID)->first();
            
        $getHotel = $this->getHotelByName($offerData->hotel);
        if (empty($getHotel->original["data"])) {
            $getHotel = null;
            $provinceId = null;
        } else {
            $provinceId = $getHotel->original["data"][0]["location"]["province"]["provinceId"];
            $getHotel = $getHotel->original["data"][0]["name"];
        }
        return view('guide.editOffer', compact('provinceId', 'getHotel', 'offerData'));
    }

    public function getHotelByName($name)
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Accept-Language' => 'th',
            'x-api-key' => env('TAT_API_KEY')
        ])->get("https://tatdataapi.io/api/v2/places?keyword=$name&place_category_id=2&limit=300");

        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            return response()->json(['error' => 'ไม่สามารถดึงข้อมูลสถานที่ท่องเที่ยวได้'], 500);
        }
    }
  public function updateOffer(Request $request){
    $idOffer = $request->offerID;
    $offerData = [
        'contect' => $request->contact,
        'price' => $request->price,
        'description' => $request->description,
        'hotel' => $request->hotel,
        'hotel_price' => $request->hotelPrice,
        'travel' => $request->travel,
        'travel_price' => $request->travel_price,
        'guide_qty' => $request->quantity,
        'status' => 'new'
    ];
    DB::table('offer')
        ->where('id_offer', $idOffer)
        ->update($offerData);
    return redirect('/guideGetMyOffer');
  }
  public function deleteOffer(Request $request){
    $idOffer = $request->offerID;
    Offer::where('id_offer',$idOffer)->delete();
    return redirect('/guideGetMyOffer');
  }
  public function getAddOfferPage(Request $request){
    $requestID = $request->requestID;
    $requestData = RequestTour::where('id_request_tour',$requestID)->first();
    return view('guide.offerPage',compact('requestData'));
  }
  public function addOfferS(Request $request){
    $requestTourID = $request->requestID;
    $offerData = [
        "request_tour_id_request_tour" => $requestTourID,
        "from_who_offer" => "guide",
        "id_who_offer" => session('userID')->account_id_account,
        'contect' => $request->contact,
        'price' => $request->price,
        'description' => $request->description,
        'hotel' => $request->hotel,
        'hotel_price' => $request->hotelPrice,
        'travel' => $request->travel,
        'travel_price' => $request->travel_price,
        'guide_qty' => $request->quantity,
        'status' => 'new',
        "offer_date" => Carbon::now()->toDateTimeString()
    ];
    DB::table('offer')
        ->insert($offerData);
    return redirect('/guideGetMyOffer');
  }
    function viewProfile()
    {
        $id = session('userID')->account_id_account;
        $accountData = Account::where('id_account', $id)->first();
        $userData = GuideList::where('account_id_account', $id)->first();
        $corp = CorpList::where('account_id_account', $userData->corp_list_account_id_account )->first();
        $countrys =  AccountController::getCountry();
        return view('guide.profile', compact('accountData', 'userData', 'countrys','corp'));
    }
    function updateUser(Request $request)
    {

        $idAccount = session('userID')->account_id_account;
        $user = GuideList::where('account_id_account', $idAccount)->first();
        $acc = Account::where('id_account', $idAccount)->first();
        if (!$acc) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'phonenumber' => $request->phonenumber,
            'fake_BAN' => $request->fake_BAN,
            'address' => $request->address,
            'country' => $request->country,
            'postcode' => $request->postcode,
        ]);
        $acc->update([
            'username' => $request->username
        ]);

        return redirect('/guideProfile');
    }
    function updateImage(Request $request)
    {
        // ตรวจสอบว่ามี user อยู่หรือไม่
        $idAccount = session('userID')->account_id_account;
        $user = GuideList::where('account_id_account', $idAccount)->first();


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
            'photo' => $path
        ]);

        return redirect('/guideProfile');
    }
    public function getSellHistory(Request $request){
        $idAccount = session('userID')->account_id_account;
        $tourData = DB::table('tour')
            ->where('from_owner', 'LIKE', 'guide')
            ->where('owner_id', $idAccount)
            ->whereIn('status', ['finish', 'collect'])
            ->paginate(10)->appends($request->query());
        //dd($histours);
        return view('guide.sellHistory', compact('tourData'));
    }
    public function searchSellHistory(Request $request){
        $status = $request->status;
        $name = $request->name;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $tourData = Tour::where('owner_id', session('userID')->account_id_account)
            ->where('status', 'LIKE', '%' . $status . '%')
            ->whereIn('status', ['finish', 'collect']);
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
        return view('guide.sellHistory', compact('tourData'));
    }
    public function sellHistoryDetail(Request $request){
        $tourID = $request->tourID;
        $tour = Tour::where('id_tour', $tourID)->first();
        switch ($tour->from_owner) {
            case "guide":
                $tourData = Tour::join('guide_list', 'tour.owner_id', '=', 'guide_list.account_id_account')
                    ->where('tour.id_tour', $tourID)
                    ->select('tour.*', 'guide_list.name as guide_name', 'guide_list.surname as guide_surname', 'guide_list.phonenumber')
                    ->first();
                break;
            case "corp":
                $tourData = Tour::join('corp_list', 'tour.owner_id', '=', 'corp_list.account_id_account')
                    ->where('tour.id_tour', $tourID)
                    ->select('tour.*', 'corp_list.name as corp_name', 'corp_list.phone_number')
                    ->first();
                break;
        }
        $totalMember = Booking::where('tour_id_tour', $tourID) //TourID ใช้ของที่กดจองมา
            ->where('status','NOT LIKE','cancel')
            ->selectRaw('SUM(adult_qty + kid_qty) as Total_Member')
            ->value('Total_Member');
        $anotherReview = Review::join('booking', 'booking.id_booking', '=', 'review.booking_id_booking')
            ->join('tour', 'tour.id_tour', '=', 'booking.tour_id_tour')
            ->join('user_list', 'user_list.account_id_account', '=', 'review.user_list_account_id_account')
            ->where('tour.id_tour', $tourID)
            ->select('review.*', 'user_list.*') // เลือกเฉพาะคอลัมน์ที่ต้องการ
            ->get();
        $locationInTourAPI = LocationInTour::where('tour_id_tour', $tourID)->get();
        $locations = [];
        foreach ($locationInTourAPI as $api) {
            $locations[] = $this->getLocationsById($api->loc_api);
        }
        return view('guide.detailSellHistory', compact('totalMember', 'tourData', 'anotherReview', 'locations'));
    }
    public function addPrivateTourPage(Request $request){
        $OfferID = $request->offerID;
        $offerData = Offer::join('request_tour', 'request_tour.id_request_tour', '=', 'offer.request_tour_id_request_tour')
            ->where('id_offer', $OfferID)->first();
        $getHotel = $this->getHotelByName($offerData->hotel);
        if (empty($getHotel->original["data"])) {
            $getHotel = null;
            $provinceId = null;
        } else{
            $provinceId = $getHotel->original["data"][0]["location"]["province"]["provinceId"];
            $getHotel = $getHotel->original["data"][0]["name"];
        }
        return view('guide.addPrivateTour', compact('provinceId', 'getHotel', 'offerData'));

    }
    public function addPrivateTour(Request $request){
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
            "offer_id_offer" => $request->offerID,
            "type_tour" => 'private',
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
        return redirect('/guideMyTour');

    }
}
