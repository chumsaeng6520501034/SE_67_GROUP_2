<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\TourHasGuideList;
class TourHasGuideListController extends Controller
{
    function checkTable(){
        if (Schema::hasTable((new TourHasGuideList)->getTable())) {
            echo "TourHasGuide exists!";
        } 
        else{
            echo "Table does not exist!";
        }
      }
}
