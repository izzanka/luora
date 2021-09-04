<?php

namespace App\Http\Controllers\User;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContentController extends Controller
{
    public function index(){
        $contents = auth()->user()->getContents();
        return view('user.content.index',compact('contents'));
    }

    public function questions(){
        $questions = Question::where('user_id',auth()->id())->latest()->get();
        return view('user.content.index',compact('questions'));
    }

    public function answers(){
        $answers = Answer::where('user_id',auth()->id())->with('question')->latest()->get();
        return view('user.content.index',compact('answers'));
    }
}
