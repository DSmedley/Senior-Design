<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Analyses;
use App\Link;
use App\Hashtag;
use App\Mention;
use App\Hour;
use App\Url;
use DateTime;

class CashtagController extends Controller
{
    public function index(){
        return view('cashtag');
    }
    
}