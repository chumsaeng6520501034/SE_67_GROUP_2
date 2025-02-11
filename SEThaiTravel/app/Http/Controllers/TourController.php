<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\Tour;
class TourController extends Controller
{
    function checkTable(){
        if (Schema::hasTable((new Tour)->getTable())) {
            echo "Tour exists!";
        } 
        else{
            echo "Table does not exist!";
        }
      }
}
