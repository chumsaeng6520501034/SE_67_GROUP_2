<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\CorpList;
use Carbon\Carbon;
use App\Models\TourHasGuideList;
use App\Models\Tour;
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
    function getAddTour()
    {
        return view('corporation.addTour');
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

    function getOffer()
    {
        $idAccount = session('userID')->account_id_account;
        $offers = DB::table('offer')
        ->where('from_who_offer', 'LIKE', 'corp')
        ->where('id_who_offer', $idAccount)
        ->get();
        dd($offers);
        return view('???', compact('offers'));
    }

    function getStaffInCorp()
    {
        $idAccount = session('userID')->account_id_account;
        $guides = DB::table('guide_list')
        ->where('corp_list_account_id_account', $idAccount)
        ->get();
        dd($guides);
        return view('???', compact('guides'));
    }

    //เอารายการจ่ายทั้งหมด
    function getAllPaymentHistory()
    {
        $idAccount = session('userID')->account_id_account;
        $payments = DB::table('payment as p')
        ->join('booking as b', 'b.id_booking', '=', 'p.booking_Tour_id_Tour')
        ->join('tour as t', 't.id_tour', '=', 'b.tour_id_tour')
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
            'p.total_price'
        )
        ->get();
        dd($payments);
        return view('???', compact('payments'));
    }

    //รายละเอียดการโอนเงินครั้งใด ๆ ที่โดนเลือก//
    function getPaymentDetails(Request $request)
    {
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
}
