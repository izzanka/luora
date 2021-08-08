<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Topic;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnswerController extends Controller
{

    public function index()
    {
        $questions = Question::where('user_id','!=',auth()->id())->latest()->get();
        return view('user.answer.index',compact('questions'));
    }

    public function store(Request $request, Question $question)
    {
        $answer = Answer::where('question_id',$question->id)->where('user_id',auth()->id())->first();

        if($answer){
            return back()->with('message',['text' => 'U can only answer once !', 'class' => 'warning']);;
        }

        $request->validate([
            'text' => 'required'
        ]);

        Answer::create([
            'user_id' => auth()->id(),
            'question_id' => $question->id,
            'text' => $request->text,
        ]);

        return back()->with('message',['text' => 'Answer added successfully!', 'class' => 'success']);;
    }

    public function vote(Question $question,Answer $answer,$vote){

        $authUser = auth()->user();
        
        if($vote == "upvote"){
            if($authUser->hasUpVoted($answer)){
                $authUser->cancelVote($answer);
            }else{
                $authUser->upVote($answer);
            }
        }else if($vote == "downvote"){
            if($authUser->hasDownVoted($answer)){
                $authUser->cancelVote($answer);
            }else{
                $authUser->downVote($answer);
            }
        }
       
        return back();
    }

    public function update(Answer $answer,Request $request){

        $request->validate([
            'text' => 'required'
        ]);

        $answer->update([
            'text' => $request->text
        ]);

        return back()->with('message',['text' => 'Answer updated successfully!', 'class' => 'success']);
    }

    public function destroy(Answer $answer){
        $answer->delete();
        return back()->with('message',['text' => 'Answer deleted successfully!', 'class' => 'success']);
    }

}
