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
        return view('account.logIn');
      }
      function checkLogin(Request $request){ //ตรวจสอบการ login ว่าเป็น user ประเภทไหน แล้ว Redirect ไปที่หน้าของ Account ประเภทนั้น
        $request->validate([
          'username'=>'required',
          'password'=>'required'
          ],
          );
          // $account = Account::where('username', $request->username)->first();
        //   if (!$account || !Hash::check($request->password, $account->password)) {
        //     return redirect()->back()->withErrors(['login_failed' => 'Invalid username or password'])->withInput();
        // }
        $account = Account::where('username',$request->username)->where('password',$request->password)->where('status', 'NOT LIKE', 'disappear')->where('status', 'NOT LIKE', 'pending')->first();
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
                return view('customer.home');
              case "guide" : 
                  $guide= GuideList::find($account->id_account);
                  session(['userID' => $guide]);
                  // dd($guide);
                return view('guidePage');
          }
        }
      }
      function viewSignIn(){ // Redirect ไปที่ หน้า signIn หน้าแรกที่มีให้เลือกประเภทการ SignIn
        
        return view('account.signUp');
      }
      function signIn(Request $request){ // รับข้อมูลจากหน้า signIn หน้าเเรกแล้วมาแบ่งประเภทว่าจะ Redirect ไปหน้า signIn ที่เลือกมา
          $request->validate([
          'username'=>'required',
          'password'=>'required',
          'email'=>'required'
          ],
          );
          $username= $request->username;
          // $password=Hash::make($request->password);
          $password= $request->password;
          $email=$request->email;
          $typeOfSign= $request->role;
          $checkAcc=Account::where('username',$username)
                             ->orWhere('email', 'LIKE', $email)
                             ->first();//ใช้ตรวจสอบ username email ว่ามีแล้วหรือยัง
          $allCountry = $this->getCountry();
          if(is_null($checkAcc)){
            switch($typeOfSign){
              case 'corp': 
                return view('account.signUpCorperation',compact('username','password','typeOfSign','email','allCountry'));
              case 'guide': 
                return view('account.signUpGuide',compact('username','password','typeOfSign','email','allCountry'));
              case 'user': 
                return view('account.signUpCustomer',compact('username','password','typeOfSign','email','allCountry'));
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
          'status'=>'available'
        ];
        // dd($accountData);
        Account::insert($accountData);
        $idAcc = Account::where('username',$request->username)->first();    
        $userData=[
          'account_id_account'=> $idAcc->id_account,//สมมมุตินะของจริงต้องใช้ id ที่พึ่งใส่ไป $idAcc->id_account
          'name'=>$request->name,
          'surname'=> $request->surname,
          'photo'=> NULL,
          'phonenumber'=>$request->phonenumber,
          'fake_BAN'=>$request->fake_BAN,
          'address'=>$request->address." ".$request->district." ".$request->subdistrict.
          " ".$request->province,
          'postcode'=>$request->postcode,
          'country'=>$request->country//อันนี้ก็สมมติของจริงน่าจะมีเงื่อนไขเเล้วค่อยนำค่ามาใส่
        ]; 
        // dd($userData);
        UserList::insert($userData);
        return redirect('/');
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
          $searchTourData = Tour::where(function ($query) use ($name, $startDate, $endDate, $capacity) {
            $query->where('name', 'LIKE', '%'.$name.'%')
                  ->orWhere('start_tour_date', '=', $startDate) // เปลี่ยน LIKE เป็น =
                  ->orWhere('end_tour_date', '=', $endDate) // เปลี่ยน LIKE เป็น =
                  ->orWhere('tour_capacity', '>=', $capacity); // ไม่มี LIKE กับตัวเลข
                  })
                  ->where('status', 'LIKE', 'ongoing')
                  ->where('type_tour', 'LIKE', 'private')
                  ->paginate(2)->appends($request->query());
              }
        else{
          $searchTourData =Tour::where(function ($query) use ( $name, $startDate, $endDate,$capacity)  {
          $query->where('start_tour_date', '=', $startDate)
                ->orWhere('end_tour_date', '=',  $endDate)
                ->orWhere('tour_capacity', '>=', $capacity);
                })
                ->whereRaw('LOWER(tour.name) LIKE LOWER(?)', ['%'.$name.'%'])
                ->where('status', 'LIKE', 'ongoing')
                ->where('type_tour', 'LIKE', 'public')
                ->paginate(2)->appends($request->query());
        }
        $ownerData = [];
        $totalMember = [];
        $ownerScore = [];
        foreach($searchTourData as $data){//อันนหาหาข้อมูลของเจ้าของทัวร์นั้นๆแล้วส่งไปใน view ด้วยเผื่อใช้
            switch($data->from_owner){
              case "guide": $ownerData[] = GuideList::find($data->owner_id)->first(); 
                            $ownerScore [] = Review::leftJoin('guide_list', 'review.guide_list_account_id_account', '=', 'guide_list.account_id_account')
                            ->where('guide_list.account_id_account', $data->owner_id) // กรองเฉพาะ owner_id ที่ต้องการ
                            ->selectRaw('COUNT(*) as total_reviews, AVG(review.sp_score) as average_score')
                            ->first();
                            break;
              case "corp": $ownerData[] = CorpList::find($data->owner_id)->first(); 
                           $ownerScore [] = Review::leftJoin('booking', 'review.booking_id_booking', '=', 'booking.id_booking')
                            ->leftJoin('tour', function($join) {
                                $join->on('tour.id_tour', '=', 'booking.tour_id_tour')
                                    ->where('tour.from_owner', 'LIKE', 'corp');
                            })
                            ->leftJoin('corp_list', 'corp_list.account_id_account', '=', 'tour.owner_id')
                            ->where('corp_list.account_id_account', $data->owner_id)
                            ->selectRaw('COUNT(*) as total_reviews, AVG(review.sp_score) as average_score')
                            ->first(); // ใช้ `first()` เพราะดึงแค่บริษัทเดียว
                            break;
            }
            $totalMember[]= Booking::where('tour_id_tour', $data->id_tour ) //TourID ใช้ของที่กดจองมา
            ->where('status', 'NOT LIKE', 'cancel')
            ->selectRaw('SUM(adult_qty + kid_qty) as Total_Member')
            ->value('Total_Member');
        }
        return view('user.search',compact('ownerData','searchTourData','totalMember','ownerScore'));
      }

      function logOut(Request $request){//Log out แล้ว เคลีย session ทิ้ง
        $request->session()->invalidate(); // ทำให้ session ID ปัจจุบันใช้ไม่ได้
        $request->session()->regenerateToken(); // สร้าง CSRF token ใหม่ ป้องกัน 419 Page Expired
        return redirect('/'); //redirect('/')
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
      function getCountry(){
       return $countries = [
          1 => "Afghanistan",
          2 => "Albania",
          3 => "Algeria",
          4 => "Andorra",
          5 => "Angola",
          6 => "Antigua and Barbuda",
          7 => "Argentina",
          8 => "Armenia",
          9 => "Australia",
          10 => "Austria",
          11 => "Azerbaijan",
          12 => "Bahamas",
          13 => "Bahrain",
          14 => "Bangladesh",
          15 => "Barbados",
          16 => "Belarus",
          17 => "Belgium",
          18 => "Belize",
          19 => "Benin",
          20 => "Bhutan",
          21 => "Bolivia",
          22 => "Bosnia and Herzegovina",
          23 => "Botswana",
          24 => "Brazil",
          25 => "Brunei",
          26 => "Bulgaria",
          27 => "Burkina Faso",
          28 => "Burundi",
          29 => "Cabo Verde",
          30 => "Cambodia",
          31 => "Cameroon",
          32 => "Canada",
          33 => "Central African Republic",
          34 => "Chad",
          35 => "Chile",
          36 => "China",
          37 => "Colombia",
          38 => "Comoros",
          39 => "Congo (Congo-Brazzaville)",
          40 => "Congo (Congo-Kinshasa)",
          41 => "Costa Rica",
          42 => "Croatia",
          43 => "Cuba",
          44 => "Cyprus",
          45 => "Czechia",
          46 => "Denmark",
          47 => "Djibouti",
          48 => "Dominica",
          49 => "Dominican Republic",
          50 => "Ecuador",
          51 => "Egypt",
          52 => "El Salvador",
          53 => "Equatorial Guinea",
          54 => "Eritrea",
          55 => "Estonia",
          56 => "Eswatini",
          57 => "Ethiopia",
          58 => "Fiji",
          59 => "Finland",
          60 => "France",
          61 => "Gabon",
          62 => "Gambia",
          63 => "Georgia",
          64 => "Germany",
          65 => "Ghana",
          66 => "Greece",
          67 => "Grenada",
          68 => "Guatemala",
          69 => "Guinea",
          70 => "Guinea-Bissau",
          71 => "Guyana",
          72 => "Haiti",
          73 => "Honduras",
          74 => "Hungary",
          75 => "Iceland",
          76 => "India",
          77 => "Indonesia",
          78 => "Iran",
          79 => "Iraq",
          80 => "Ireland",
          81 => "Israel",
          82 => "Italy",
          83 => "Jamaica",
          84 => "Japan",
          85 => "Jordan",
          86 => "Kazakhstan",
          87 => "Kenya",
          88 => "Kiribati",
          89 => "Kuwait",
          90 => "Kyrgyzstan",
          91 => "Laos",
          92 => "Latvia",
          93 => "Lebanon",
          94 => "Lesotho",
          95 => "Liberia",
          96 => "Libya",
          97 => "Liechtenstein",
          98 => "Lithuania",
          99 => "Luxembourg",
          100 => "Madagascar",
          101 => "Malawi",
          102 => "Malaysia",
          103 => "Maldives",
          104 => "Mali",
          105 => "Malta",
          106 => "Marshall Islands",
          107 => "Mauritania",
          108 => "Mauritius",
          109 => "Mexico",
          110 => "Micronesia",
          111 => "Moldova",
          112 => "Monaco",
          113 => "Mongolia",
          114 => "Montenegro",
          115 => "Morocco",
          116 => "Mozambique",
          117 => "Myanmar",
          118 => "Namibia",
          119 => "Nauru",
          120 => "Nepal",
          121 => "Netherlands",
          122 => "New Zealand",
          123 => "Nicaragua",
          124 => "Niger",
          125 => "Nigeria",
          126 => "North Korea",
          127 => "North Macedonia",
          128 => "Norway",
          129 => "Oman",
          130 => "Pakistan",
          131 => "Palau",
          132 => "Palestine",
          133 => "Panama",
          134 => "Papua New Guinea",
          135 => "Paraguay",
          136 => "Peru",
          137 => "Philippines",
          138 => "Poland",
          139 => "Portugal",
          140 => "Qatar",
          141 => "Romania",
          142 => "Russia",
          143 => "Rwanda",
          144 => "Saint Kitts & Nevis",
          145 => "Saint Lucia",
          146 => "Saint Vincent & Grenadines",
          147 => "Samoa",
          148 => "San Marino",
          149 => "Sao Tome & Principe",
          150 => "Saudi Arabia",
          151 => "Senegal",
          152 => "Serbia",
          153 => "Seychelles",
          154 => "Sierra Leone",
          155 => "Singapore",
          156 => "Slovakia",
          157 => "Slovenia",
          158 => "Solomon Islands",
          159 => "Somalia",
          160 => "South Africa",
          161 => "South Korea",
          162 => "South Sudan",
          163 => "Spain",
          164 => "Sri Lanka",
          165 => "Sudan",
          166 => "Suriname",
          167 => "Sweden",
          168 => "Switzerland",
          169 => "Syria",
          170 => "Tajikistan",
          171 => "Tanzania",
          172 => "Thailand",
          173 => "Timor-Leste",
          174 => "Togo",
          175 => "Tonga",
          176 => "Trinidad and Tobago",
          177 => "Tunisia",
          178 => "Turkey",
          179 => "Turkmenistan",
          180 => "Tuvalu",
          181 => "Uganda",
          182 => "Ukraine",
          183 => "United Arab Emirates",
          184 => "United Kingdom",
          185 => "United States",
          186 => "Uruguay",
          187 => "Uzbekistan",
          188 => "Vanuatu",
          189 => "Vatican City",
          190 => "Venezuela",
          191 => "Vietnam",
          192 => "Yemen",
          193 => "Zambia",
          194 => "Zimbabwe"
      ];
      }
      
      function deleteAccountForm(Request $request){
        $idAccount = $request->requestID;
        return view('deleteAccount', compact('idAccount'));
      }
      //ลบรีเควสท์//
      function deleteAccount(Request $request){
        $idAccount = session('userID')->account_id_account;
        $accountData = ['status' => 'disappear'];
        Account::where('id_account', $idAccount)->update($accountData);
        $request->session()->invalidate(); // ทำให้ session ID ปัจจุบันใช้ไม่ได้
        $request->session()->regenerateToken(); // สร้าง CSRF token ใหม่ ป้องกัน 419 Page Expired
        return redirect('/');
      }


}
