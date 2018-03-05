<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PythonController extends Controller
{
    public function python($text){

        $path = config('scanner.py_path');
        $process = new Process("{$path}python py/python_sentiment.py \"{$text}\"");
        $process->run();
        
        
        if (!$process->isSuccessful()) {
            $output = "The process failed!";
        }
        
        $output = $process->getOutput();
        return $output;
    }
    
}
