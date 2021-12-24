<?php

namespace App\Http\Controllers\User;

use App\Models\Answer;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\ReportComment;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = new Comment;
        $comment->comment = $request->comment;
        $comment->user()->associate($request->user());

        $answer = Answer::find($request->answer_id);
        $answer->comments()->save($comment);

        return back()->with('message',['text' => 'Comment added succesfully!', 'class' => 'success']);
    }

    public function update(Request $request,Comment $comment){

        $comment->update([
            'comment' => $request->comment
        ]);

        return back()->with('message',['text' => 'Comment updated succesfully!', 'class' => 'success']);

    }

    public function destroy(Comment $comment){

        $reports = ReportComment::where('comment_id',$comment->id)->get();

        foreach($reports as $report){
            $report->delete();
        }

        $comment->delete();

        return back()->with('message',['text' => 'Comment deleted successfully!', 'class' => 'success']);
    
    }

    public function report(Request $request,Comment $comment){

        $user_id = auth()->id();
        $report = ReportComment::where('user_id',$user_id)->where('comment_id',$comment->id)->first();

        if($comment->user_id == $user_id){
            return back();
        }

        if($report){
            return back()->with('message',['text' => 'Comment already reported!', 'class' => 'danger']);
        }else{

            ReportComment::create([
                'user_id' => $user_id,
                'comment_id' => $comment->id,
                'type' => $request->type,
            ]);

            return back()->with('message',['text' => 'Comment reported successfully!', 'class' => 'success']);
        
        }
    
    }
}
