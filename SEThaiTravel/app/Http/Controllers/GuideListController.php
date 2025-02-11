<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\GuideList;
class GuideListController extends Controller
{
    function checkTable(){
        if (Schema::hasTable((new GuideList)->getTable())) {
            echo "Guide exists!";
        } 
        else{
            echo "Table does not exist!";
        }
      }
}
