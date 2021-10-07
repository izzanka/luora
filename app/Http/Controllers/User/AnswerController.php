<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Topic;
use App\Models\Answer;
use App\Models\Question;
use App\Models\ReportAnswer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnswerController extends Controller
{
    public function index(){
        $questions = Question::where('user_id','!=',auth()->id())->latest()->paginate(5);
        return view('user.answer.index',compact('questions'));
    }

    public function store(Request $request, Question $question)
    {
        $answer = Answer::where('question_id',$question->id)->where('user_id',auth()->id())->first();

        if($answer){
            return back();
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
    
    //api vote
    public function vote(Answer $answer,$vote){

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

    public function report(Request $request,Answer $answer){
        $user_id = auth()->id();
        $report = ReportAnswer::where('user_id',$user_id)->where('answer_id',$answer->id)->first();

        if($report){
            return back()->with('message',['text' => 'Answer already reported!', 'class' => 'danger']);
        }else{

            ReportAnswer::create([
                'user_id' => $user_id,
                'answer_id' => $answer->id,
                'type' => $request->type,
            ]);

            return back()->with('message',['text' => 'Answer reported successfully!', 'class' => 'success']);
        }
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

        foreach($answer->comments as $comment){
            $comment->delete();
        }
        
        $answer->delete();
        return back()->with('message',['text' => 'Answer deleted successfully!', 'class' => 'success']);
    }

}
