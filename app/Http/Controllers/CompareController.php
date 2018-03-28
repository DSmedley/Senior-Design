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
        
        if(isset($analysis1['errors'])){
            return redirect()->route('compare')->with('twitterError', $analysis1['errors']['0']['message']);
        }
        
        $analysis2 = $analyze->getData($request->get('name2'));
        
        if(isset($analysis2['errors'])){
            return redirect()->route('compare')->with('twitterError', $analysis2['errors']['0']['message']);
        }
        
        $data = array(
            'first' => $analysis1->id,
            'second' => $analysis2->id,
        );
        
        if(!empty($request->get('name3'))){
            $analysis3 = $analyze->getData($request->get('name3'));
            
            if(isset($analysis3['errors'])){
                return redirect()->route('compare')->with('twitterError', $analysis3['errors']['0']['message']);
            }
            
            $data['third'] = $analysis3->id;
        }
        
        if(!empty($request->get('name4'))){
            $analysis4 = $analyze->getData($request->get('name4'));
            
            if(isset($analysis4['errors'])){
                return redirect()->route('compare')->with('twitterError', $analysis4['errors']['0']['message']);
            }
            
            $data['fourth'] = $analysis4->id;
        }
        
        return redirect()->route('compare.view', $data);
    }
    
    public function getCompare($first = null, $second = null, $third = null, $fourth = null)
    {
        //Get data from specified analysis
        //Else return error
        $firstData = null;
        $secondData = null;
        $thirdData = null;
        $fourthData = null;
        
        if ($first){
            $analysis1 = Analyses::where('id', $first)->first();
            $hashtags = Hashtag::where('analysis_id', $analysis1->id)->get();
            $hours = Hour::select('hour', 'occurs')->where('analysis_id', $analysis1->id)->orderBy('hour')->get();
            $urls = Url::where('analysis_id', $analysis1->id)->get();
            
            $firstData = array(
               'analysis'   => $analysis1,
               'hashtags'  => $hashtags,
               'hours'   => $hours,
               'urls'  => $urls,
            );
        }
        if ($second){
            $analysis2 = Analyses::where('id', $second)->first();
            $hashtags = Hashtag::where('analysis_id', $analysis2->id)->get();
            $hours = Hour::select('hour', 'occurs')->where('analysis_id', $analysis2->id)->orderBy('hour')->get();
            $urls = Url::where('analysis_id', $analysis2->id)->get();
            
            $secondData = array(
               'analysis'   => $analysis2,
               'hashtags'  => $hashtags,
               'hours'   => $hours,
               'urls'  => $urls,
            );
        }
        if ($third){
            $analysis3 = Analyses::where('id', $third)->first();
            $hashtags = Hashtag::where('analysis_id', $analysis3->id)->get();
            $hours = Hour::select('hour', 'occurs')->where('analysis_id', $analysis3->id)->orderBy('hour')->get();
            $urls = Url::where('analysis_id', $analysis3->id)->get();
            
            $thirdData = array(
               'analysis'   => $analysis3,
               'hashtags'  => $hashtags,
               'hours'   => $hours,
               'urls'  => $urls,
            );
        }
        if ($fourth){
            $analysis4 = Analyses::where('id', $fourth)->first();
            $hashtags = Hashtag::where('analysis_id', $analysis4->id)->get();
            $hours = Hour::select('hour', 'occurs')->where('analysis_id', $analysis4->id)->orderBy('hour')->get();
            $urls = Url::where('analysis_id', $analysis4->id)->get();
            
            $fourthData = array(
               'analysis'   => $analysis4,
               'hashtags'  => $hashtags,
               'hours'   => $hours,
               'urls'  => $urls,
            );
        }

        $data = array(
           'first'   => $firstData,
           'second'  => $secondData,
           'third'   => $thirdData,
           'fourth'  => $fourthData,
        );
        
        //Return to analysis page
        return view('compare')->with($data);
    }
}