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

class CompareController extends Controller
{
    public function index(){
        return view('compare');
    }
    
    public function compare(Request $request){
        $validatedData = $request->validate([
            'name1' => 'required',
            'name2' => 'required',
        ]);
        
        $analyze = new AnalysesController();
        
        $analysis1 = $analyze->getData($request->get('name1'));
        $analysis2 = $analyze->getData($request->get('name2'));
        
        $data = array(
            'first' => $analysis1->id,
            'second' => $analysis2->id,
        );
        
        if(!empty($request->get('name3'))){
            $analysis3 = $analyze->getData($request->get('name3'));
            $data['third'] = $analysis3->id;
        }
        
        if(!empty($request->get('name4'))){
            $analysis4 = $analyze->getData($request->get('name4'));
            $data['fourth'] = $analysis4->id;
        }
        
        return redirect()->route('compare.view', $data);
    }
    
    public function getCompare($first = null, $second = null, $third = null, $fourth = null)
    {
        //Get data from specified analysis
        //Else return error
        $analysis1 = null;
        $analysis2 = null;
        $analysis3 = null;
        $analysis4 = null;
        
        if ($first){
            $analysis1 = Analyses::where('id', $first)->first();
        }
        if ($second){
            $analysis2 = Analyses::where('id', $second)->first();
        }
        if ($third){
            $analysis3 = Analyses::where('id', $third)->first();
        }
        if ($fourth){
            $analysis4 = Analyses::where('id', $fourth)->first();
        }

        $data = array(
           'first'   => $analysis1,
           'second'  => $analysis2,
           'third'   => $analysis3,
           'fourth'  => $analysis4,
        );
        
        //Return to analysis page
        return view('compare')->with($data);
    }
}