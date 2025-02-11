<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\RequestTour;
class RequestTourController extends Controller
{
    function checkTable(){
        if (Schema::hasTable((new RequestTour)->getTable())) {
            echo "RequestTour exists!";
        } 
        else{
            echo "Table does not exist!";
        }
      }
}
