<?php

namespace App\Http\Controllers\User;

use App\Models\Answer;
use App\Models\Comment;
use Illuminate\Http\Request;
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

        return back();
    }

    public function update(){

    }

    public function destroy(){
        
    }

    // public function replyStore(Request $request)
    // {
    //     $reply = new Comment();
    //     $reply->comment = $request->get('comment');
    //     $reply->user()->associate($request->user());

    //     $reply->parent_id = $request->get('comment_id');
    //     $answer = Answer::find($request->get('answer_id'));

    //     $answer->comments()->save($reply);
    //     return back();
    // }
}
