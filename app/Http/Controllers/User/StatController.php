<?php

namespace App\Http\Controllers\User;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatController extends Controller
{
    public function index(){
        return view('user.stat.index');
    }

    public function getStats(){
        
        $answers = Answer::where('user_id',auth()->id())->with('question')->get();
        $questions = Question::where('user_id',auth()->id())->get();
        $data1 = 0;
        $data2 = 0;
        $views = ['Answers' => 0,'Questions' => 0,'All' => 0];

        foreach ($answers as $answer) {
            $data1 = views($answer)->count();
            $views['Answers'] = $data1;
        }
        foreach($questions as $question){
            $data2 = views($question)->count();
            $views['Questions'] = $data2;
        }

        $views['All'] = $data1 + $data2;
    
        return response()->json($views);
    }
}
