<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\UserList;
class UserListController extends Controller
{
    function checkTable(){
        if (Schema::hasTable((new UserList)->getTable())) {
            echo "Userlist exists!";
        } 
        else{
            echo "Table does not exist!";
        }
      }
}
