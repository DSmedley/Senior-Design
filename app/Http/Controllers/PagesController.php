<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Analyses;
use DB;

class PagesController extends Controller
{
    public function getHome(){
        /*$recents = Analyses::select()
                ->groupby('screen_name')
                ->orderby('created_at','desc')
                ->limit('18')
                ->get();*/
        
        //$recents = DB::select( DB::raw("SELECT DISTINCT screen_name FROM Analyses LIMIT 18") );
        //$recents = DB::select( DB::raw("SELECT * FROM Analyses GROUP BY screen_name ORDER BY created_at DESC LIMIT 12") );
        //$recents = DB::select( DB::raw("select * from Analyses join (select screen_name, max(created_at) as created_at from Analyses group by screen_name, created_at)") );
        //select screen_name, max(created_at) as created_at from Analyses group by screen_name, created_at
        
        $recents = DB::select( DB::raw("select * from analyses join (select screen_name, max(created_at) as created_at from analyses group by screen_name) latest on latest.created_at = analyses.created_at ORDER BY analyses.id DESC") );
        
        /*$recents = Analyses::select()
        ->join('Analyses as Latest', function($join) {
            $join->on('Latest.created_at', '=', 'Analyses.created_at');
        })
        ->orderBy('Analyses.created_at','desc')
        ->limit('18')
        ->get();*/
        
        return view('welcome')->with('recents', $recents);
    }
    
    public function getAbout(){
        return view('about');
    }
    
    public function getContact(){
        return view('contact');
    }
}
