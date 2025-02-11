<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\CorpList;
class CorpListController extends Controller
{
    function checkTable(){
        if (Schema::hasTable((new CorpList)->getTable())) {
            echo "Corp exists!";
        } 
        else{
            echo "Table does not exist!";
        }
      }
}
