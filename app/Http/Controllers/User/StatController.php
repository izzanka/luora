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

    //api get stats
    public function getStats(){

        $total_answers = 0;
        $total_questions = 0;
        $views = ['Answers' => 0,'Questions' => 0,'All' => 0];
        
        $answers = Answer::where('user_id',auth()->id())->with('question')->get();
        $questions = Question::where('user_id',auth()->id())->get();
        
        foreach ($answers as $answer) {
            $total_answers = views($answer)->count();
            $views['Answers'] = $total_answers;
        }
        
        foreach($questions as $question){
            $total_questions = views($question)->count();
            $views['Questions'] = $total_questions;
        }

        $views['All'] = $total_answers + $total_questions;
    
        return response()->json($views);
    }
}
