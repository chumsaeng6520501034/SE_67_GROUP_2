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

class AdminListController extends Controller
{
    //ส่วนแสดง
    function viewAccount()//เป็นทั้งhome ทั้งแอคเคาท์รวมเลย
    {
        $accounts = Account::all();
        // dd($accounts);
        return view('admin.home', compact('accounts'));
    }
    function viewCustomer()//เป็นของลูกค้า
    {
        $users = UserList::all();
        // dd($accounts);
        return view('admin.customer', compact('users'));
    }
    function viewGuide()//เป็นของไกด์
    {
        $guides = GuideList::all();
        // dd($accounts);
        return view('admin.guide', compact('guides'));
    }
    function viewCorporation()//เป็นของไกด์
    {
        $corporations = CorpList::all();
        // dd($accounts);
        return view('admin.corporation', compact('corporations'));
    }


    //ส่วนหน้าแก้ไข
    function viewEditCustomer(Request $request){
        //dd($request->input('id'));
       
        $account = Account::leftJoin('user_list', 'user_list.account_id_account', '=', 'id_account')
                  ->where('id_account', $request->input('id'))
                  ->select('*')  // เลือกคอลัมน์จากทั้งสองตาราง
                  ->first();

        // dd($account);
        return view('admin.editCustomer', compact('account'));
      }
      function viewEditGuide(Request $request){
        // dd($request->input('id'));
       
        $account = Account::leftJoin('guide_list', 'guide_list.account_id_account', '=', 'id_account')
                  ->where('id_account', $request->input('id'))
                  ->select('*')  // เลือกคอลัมน์จากทั้งสองตาราง
                  ->first();

        // dd($account);
        return view('admin.editGuide', compact('account'));
      }
      function viewEditCorp(Request $request){
        // dd($request->input('id'));
       
        $account = Account::leftJoin('corp_list', 'corp_list.account_id_account', '=', 'id_account')
                  ->where('id_account', $request->input('id'))
                  ->select('*')  // เลือกคอลัมน์จากทั้งสองตาราง
                  ->first();

        // dd($account);
        return view('admin.editCorp', compact('account'));
      }

      //ส่วนอัพเดท
      function updateCustomer(Request $request){
        //dd($request->id);
        $account = Account::where('id_account', $request->id)->first();
        //dd($account);
        $account->update([
            'username' => $request->username,
            'password' => $request->password,
            'email' => $request->email,
        ]);
        //dd($account);
        $customer = UserList::find($request->id);
        //dd($customer);
        $customer->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'phonenumber' => $request->phonenumber,
            'fake_BAN' => $request->fake_BAN,
            'photo' => $request->photo,
            'address' => $request->address,
            'country' => $request->country,
            'postcode' => $request->postcode,
        ]);
        return redirect()->route('customer');
      }
      function updateGuide(Request $request){
        $account = Account::where('id_account', $request->id)->first();
        $account->update([
            'username' => $request->username,
            'password' => $request->password,
            'email' => $request->email,
        ]);
        $guide = GuideList::find($request->id);
        $guide->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'phonenumber' => $request->phonenumber,
            'fake_BAN' => $request->fake_BAN,
            'photo' => $request->photo,
            'address' => $request->address,
            'country' => $request->country,
            'postcode' => $request->postcode,
            'guide_license' => $request->guide_license,
            'corp_list_account_id_account' => $request->corp_list_account_id_account,
        ]);
        return redirect()->route('guide');
      }
      function updateCorp(Request $request){
        $account = Account::where('id_account', $request->id)->first();
        $account->update([
            'username' => $request->username,
            'password' => $request->password,
            'email' => $request->email,
        ]);
        $corp = CorpList::find($request->id);
        $corp->update([
            'name' => $request->name,
            'name_owner' => $request->name_owner,
            'phone_number' => $request->phone_number,
            'nationality' => $request->nationality,
            'logo' => $request->logo,
            'address' => $request->address,
            'country' => $request->country,
            'postcode' => $request->postcode,
            'corp_license' => $request->corp_license,
            'owner_country_code' => $request->owner_country_code,
            'dob' => $request->dob,
        ]);
        return redirect()->route('corp');
      }
      function deleteCustomer(Request $request)
    {
        // dd($request->id);
        //$account = Account::find($request->id);
        $account = Account::where('id_account', $request->id)->first();
        // dd($account);
        $account->delete();

        return redirect()->route('customer');
    }
    function statusChange(Request $request){
        $account = Account::where('id_account', $request->id)->first();
        //dd($request->id);
        // dd($account->status);
        $newStatus = $account->status === 'available' ? 'disappear' : 'available';
        // dd($newStatus);
        $account->update([
            'status' => $newStatus,
        ]);
        return redirect()->route('account');
    }
    function statusAvai(Request $request){
        // dd($request->status);
        $account = Account::where('id_account', $request->id)->first();
        // dd($account);
        $account->update([
            'status' => $request->status,
        ]);
        return redirect()->route('account');
    }
    function statusDis(Request $request){
        // dd($request->status);
        $account = Account::where('id_account', $request->id)->first();
        // dd($account);
        $account->update([
            'status' => $request->status,
        ]);
        return redirect()->route('account');
    }
}