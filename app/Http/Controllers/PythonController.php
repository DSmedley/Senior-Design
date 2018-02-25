<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PythonController extends Controller
{
    public function python($text/*Request $request*/){
        /*$this->validate($request, [
            'name' => 'required'
        ]);*/
        
        
        /*$settings = array(
            'oauth_access_token' => "419236098-ybBLRsLig8sSd5LttZ6voxm9Gv3I8yul3JlvzGuD",
            'oauth_access_token_secret' => "7ADQVV1qNy8cLQ7WO64F5FlF4UieOJh8WcevN8swx1Thd",
            'consumer_key' => "4OvrblQjDT4rHklRfrDJURQsH",
            'consumer_secret' => "XtGT33U06TvJ4l4VdHYRb4BINo9P3ebc6XsJsgcxNJWEZtCFJk"
        );
        
        $screen_name = 'realDonaldTrump';
        
        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        $getfield = '?screen_name='.$screen_name.'&truncated=false&tweet_mode=extended&count=1';
        $requestMethod = 'GET';
        $twitter = new TwitterController($settings);
        $tweetResults = $twitter->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest();
        
        $tweetResults = json_decode($tweetResults, true);
        $tweet = $tweetResults[0]['full_text'];
        $tweet = preg_replace("/[^ \w]+/",'',$tweet);
        //$tweets = array();
        for($x=0; $x<sizeof($tweetResults); $x++) {
            $tweet = $tweetResults[$x]['full_text'];
            $process = new Process("C:/ProgramData/Anaconda3/python {$path}python_test.py \"{$tweet}\"");
            $process->run();
            
            // executes after the command finishes
            if (!$process->isSuccessful()) {
                //throw new ProcessFailedException($process);
                //throw new ProcessFailedException($process);
                $output = "The process failed!";
                return redirect()->route('welcome')->with('pythonError', $output);
            }
            
            $tweets = $process->getOutput();
        }

        $test = json_encode($tweets);*/
        
        //$text = $request->get('name');
        $path = config('scanner.py_scripts_folder');
        $process = new Process("C:/ProgramData/Anaconda3/python {$path}python_test.py \"{$text}\"");
        $process->run();
        
        //$test ="C:/ProgramData/Anaconda3/python {$path}python_test.py \"{$tweet}\"";
        
        $output = $process->getOutput();
        //return redirect()->route('welcome')->with('pythonSuccess', $output);  
        return $output;
    }
    
    public function pythonJSON(Request $request){
        $this->validate($request, [
            'name' => 'required'
        ]);
        
        $settings = array(
            'oauth_access_token' => "419236098-ybBLRsLig8sSd5LttZ6voxm9Gv3I8yul3JlvzGuD",
            'oauth_access_token_secret' => "7ADQVV1qNy8cLQ7WO64F5FlF4UieOJh8WcevN8swx1Thd",
            'consumer_key' => "4OvrblQjDT4rHklRfrDJURQsH",
            'consumer_secret' => "XtGT33U06TvJ4l4VdHYRb4BINo9P3ebc6XsJsgcxNJWEZtCFJk"
        );
        
        $screen_name = 'realDonaldTrump';
        
        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        $getfield = '?screen_name='.$screen_name.'&truncated=false&tweet_mode=extended&count=5';
        $requestMethod = 'GET';
        $twitter = new TwitterController($settings);
        $tweetResults = $twitter->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest();
        
        $tweetResults = json_decode($tweetResults, true);
        $tweets = array();
        for($x=0; $x<sizeof($tweetResults); $x++) {
            $tweets[] = strip_tags($tweetResults[$x]['full_text']);
        }
        
        $json = json_encode($tweets);
        
        
        //$json = $request->get('name');
        //$json = $this->argument('json');
        $path = config('sentiment.py_scripts_folder');
        $process = new Process("C:/ProgramData/Anaconda3/python {$path}python_json.py {$json}");
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
            $output = "The process failed!";
            return redirect()->route('welcome')->with('pythonError', $output);
        }

        $output = $process->getOutput();
        return redirect()->route('welcome')->with('pythonSuccess', $output);
    }
}
