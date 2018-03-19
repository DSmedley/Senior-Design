<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class SentimentController extends Controller
{
    public function getEmotions($tweets){

        $tweets = json_decode($tweets);
        
        
        
        
        return $output;
    }
    
}