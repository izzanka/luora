<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Topic;
use App\Models\Answer;
use App\Models\Question;
use App\Models\ReportAnswer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class AnswerController extends Controller
{
    public function index(){
        $questions = Question::where('user_id','!=',auth()->id())->latest()->paginate(4);
        return view('user.answer.index',compact('questions'));
    }

    public function store(Request $request, Question $question)
    {
        $answer = Answer::where('question_id',$question->id)->where('user_id',auth()->id())->first();

        if($answer){
            return back()->with('message',['text' => 'You already answer the question!','class' => 'danger']);
        }

        $request->validate([
            'text' => 'required',
            'images.*' => 'image|max:2048',
        ]);

        $images = [];

        if($request->hasFile('images')){
            
            if(count($request->file('images')) > 8){
                return back()->with('message',['text' => 'Maximum allowed image is 8','class' => 'danger']);;
            }

            $num = 0;
            foreach($request->file('images') as $image){
                $num += 1;
                $imageName = time() . '-' . $num . '.' . $image->getClientOriginalExtension();
                $img_edit = Image::make($image);
                $img_edit->resize(700,500);
                $img_edit->text('luora.ferdirns.com', 600, 470, function ($font) {
                    $font->file(public_path('img/coco-sharp-bold.ttf'));
                    $font->size(20);
                    $font->color('#808080');
                    $font->align('center');
                    $font->valign('top');
                    $font->angle(0);
                })->save(public_path('/img') . '/' . $imageName);
                $images[] = $imageName;
            }
        }

        $image = $images ? json_encode($images) : null;
        dd($image);

        Answer::create([
            'user_id' => auth()->id(),
            'question_id' => $question->id,
            'text' => $request->text,
            'images' => $image,
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

        if($answer->user_id == $user_id){
            return back();
        }

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

        $reports = ReportAnswer::where('answer_id',$answer->id)->get();

        if($answer->images){
            $images = json_decode($answer->images);

            foreach($images as $image){
                File::delete('img/' . $image);
            }
        }
        
        foreach($reports as $report){
            $report->delete();
        }

        foreach($answer->comments as $comment){
            $comment->delete();
        }

        $answer->delete();
        
        return back()->with('message',['text' => 'Answer deleted successfully!', 'class' => 'success']);
    }

}
