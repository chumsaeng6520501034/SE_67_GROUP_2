<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\CorpList;
use Carbon\Carbon;
use App\Models\TourHasGuideList;
use App\Models\Tour;
use App\Models\LocationInTour;
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
    function addTour(Request $request)
    {
        $locationInTourAPI = $request->location;
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
            "type_tour" => 'public'
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
}
