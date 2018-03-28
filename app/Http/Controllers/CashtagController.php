<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Cashtag_Report;
use App\Cashtag_People;
use App\Cashtag_Hours;
use DateTime;

class CashtagController extends Controller
{
    public function index(){
        return view('cashtag');
    }
    
    public function getCashtag($id = null, $name = null)
    {
        //Get data from specified analysis
        //Else return error
        if ($id){
            $analysis = Cashtag_Report::where('id', $id)->first();
        }
        
        $data = null;
        
        if(isset($analysis->id)){
            $people = Cashtag_people::where('cashtag_id', $analysis->id)->get();
            $hours = Cashtag_Hours::select('hour', 'occurs')->where('cashtag_id', $analysis->id)->orderBy('hour')->get();

            $data = array(
               'analysis'   => $analysis,
               'people'   => $people,
               'hours'      => $hours,
            );
        }

        //Return to analysis page
        return view('cashtag')->with($data);
    }
    
    public function analyze(Request $request){
        $this->validate($request, [
            'cashtag' => 'required',
        ]);
        $cashtag = $request->get('cashtag');
        
        $analysis = $this->getData($cashtag);

        if(isset($analysis['errors'])){
            return redirect()->route('analyze')->with('twitterError', $analysis['errors']['0']['message']);
        }

        $data = array(
            'id' => $analysis->id,
            'cashtag' => $cashtag,
        );

        return redirect()->route('cashtag.view', $data); 
    }
    
    public function getData($cashtag = null){
        /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
        $settings = array(
            'oauth_access_token' => "419236098-ybBLRsLig8sSd5LttZ6voxm9Gv3I8yul3JlvzGuD",
            'oauth_access_token_secret' => "7ADQVV1qNy8cLQ7WO64F5FlF4UieOJh8WcevN8swx1Thd",
            'consumer_key' => "4OvrblQjDT4rHklRfrDJURQsH",
            'consumer_secret' => "XtGT33U06TvJ4l4VdHYRb4BINo9P3ebc6XsJsgcxNJWEZtCFJk"
        );
            
        /**GET USER TWEETS**/
        $url = 'https://api.twitter.com/1.1/search/tweets.json';
        $getfield = '?q=%24'.$cashtag.'&tweet_mode=extended&count=200&include_entities=true';
        $requestMethod = 'GET';
        $twitter = new TwitterController($settings);
        $tweetResults = $twitter->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest();

        $tweetResults = json_decode($tweetResults, true);

        $peopleCount = array();
        $timeCount = array();

        for($x=0; $x<sizeof($tweetResults['statuses']); $x++) {
            if(isset($tweetResults['statuses'][$x]['retweeted_status']['full_text'])){
                $tweetsArray[$x]['text'] = $tweetResults['statuses'][$x]['retweeted_status']['full_text'];
            }else{
                $tweetsArray[$x]['text'] = $tweetResults['statuses'][$x]['full_text'];    
            }

            $people = $tweetResults['statuses'][$x]['user']['screen_name'];
            array_push($peopleCount, $people);

            $format = 'D M j G:i:s T Y';
            $time = DateTime::createFromFormat($format, $tweetResults['statuses'][$x]['created_at']);
            array_push($timeCount, $time->format('H'));
        }

        $peopleAmount = sizeof($peopleCount);
        $peopleResult = array_count_values($peopleCount);
        arsort($peopleResult);

        $timeResult = array_count_values($timeCount);


        $tweets = new SentimentController();
        $emotions = json_decode($tweets->getEmotions(json_encode($tweetsArray)));

        //create a new analysis
        $analysis = new Cashtag_Report;
        $analysis->cashtag = strtoupper($cashtag);
        $analysis->people = $peopleAmount;
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
        $analysis->top_joy = $emotions->top_joy;
        $analysis->top_sad = $emotions->top_sad;
        $analysis->top_ang = $emotions->top_ang;
        $analysis->top_fear = $emotions->top_fear;
        $analysis->top_ant = $emotions->top_ant;
        $analysis->top_surp = $emotions->top_surp;
        $analysis->top_disg = $emotions->top_disg;
        $analysis->top_trust = $emotions->top_trust;

        //Save the analysis into the database
        $analysis->save();

        $limit = 1;
        foreach($peopleResult as $word => $count){
            $url = 'https://api.twitter.com/1.1/users/lookup.json';
            $getfield = '?screen_name='.$word;
            $requestMethod = 'GET';
            $twitter = new TwitterController($settings);
            $peopleImage = $twitter->setGetfield($getfield)
                         ->buildOauth($url, $requestMethod)
                         ->performRequest(); 
            $peopleImage = json_decode($peopleImage, true);
            if(!isset($peopleImage['errors'])){
                $profile_image = str_replace("/", "", $peopleImage['0']['profile_image_url']);
                $profile_image = str_replace("normal", "400x400", $peopleImage['0']['profile_image_url']);

                //create a new cashtag people
                $peopleTable = new Cashtag_People;
                $peopleTable->cashtag_id = $analysis->id;
                $peopleTable->screen_name = $word;
                $peopleTable->occurs = $count;
                $peopleTable->profile_image = $profile_image;

                //Save the cashtag people into the database
                $peopleTable->save();
                if ($limit++ == 6) break;
            }
        }

        foreach($timeResult as $number => $count){
            //create a new hashtag
            $timeTable = new Cashtag_Hours;
            $timeTable->cashtag_id = $analysis->id;
            $timeTable->hour = $number;
            $timeTable->occurs = $count;

            //Save the hashtag into the database
            $timeTable->save();
        }

        //return twitter user details
        $result = Cashtag_Report::where('id', '=', $analysis->id)->first();
        
        return $result;
    }
    
}