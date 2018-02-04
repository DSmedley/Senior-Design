<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Analyses;
use App\Link;

class AnalysesController extends Controller
{
    public function index(){
        return view('analysis');
    }
    
    public function getAnalysis($id = null)
    {
        //Get data from specified analysis
        //Else return error
        if ($id){
            $analysis = Analyses::where('id', $id)->first();
        }

        //Return to analysis page
        return view('analysis')->with('analysis', $analysis);
    }
    
    public function analyze(Request $request){
        $analysis = $this->getData($request);
        
        if (Auth::check()){
            //link analysis to account
            $link = new Link;
            $link->user_id = Auth::user()->id;
            $link->analysis_id = $analysis->id;
            //save link
            $link->save();
        }
        
        
        //return twitter user details
        $result = Analyses::where('id', '=', $analysis->id)->first();
        return view('analysis')->with('analysis', $result);
        
    }
    
    public function getData(Request $request){
        $this->validate($request, [
            'name' => 'required'
        ]);
                
        /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
        $settings = array(
            'oauth_access_token' => "419236098-ybBLRsLig8sSd5LttZ6voxm9Gv3I8yul3JlvzGuD",
            'oauth_access_token_secret' => "7ADQVV1qNy8cLQ7WO64F5FlF4UieOJh8WcevN8swx1Thd",
            'consumer_key' => "4OvrblQjDT4rHklRfrDJURQsH",
            'consumer_secret' => "XtGT33U06TvJ4l4VdHYRb4BINo9P3ebc6XsJsgcxNJWEZtCFJk"
        );

        $url = 'https://api.twitter.com/1.1/users/lookup.json';
        $getfield = '?screen_name='.$request->get('name');
        $requestMethod = 'GET';
        $twitter = new TwitterController($settings);
        $results = $twitter->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest(); 
        
        $results = json_decode($results, true);
        
        $profile_image = str_replace("/", "", $results['0']['profile_image_url']);
        $profile_image = str_replace("normal", "400x400", $results['0']['profile_image_url']);
        
        //create a new analysis
        $analysis = new Analyses;
        $analysis->twitter_id = $results['0']['id'];
        $analysis->name = $results['0']['name'];
        $analysis->screen_name = $results['0']['screen_name'];
        $analysis->location = $results['0']['location'];
        $analysis->profile_image = $profile_image;
        $analysis->description = $results['0']['description'];
        $analysis->tweets = $results['0']['statuses_count'];
        $analysis->following = $results['0']['friends_count'];
        $analysis->followers = $results['0']['followers_count'];
        $analysis->likes = $results['0']['favourites_count'];
        //Save the analysis into the database
        $analysis->save();
        
        return $analysis;
    }
    
}
