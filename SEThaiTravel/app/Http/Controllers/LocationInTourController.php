<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\LocationInTour;
class LocationInTourController extends Controller
{
    function checkTable(){
        if (Schema::hasTable((new LocationInTour)->getTable())) {
            echo "LocationInTour exists!";
        } 
        else{
            echo "Table does not exist!";
        }
      }
}
