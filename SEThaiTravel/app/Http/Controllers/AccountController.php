<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\Account;
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
}
