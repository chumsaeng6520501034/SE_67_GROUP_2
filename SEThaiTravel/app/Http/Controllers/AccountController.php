<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\CorpList;
use App\Models\GuideList;
use App\Models\UserList;
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
      function index(Request $request){
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
                  dd($corp);
                return "This is corp page";
              case "user"  : 
                  $user= UserList::find($account->id_account);
                  dd($user);
                return "This is user page";
              case "guide" : 
                  $guide= GuideList::find($account->id_account);
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
              case 'guide': return "This is guide sign in page";
              case 'user': return "This is user sign in page";
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
      }
      function insertUser(Request $request){
        
      }
      function insertGuide(Request $request){

      }
      function search(Request $request){
        
      }
      //login sign-in search viewProduct 

}
