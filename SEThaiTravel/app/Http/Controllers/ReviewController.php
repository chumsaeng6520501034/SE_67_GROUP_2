<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\Review;
class ReviewController extends Controller
{
    function checkTable(){
        if (Schema::hasTable((new Review)->getTable())) {
            echo "Review exists!";
        } 
        else{
            echo "Table does not exist!";
        }
      }
}
