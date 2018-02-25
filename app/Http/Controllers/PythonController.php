<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PythonController extends Controller
{
    public function python(Request $request){
        $this->validate($request, [
            'name' => 'required'
        ]);
        
        $text = $request->get('name');
        $path = config('scanner.py_scripts_folder');
        $process = new Process("C:/ProgramData/Anaconda3/python {$path}python_test.py \"{$text}\"");
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            //throw new ProcessFailedException($process);
            //throw new ProcessFailedException($process);
            $output = "The process failed!";
            return redirect()->route('welcome')->with('pythonError', $output);
        }

        $output = $process->getOutput();
        
        return redirect()->route('welcome')->with('pythonSuccess', $output);
        
    }
    
    public function pythonJSON(Request $request){
        $this->validate($request, [
            'name' => 'required'
        ]);
        
        $json = $request->get('name');
        //$json = $this->argument('json');
        $path = config('sentiment.py_scripts_folder');
        $process = new Process("C:/ProgramData/Anaconda3/python {$path}python_json.py {$json}");
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();
    }
}
