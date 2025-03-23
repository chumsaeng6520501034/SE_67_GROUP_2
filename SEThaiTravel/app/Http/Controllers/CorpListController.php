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
            return redirect('/corpHomepage');
        }
    }
    function getHomePage()
    {
        return view('corporation.home');
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
    //เอารายการสินค้าที่หมดอายุทั้งหมด
    function getHistory()
    {
        $idAccount = session('userID')->account_id_account;
        $histours = DB::table('tour')
        ->where('from_owner', 'LIKE', 'corp')
        ->where('owner_id', $idAccount)
        ->where('end_tour_date', '<', now())
        ->get();
        dd($histours);
        return view('corporation.sellHistory', compact('histours'));
    }
    //เอารายการข้อเสนอทั้งหมด
    function getOffer(Request $request)
    {
        $idAccount = session('userID')->account_id_account;
        $offers = DB::table('offer')
        ->where('from_who_offer', 'LIKE', 'corp')
        ->where('id_who_offer', $idAccount)
        ->paginate(10)->appends($request->query());
        // dd($offers);
        return view('corporation.myOffer', compact('offers'));
    }

    //เอาพนักงานในบ. ทำเเล้ว
    function getStaffInCorp()
    {
        $idAccount = session('userID')->account_id_account;
        $guides = DB::table('guide_list')
        ->where('corp_list_account_id_account', $idAccount)
        ->get();
        // dd($guides);
        return view('corporation.myStaf', compact('guides'));
    }

    //เอารายการจ่ายทั้งหมด ทำเเล้ว
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
        // dd($payments);
        return view('corporation.allPayments', compact('payments'));
    }

    //ยังไม่เสร็จ
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
