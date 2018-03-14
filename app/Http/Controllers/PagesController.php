<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Analyses;

class PagesController extends Controller
{
    public function getHome(){
        $recents = Analyses::orderBy('id')
                ->limit(20)
                ->get();
        
        return view('welcome')->with('recents', $recents);
    }
    
    public function getAbout(){
        return view('about');
    }
    
    public function getContact(){
        return view('contact');
    }
}
