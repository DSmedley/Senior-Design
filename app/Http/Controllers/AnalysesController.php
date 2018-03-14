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
    
    public function getAnalysisCashtag($id = null)
    {
        //Get data from specified analysis
        //Else return error
        if ($id){
            $analysis = Analyses::where('id', $id)->first();
        }

        //Return to analysis page
        return view('cashtag')->with('analysis', $analysis);
    }
    
    public function compare($first = null, $second = null, $third = null, $fourth = null)
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
    
    public function analyze(Request $request){
        $this->validate($request, [
            'name' => 'required_without_all:cashtag',
            'cashtag' => 'required_without_all:name',
        ]);
        if($request->get('name') != null){
            $analysis = $this->getData($request->get('name'));
        
            if(isset($analysis['errors'])){
                return redirect()->route('analyze')->with('twitterError', $analysis['errors']['0']['message']);
            }

            if (Auth::check()){
                $this->linkAnalysis(Auth::user()->id, $analysis->id);
            }

            return view('analysis')->with('analysis', $analysis);
        }else if($request->get('cashtag') != null){
            $analysis = $this->getCashtagData($request->get('cashtag'));
        
            if(isset($analysis['errors'])){
                return redirect()->route('analyze')->with('twitterError', $analysis['errors']['0']['message']);
            }

            if (Auth::check()){
                $this->linkAnalysis(Auth::user()->id, $analysis->id);
            }
            
            return view('cashtag')->with('analysis', $analysis);
        }
        
        
    }
    
    public function linkAnalysis($userID = null, $analysisID = null){
        //link analysis to account
        $link = new Link;
        $link->user_id = $userID;
        $link->analysis_id = $analysisID;
        //save link
        $link->save();
    }
    
    public function linkAnalysisCashtag($userID = null, $analysisID = null){
        //link analysis to account
        $link = new Link;
        $link->user_id = $userID;
        $link->analysis_id = $analysisID;
        //save link
        $link->save();
    }
    
    public function getCashtagData($screen_name = null){
        /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
        $settings = array(
            'oauth_access_token' => "419236098-ybBLRsLig8sSd5LttZ6voxm9Gv3I8yul3JlvzGuD",
            'oauth_access_token_secret' => "7ADQVV1qNy8cLQ7WO64F5FlF4UieOJh8WcevN8swx1Thd",
            'consumer_key' => "4OvrblQjDT4rHklRfrDJURQsH",
            'consumer_secret' => "XtGT33U06TvJ4l4VdHYRb4BINo9P3ebc6XsJsgcxNJWEZtCFJk"
        );
        
        if(isset($results['errors'])){
            return $results;
        }

        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        $getfield = '?screen_name='.$screen_name.'&truncated=false&tweet_mode=extended&count=200';
        $requestMethod = 'GET';
        $twitter = new TwitterController($settings);
        $tweetResults = $twitter->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest();

        $tweetResults = json_decode($tweetResults, true);

        for($x=0; $x<sizeof($tweetResults); $x++) {
            $tweet = $tweetResults[$x]['full_text'];
            $tweet = preg_replace("/[^ \w]+/",'',$tweet);
            $tweetsArray[$x]['text'] = $tweet;
        }

        $time_end = microtime(true);
        $file = $screen_name.'-'.$time_end.'.json';
        $fp = fopen('py/temp/'.$file, 'w');
        fwrite($fp, json_encode($tweetsArray));
        fclose($fp);

        $tweets = new PythonController();
        $emotions = json_decode($tweets->python($file));

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
        $analysis->positive = $emotions->positive;
        $analysis->negative = $emotions->negative;
        $analysis->neutral = $emotions->neutral;
        $analysis->anger = $emotions->anger;
        $analysis->anticipation = $emotions->anticipation;
        $analysis->disgust = $emotions->disgust;
        $analysis->fear = $emotions->fear;
        $analysis->joy = $emotions->joy;
        $analysis->sadness = $emotions->sadness;
        $analysis->surprise = $emotions->surprise;
        $analysis->trust = $emotions->trust;
        $analysis->none = $emotions->nada;

        //Save the analysis into the database
        $analysis->save();

        //return twitter user details
        $result = Analyses::where('id', '=', $analysis->id)->first();
        
        return $result;
    }
    
    public function getData($screen_name = null){
        /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
        $settings = array(
            'oauth_access_token' => "419236098-ybBLRsLig8sSd5LttZ6voxm9Gv3I8yul3JlvzGuD",
            'oauth_access_token_secret' => "7ADQVV1qNy8cLQ7WO64F5FlF4UieOJh8WcevN8swx1Thd",
            'consumer_key' => "4OvrblQjDT4rHklRfrDJURQsH",
            'consumer_secret' => "XtGT33U06TvJ4l4VdHYRb4BINo9P3ebc6XsJsgcxNJWEZtCFJk"
        );

        $url = 'https://api.twitter.com/1.1/users/lookup.json';
        $getfield = '?screen_name='.$screen_name;
        $requestMethod = 'GET';
        $twitter = new TwitterController($settings);
        $results = $twitter->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest(); 
        
        $results = json_decode($results, true);
        
        if(isset($results['errors'])){
            return $results;
        }
        
        if(!$results['0']['protected']){

            $profile_image = str_replace("/", "", $results['0']['profile_image_url']);
            $profile_image = str_replace("normal", "400x400", $results['0']['profile_image_url']);

            $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
            $getfield = '?screen_name='.$screen_name.'&truncated=false&tweet_mode=extended&count=200';
            $requestMethod = 'GET';
            $twitter = new TwitterController($settings);
            $tweetResults = $twitter->setGetfield($getfield)
                         ->buildOauth($url, $requestMethod)
                         ->performRequest();

            $tweetResults = json_decode($tweetResults, true);

            for($x=0; $x<sizeof($tweetResults); $x++) {
                $tweet = $tweetResults[$x]['full_text'];
                $tweet = preg_replace("/[^ \w]+/",'',$tweet);
                $tweetsArray[$x]['text'] = $tweet;
            }

            $time_end = microtime(true);
            $file = $screen_name.'-'.$time_end.'.json';
            $fp = fopen('py/temp/'.$file, 'w');
            fwrite($fp, json_encode($tweetsArray));
            fclose($fp);

            $tweets = new PythonController();
            $emotions = json_decode($tweets->python($file));

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
            $analysis->positive = $emotions->positive;
            $analysis->negative = $emotions->negative;
            $analysis->neutral = $emotions->neutral;
            $analysis->anger = $emotions->anger;
            $analysis->anticipation = $emotions->anticipation;
            $analysis->disgust = $emotions->disgust;
            $analysis->fear = $emotions->fear;
            $analysis->joy = $emotions->joy;
            $analysis->sadness = $emotions->sadness;
            $analysis->surprise = $emotions->surprise;
            $analysis->trust = $emotions->trust;
            $analysis->none = $emotions->nada;

            //Save the analysis into the database
            $analysis->save();

            //return twitter user details
            $result = Analyses::where('id', '=', $analysis->id)->first();
        }else{
            
            $result['errors']['0']['message'] = "This user account is private!";
        }
        
        return $result;
    }
    
}
