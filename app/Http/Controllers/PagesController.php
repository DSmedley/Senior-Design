<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Analyses;
use DB;

class PagesController extends Controller
{
    public function getHome(){
        $recents = DB::select( DB::raw("select * from analyses join (select screen_name, max(created_at) as created_at from analyses group by screen_name) latest on latest.created_at = analyses.created_at ORDER BY analyses.id DESC LIMIT 18") );
        
        return view('welcome')->with('recents', $recents);
    }
    
    public function getAbout(){
        return view('about');
    }
    
    public function getContact(){
        return view('contact');
    }
}
