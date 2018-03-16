<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Analyses;
use DB;

class PagesController extends Controller
{
    public function getHome(){
        /*$recents = Analyses::select()
                ->distinct('screen_name')
                ->get();*/
        
        //$recents = DB::select( DB::raw("SELECT DISTINCT screen_name FROM Analyses LIMIT 18") );
        $recents = DB::select( DB::raw("SELECT *, max(created_at) FROM Analyses GROUP BY screen_name ORDER BY created_at DESC LIMIT 12") );
        //$recents = DB::select( DB::raw("select * from Analyses join (select screen_name, max(created_at) as created_at from Analyses group by screen_name) using (screen_name, created_at)") );
        
        return view('welcome')->with('recents', $recents);
    }
    
    public function getAbout(){
        return view('about');
    }
    
    public function getContact(){
        return view('contact');
    }
}
