<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\Payment;
class PaymentController extends Controller
{
    function checkTable(){
        if (Schema::hasTable((new Payment)->getTable())) {
            echo "Payment exists!";
        } 
        else{
            echo "Table does not exist!";
        }
      }
}
