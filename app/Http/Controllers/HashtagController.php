<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Hashtag_Report;
use App\Hashtag_People;
use App\Hashtag_Hours;
use DateTime;

class HashtagController extends Controller
{
    public function index(){
        return view('hashtag');
    }

    public function getHashtag($id = null, $name = null)
    {
        //Get data from specified analysis
        //Else return error
        if ($id){
            $analysis = Hashtag_Report::where('id', $id)->first();
        }

        $data = null;

        if(isset($analysis->id)){
            $people = Hashtag_people::where('hashtag_id', $analysis->id)->get();
            $hours = Hashtag_Hours::select('hour', 'occurs')->where('hashtag_id', $analysis->id)->orderBy('hour')->get();

            $data = array(
               'analysis'   => $analysis,
               'people'   => $people,
               'hours'      => $hours,
            );
        }

        //Return to analysis page
        return view('hashtag')->with($data);
    }

    public function analyze(Request $request){
        $this->validate($request, [
            'hashtag' => 'required',
        ]);
        $hashtag = $request->get('hashtag');

        $analysis = $this->getData($hashtag);

        if(isset($analysis['errors'])){
            return redirect()->route('hashtag')->with('twitterError', $analysis['errors']['0']['message']);
        }

        $data = array(
            'id' => $analysis->id,
            'hashtag' => $hashtag,
        );

        return redirect()->route('hashtag.view', $data);
    }

    public function getData($hashtag = null){
        /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
        $settings = array(
			'oauth_access_token' => env('OAUTH_ACCESS_TOKEN'),
            'oauth_access_token_secret' => env('OAUTH_ACCESS_TOKEN_SECRET'),
            'consumer_key' => env('CONSUMER_KEY'),
            'consumer_secret' => env('CONSUMER_SECRET')
        );

        /**GET USER TWEETS**/
        $url = 'https://api.twitter.com/1.1/search/tweets.json';
        $getfield = '?q=%23'.$hashtag.'&tweet_mode=extended&count=200&include_entities=true';
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

        if(!empty($tweetsArray)){

            $peopleAmount = sizeof($peopleCount);
            $peopleResult = array_count_values($peopleCount);
            arsort($peopleResult);

            $timeResult = array_count_values($timeCount);


            $tweets = new SentimentController();
            $emotions = json_decode($tweets->getEmotions(json_encode($tweetsArray)));

            //create a new analysis
            $analysis = new Hashtag_Report;
            $analysis->hashtag = strtoupper($hashtag);
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

                    //create a new hashtag people
                    $peopleTable = new Hashtag_People;
                    $peopleTable->hashtag_id = $analysis->id;
                    $peopleTable->screen_name = $word;
                    $peopleTable->occurs = $count;
                    $peopleTable->profile_image = $profile_image;

                    //Save the hashtag people into the database
                    $peopleTable->save();
                    if ($limit++ == 6) break;
                }
            }

            foreach($timeResult as $number => $count){
                //create a new hashtag
                $timeTable = new Hashtag_Hours;
                $timeTable->hashtag_id = $analysis->id;
                $timeTable->hour = $number;
                $timeTable->occurs = $count;

                //Save the hashtag into the database
                $timeTable->save();
            }

            //return twitter user details
            $result = Hashtag_Report::where('id', '=', $analysis->id)->first();
        }else{
            $result['errors']['0']['message'] = "This hashtag does not have any tweets to analyze!";
        }

        return $result;
    }

}
