<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\Offer;
class OfferController extends Controller
{
    function checkTable(){
        if (Schema::hasTable((new Offer)->getTable())) {
            echo "Offer exists!";
        } 
        else{
            echo "Table does not exist!";
        }
      }
}
