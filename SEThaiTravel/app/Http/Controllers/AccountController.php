<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\CorpList;
use App\Models\GuideList;
use App\Models\UserList;
use App\Models\Booking;
use App\Models\Tour;
use App\Models\TourHasGuideList;
use App\Models\Payment;

use App\Models\LocationInTour;
class AccountController extends Controller
{
      function viewLogin(){ // Redirect ไปที่หน้า login
        return view('login');
      }
      function checkLogin(Request $request){ //ตรวจสอบการ login ว่าเป็น user ประเภทไหน แล้ว Redirect ไปที่หน้าของ Account ประเภทนั้น
        $request->validate([
          'username'=>'required',
          'password'=>'required'
          ],
          );
        
        $account = Account::where('username',$request->username)->where('password',$request->password)->first();
        if(is_null($account))
        {
          return redirect()->back()->withErrors(['login_failed' => 'Invalid username or password'])->withInput();
        }
        else
        {
          switch($account->permittion_acc){
              case "admin" : 
                session(['userID' => $account]);
                return view('adminPage'); //ของจริงจะใส่เป็น view('ชื่อของไฟล์ที่เป็นหน้า',compact('ตัวแปรที่เก็บข้อมูลของadmin'))
              case "corp"  :
                  $corp= CorpList::find($account->id_account);
                  session(['userID' => $corp]);
                return view('corpPage');
              case "user"  : 
                  $user= UserList::find($account->id_account);
                  // dd($user);
                  session(['userID' => $user]);
                return view('userPage');
              case "guide" : 
                  $guide= GuideList::find($account->id_account);
                  session(['userID' => $guide]);
                  // dd($guide);
                return view('guidePage');
          }
        }
      }
      function viewSignIn(){ // Redirect ไปที่ หน้า signIn หน้าแรกที่มีให้เลือกประเภทการ SignIn
        return view('signIn');
      }
      function signIn(Request $request){ // รับข้อมูลจากหน้า signIn หน้าเเรกแล้วมาแบ่งประเภทว่าจะ Redirect ไปหน้า signIn ที่เลือกมา
          $request->validate([
          'username'=>'required',
          'password'=>'required',
          'email'=>'required'
          ],
          );
          $username= $request->username;
          $password= $request->password;
          $email=$request->email;
          $typeOfSign= $request->type;
          $checkAcc=Account::where('username',$username)
                             ->orWhere('email ', 'LIKE', $email)
                             ->first();//ใช้ตรวจสอบ username email ว่ามีแล้วหรือยัง
          if(is_null($checkAcc)){
            switch($typeOfSign){
              case 'corp': 
                return view('corpSignIn',compact('username','password','typeOfSign','email'));
              case 'guide': 
                return view('guideSignIn',compact('username','password','typeOfSign','email'));
              case 'user': 
                return view('userSignIn',compact('username','password','typeOfSign','email'));
            } 
          }
          else{
            return redirect()->back()->withErrors(['SignIn_failed' => 'username or email have used'])->withInput();
          }    
      }
      function insertCorp(Request $request){//เพิ่ม บริษัทเข้าฐานข้อมูลแล้ว Redirect ไปหน้า Home
        $accountData=[
          'permittion_acc'=>$request->typeOfSign,
          'username'=>$request->username,
          'password'=>$request->password,
          'email'=>$request->email,
          'status'=>'pending'
        ];
        // dd($accountData);
        Account::insert($accountData);
        $idAcc = Account::where('username',$request->username)->first();    
        $corpData=[
          'account_id_account'=> $idAcc->id_account,
          'corp_license'=>$request->registNum,
          'logo'=>"logo.png",
          'name'=>$request->corpName,
          'address'=> $request->address." ".$request->district." ".$request->subdistict.
                      " ".$request->province,
          'country'=> $request->country,
          'postcode'=> $request->postalNum,
          'phone_number'=>$request->phoneNumber,
          'name_owner'=>$request->owner,
          'nationality'=>$request->nation,
          'dob'=>$request->dob,
          'owner _address'=>$request->ownerAddress." ".$request->ownerDistrict." ".$request->ownerSubdistrict.
                            " ".$request->ownerProvince." ".$request->ownerPostalNum,
          'owner_country_code'=>1
        ]; 
        // dd($corpData);
        CorpList::insert($corpData);
        return view('home');
      }

      
      function insertUser(Request $request){//เพิ่ม ลูกค้าเข้าฐานข้อมูลแล้ว Redirect ไปหน้า Home
        $accountData=[
          'permittion_acc'=>$request->typeOfSign,
          'username'=>$request->username,
          'password'=>$request->password,
          'email'=>$request->email,
          'status'=>'pending'
        ];
        // dd($accountData);
        Account::insert($accountData);
        $idAcc = Account::where('username',$request->username)->first();    
        $userData=[
          'account_id_account'=> $idAcc->id_account,//สมมมุตินะของจริงต้องใช้ id ที่พึ่งใส่ไป
          'name'=>$request->FirstName,
          'surname'=> $request->LastName,
          'photo'=> "photo.png",
          'phonenumber'=>$request->PhoneNum,
          'fake_BAN'=>$request->CardNum,
          'address'=>$request->Address." ".$request->District." ".$request->Subdistrict.
          " ".$request->Province,
          'postcode'=>$request->PostNum,
          'country'=>1//อันนี้ก็สมมติของจริงน่าจะมีเงื่อนไขเเล้วค่อยนำค่ามาใส่
        ]; 
        // dd($userData);
        UserList::insert($userData);
        return view('home');
      }
      function insertGuide(Request $request){//เพิ่ม ไกด์เข้าฐานข้อมูลแล้ว Redirect ไปหน้า Home
        $accountData=[
          'permittion_acc'=>$request->typeOfSign,
          'username'=>$request->username,
          'password'=>$request->password,
          'email'=>$request->email,
          'status'=>'pending'
        ];
        // dd($accountData);
        Account::insert($accountData);
        $idAcc = Account::where('username',$request->username)->first();    
        $guideData=[
          'account_id_account'=>$idAcc->id_account,//สมมมุตินะของจริงต้องใช้ id ที่พึ่งใส่ไป
          'guide_license'=>$request->GuideLicense,
          'name'=>$request->FirstName,
          'surname'=> $request->LastName,
          'photo'=> "photo.png",
          'corp_list_account_id_account'=> $request->corp,
          'phonenumber'=>$request->PhoneNum,
          'fake_BAN'=>$request->CardNum,
          'address'=>$request->Address." ".$request->District." ".$request->Subdistrict.
          " ".$request->Province,
          'postcode'=>$request->PostNum,
          'country'=>1//อันนี้ก็สมมติของจริงน่าจะมีเงื่อนไขเเล้วค่อยนำค่ามาใส่
        ]; 
        // dd($guideData);
        GuideList::insert($guideData);
        return view('home');
      }
      function search(Request $request){// ค้นหาทัวร์ที่วางขายอยู่
          $name = $request->searchKey;
          $startDate = $request->startDate;
          $endDate = $request->endDate;
          $capacity = $request->capacity;
          if(is_numeric($name)){//เช็คว่าเป็นตัวเลขไหมถ้าเป็นจะ search แบบ private 
            $searchTourData =Tour::where(function ($query) {
              $query->where('name', 'LIKE', '%'.$name.'%')
                    ->orWhere('start_tour_date', 'LIKE', $startDate)
                    ->orWhere('end_tour_date', 'LIKE', $endDate)
                    ->orWhere('tour_capacity', '>=', $capacity);
             })
            ->where('status', 'LIKE', 'ongoing')
            ->where('type_tour', 'LIKE', 'private')
            ->get();
          }
          else{
            $searchTourData =Tour::where(function ($query) {
              $query->where('name', 'LIKE', '%'.$name.'%')
                    ->orWhere('start_tour_date', 'LIKE', $startDate)
                    ->orWhere('end_tour_date', 'LIKE',  $endDate)
                    ->orWhere('tour_capacity', '>=', $capacity);
             })
            ->where('status', 'LIKE', 'ongoing')
            ->where('type_tour', 'LIKE', 'public')
            ->get();
          }
          $ownerData = [];
          foreach($searchTourData as $data){//อันนหาหาข้อมูลของเจ้าของทัวร์นั้นๆแล้วส่งไปใน view ด้วยเผื่อใช้
            switch($data->from_owner){
              case "guide": $ownerData[] = GuideList::find($data->owner_id); break;
              case "corp": $ownerData[] = CorpList::find($data->owner_id); break;
            }
          }
          return view('searchPage',compact('ownerData','$searchTourData'));
      }

      function logOut(Request $request){//Log out แล้ว เคลีย session ทิ้ง
        $request->session()->invalidate(); // ทำให้ session ID ปัจจุบันใช้ไม่ได้
        $request->session()->regenerateToken(); // สร้าง CSRF token ใหม่ ป้องกัน 419 Page Expired
        return view('home');
      }
      function viewProduct(Request $request){//ดึงข้อมูลของTour ที่จะดูมาแล้ว Redirect ไปที่หน้าดูข้อมูลสินค้าพร้อมส่งข้อมูลที่ต้องการไปด้วย
        $tourID = $request->tourID;
        $tourData = Tour::where('id_tour',$tourID)->first();
        switch($tourData->from_owner){
          case "guide": $productData = Tour::join('guide_list', 'tour.owner_id', '=', 'guide_list.account_id_account')
                                                ->where('tour.id_tour', $tourID)
                                                ->select('tour.*', 'guide_list.name as guide_name', 'guide_list.surname as guide_surname')
                                                ->first(); break;
          case "corp":  $productData = Tour::join('corp_list', 'tour.owner_id', '=', 'corp_list.account_id_account')
                                                ->where('tour.id_tour', $tourID)
                                                ->select('tour.*', 'corp_list.name as corp_name')
                                                ->first(); break; 
        }
        $locationInTourData = LocationInTour::where('tour_id_tour',$tourID)->pluck('loc_api');
        $locationFetchApi = $locationInTourData->map(function ($apiUrl) {
          $response = Http::get($apiUrl);
          return $response->successful() ? $response->json() : null;
      })->filter();
        return view('viewProduct',[
          'tour_info' => $productData,
          'locations' => $locationFetchApi
        ]);
      }

}
