<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\CorpList;
use App\Models\GuideList;
use App\Models\UserList;
use App\Models\Tour;
use App\Models\LocationInTour;
class AccountController extends Controller
{
    function checkTable(){
        if (Schema::hasTable((new Account)->getTable())) {
            echo "Account exists!";
        } 
        else{
            echo "Table does not exist!";
        }
      }
      function checkLogin(Request $request){
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
                return "This is admin page"; //ของจริงจะใส่เป็น view('ชื่อของไฟล์ที่เป็นหน้า',compact('ตัวแปรที่เก็บข้อมูลของadmin'))
              case "corp"  :
                  $corp= CorpList::find($account->id_account);
                  session(['userID' => $corp]);
                  dd($corp);
                return "This is corp page";
              case "user"  : 
                  $user= UserList::find($account->id_account);
                  // dd($user);
                  session(['userID' => $user]);
                return view('userPage');
              case "guide" : 
                  $guide= GuideList::find($account->id_account);
                  session(['userID' => $guide]);
                  dd($guide);
                return "This is guide page";
          }
        }
        // return view('test',compact('account'));
      }
      function signin(Request $request){
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
          $checkAcc=Account::where('username',$request->username)->first();
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
      function insertCorp(Request $request){
        // dd($request->all());
        $accountData=[
          'permittion_acc'=>$request->typeOfSign,
          'username'=>$request->username,
          'password'=>$request->password,
          'email'=>$request->email,
          'status'=>'pending'
        ];
        // dd($accountData);
        // Account::insert($accountData);
        // $idAcc = Account::where()    
        // $idAcc->id_account
        $corpData=[
          'account_id_account'=>1,
          'corp_license'=>$request->registNum,
          // 'logo'=>$request->logo,
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
        dd($corpData);
        //insert corp
      }
      function insertUser(Request $request){
        $accountData=[
          'permittion_acc'=>$request->typeOfSign,
          'username'=>$request->username,
          'password'=>$request->password,
          'email'=>$request->email,
          'status'=>'pending'
        ];
        // dd($accountData);
        // Account::insert($accountData);
        // $idAcc = Account::where()    
        // $idAcc->id_account
        $userData=[
          'account_id_account'=>1,//สมมมุตินะของจริงต้องใช้ id ที่พึ่งใส่ไป
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
        dd($userData);
        //insert user
      }
      function insertGuide(Request $request){
        $accountData=[
          'permittion_acc'=>$request->typeOfSign,
          'username'=>$request->username,
          'password'=>$request->password,
          'email'=>$request->email,
          'status'=>'pending'
        ];
        // dd($accountData);
        // Account::insert($accountData);
        // $idAcc = Account::where()    
        // $idAcc->id_account
        $guideData=[
          'account_id_account'=>1,//สมมมุตินะของจริงต้องใช้ id ที่พึ่งใส่ไป
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
        dd($guideData);
        //insert guide
      }
      function search(Request $request){
      }

      function logOut(Request $request){
        $request->session()->invalidate(); // ทำให้ session ID ปัจจุบันใช้ไม่ได้
        $request->session()->regenerateToken(); // สร้าง CSRF token ใหม่ ป้องกัน 419 Page Expired
        return view('login');
      }
      function viewProduct(Request $request){//อันนี้ยังไม่เสร็จ
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
