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

class AnalysesController extends Controller
{
    public function index(){
        return view('analysis');
    }
    
    public function getAnalysis($id = null, $name = null)
    {
        //Get data from specified analysis
        //Else return error
        if ($id){
            $analysis = Analyses::where('id', $id)->first();
        }
        
        $data = null;
        
        if(isset($analysis->id)){
            $mentions = Mention::where('analysis_id', $analysis->id)->get();
            $hashtags = Hashtag::where('analysis_id', $analysis->id)->get();
            $hours = Hour::select('hour', 'occurs')->where('analysis_id', $analysis->id)->orderBy('hour')->get();
            $urls = Url::where('analysis_id', $analysis->id)->get();

            $data = array(
               'analysis'   => $analysis,
               'mentions'   => $mentions,
               'hashtags'   => $hashtags,
               'hours'      => $hours,
               'urls'      => $urls,
            );
        }

        //Return to analysis page
        return view('analysis')->with($data);
    }
    
    public function analyze(Request $request){
        $this->validate($request, [
            'name' => 'required',
        ]);
        
        $analysis = $this->getData($request->get('name'));

        if(isset($analysis['errors'])){
            return redirect()->route('analyze')->with('twitterError', $analysis['errors']['0']['message']);
        }

        if (Auth::check()){
            $this->linkAnalysis(Auth::user()->id, $analysis->id);
        }

        $data = array(
            'id' => $analysis->id,
            'name' => $analysis->screen_name,
        );

        return redirect()->route('analysis.view', $data); 
    }
    
    public function linkAnalysis($userID = null, $analysisID = null){
        //link analysis to account
        $link = new Link;
        $link->user_id = $userID;
        $link->analysis_id = $analysisID;
        //save link
        $link->save();
    }
    
    public function getData($screen_name = null){
        /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
        $settings = array(
            'oauth_access_token' => "419236098-ybBLRsLig8sSd5LttZ6voxm9Gv3I8yul3JlvzGuD",
            'oauth_access_token_secret' => "7ADQVV1qNy8cLQ7WO64F5FlF4UieOJh8WcevN8swx1Thd",
            'consumer_key' => "4OvrblQjDT4rHklRfrDJURQsH",
            'consumer_secret' => "XtGT33U06TvJ4l4VdHYRb4BINo9P3ebc6XsJsgcxNJWEZtCFJk"
        );
        
        
        /**GET USER DETAILS**/
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
        
        /**CHECK IF USER ACCOUNT IS PRIVATE**/
        if(!$results['0']['protected']){

            $profile_image = str_replace("/", "", $results['0']['profile_image_url']);
            $profile_image = str_replace("normal", "400x400", $results['0']['profile_image_url']);
            
            /**GET USER TWEETS**/
            $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
            $getfield = '?screen_name='.$screen_name.'&truncated=false&tweet_mode=extended&count=200';
            $requestMethod = 'GET';
            $twitter = new TwitterController($settings);
            $tweetResults = $twitter->setGetfield($getfield)
                         ->buildOauth($url, $requestMethod)
                         ->performRequest();

            $tweetResults = json_decode($tweetResults, true);
            
            $mentionCount = array();
            $hashtagCount = array();
            $timeCount = array();
            $linkCount = array();
            
            $hashtagAmount = 0;
            $mentionAmount = 0;
            $replyAmount = 0;
            $retweetAmount = 0;
            $linkAmount = 0;
            $mediaAmount = 0;
            $favorite_count = 0;
            $favorite_total = 0;
            $retweet_count = 0;
            $retweet_total = 0;

            for($x=0; $x<sizeof($tweetResults); $x++) {
                $tweet = $tweetResults[$x]['full_text'];
                //$tweet = preg_replace("/[^ \w]+/",'',$tweet);
                $tweetsArray[$x]['text'] = $tweet;
                
                /**GET MOST USED HASHTAGS AND MENTIONS**/
                $entities = $tweetResults[$x]['entities']['user_mentions'];
                if(sizeof($entities) > 0){
                    $mentionAmount++;
                    for($y=0; $y<sizeof($entities); $y++) {
                        $mentions = $entities[$y]['screen_name'];
                        array_push($mentionCount, $mentions);
                    }
                }
                
                $hashtags = $tweetResults[$x]['entities']['hashtags'];
                if(sizeof($hashtags) > 0){
                    $hashtagAmount++;
                        for($y=0; $y<sizeof($hashtags); $y++) {
                        $hashtag = $hashtags[$y]['text'];
                        array_push($hashtagCount, $hashtag);
                    }
                }
                
                $links = $tweetResults[$x]['entities']['urls'];
                if(sizeof($links) > 0){
                    $linkAmount++;
                        for($y=0; $y<sizeof($links); $y++) {
                        $link = $links[$y]['url'];
                        array_push($linkCount, $link);
                    }
                }
                
                if(isset($tweetResults[$x]['entities']['media'])){
                    $mediaAmount++;
                }
                
                if(isset($tweetResults[$x]['in_reply_to_status_id'])){
                    $replyAmount++;
                }
                
                if(isset($tweetResults[$x]['retweeted_status'])){
                    $retweetAmount++;
                }
                
                if($tweetResults[$x]['retweet_count'] > 0){
                    $retweet_count++;
                    $retweet_total += $tweetResults[$x]['retweet_count'];
                }

                if($tweetResults[$x]['favorite_count'] > 0){
                    $favorite_count++;
                    $favorite_total += $tweetResults[$x]['favorite_count'];
                }
                
                $format = 'D M j G:i:s T Y';
                $time = DateTime::createFromFormat($format, $tweetResults[$x]['created_at']);
                array_push($timeCount, $time->format('H'));
            }
            
            $mentionResult = array_count_values($mentionCount);
            arsort($mentionResult);
            
            $hashtagResult = array_count_values($hashtagCount);
            arsort($hashtagResult);
            
            $linkResult = array_count_values($linkCount);
            arsort($linkResult);
            
            $timeResult = array_count_values($timeCount);

            
            $tweets = new SentimentController();
            $testing = new DEBUGSentContr();
            $testing2 = json_decode($testing->getEmotions(json_encode($tweetsArray)));
            $emotions = json_decode($tweets->getEmotions(json_encode($tweetsArray)));

            //create a new analysis
            $analysis = new Analyses;
            $analysis->twitter_id = $results['0']['id'];
            $analysis->name = $results['0']['name'];
            $analysis->screen_name = $results['0']['screen_name'];
            $analysis->location = $results['0']['location'];
            $analysis->profile_image = $profile_image;
            $analysis->verified = $results['0']['verified'];
            $analysis->joined = $results['0']['created_at'];
            $analysis->time_zone = $results['0']['time_zone'];
            $analysis->url = $results['0']['url'];
            $analysis->description = $results['0']['description'];
            $analysis->tweets = $results['0']['statuses_count'];
            $analysis->following = $results['0']['friends_count'];
            $analysis->followers = $results['0']['followers_count'];
            $analysis->likes = $results['0']['favourites_count'];           
            $analysis->total = sizeof($tweetResults);
            $analysis->replies = $replyAmount;
            $analysis->mentions = $mentionAmount;
            $analysis->hashtags = $hashtagAmount;
            $analysis->retweets = $retweetAmount;
            $analysis->links = $linkAmount;
            $analysis->media = $mediaAmount;
            $analysis->retweet_count = $retweet_count;
            $analysis->retweet_total = $retweet_total;
            $analysis->favorite_count = $favorite_count;
            $analysis->favorite_total = $favorite_total;
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
            
            $limit = 1;
            foreach($mentionResult as $word => $count){
                $url = 'https://api.twitter.com/1.1/users/lookup.json';
                $getfield = '?screen_name='.$word;
                $requestMethod = 'GET';
                $twitter = new TwitterController($settings);
                $mentionsImage = $twitter->setGetfield($getfield)
                             ->buildOauth($url, $requestMethod)
                             ->performRequest(); 
                $mentionsImage = json_decode($mentionsImage, true);
                if(!isset($mentionsImage['errors'])){
                    $profile_image = str_replace("/", "", $mentionsImage['0']['profile_image_url']);
                    $profile_image = str_replace("normal", "400x400", $mentionsImage['0']['profile_image_url']);

                    //create a new mention
                    $mentionTable = new Mention;
                    $mentionTable->analysis_id = $analysis->id;
                    $mentionTable->screen_name = $word;
                    $mentionTable->occurs = $count;
                    $mentionTable->profile_image = $profile_image;

                    //Save the mention into the database
                    $mentionTable->save();
                    if ($limit++ == 6) break;
                }
            }

            $limit = 1;
            foreach($hashtagResult as $word => $count){
                //create a new hashtag
                $hashtagTable = new Hashtag;
                $hashtagTable->analysis_id = $analysis->id;
                $hashtagTable->hashtag = $word;
                $hashtagTable->occurs = $count;

                //Save the hashtag into the database
                $hashtagTable->save();
                if ($limit++ == 15) break;
            }
            
            $limit = 1;
            foreach($linkResult as $url => $count){
                //create a new hashtag
                $linkTable = new Url;
                $linkTable->analysis_id = $analysis->id;
                $linkTable->url = $url;
                $linkTable->occurs = $count;

                //Save the hashtag into the database
                $linkTable->save();
                if ($limit++ == 15) break;
            }
            
            foreach($timeResult as $number => $count){
                //create a new hashtag
                $timeTable = new Hour;
                $timeTable->analysis_id = $analysis->id;
                $timeTable->hour = $number;
                $timeTable->occurs = $count;

                //Save the hashtag into the database
                $timeTable->save();
            }

            //return twitter user details
            $result = Analyses::where('id', '=', $analysis->id)->first();
        }else{
            
            $result['errors']['0']['message'] = "This user account is private!";
        }
        
        return $result;
    }
    
}
