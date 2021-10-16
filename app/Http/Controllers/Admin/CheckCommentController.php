<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckCommentController extends Controller
{
    public function index(){
        $comments = Comment::doesnthave('report_users')->whereNull('status')->orWhere('status','updated_by_user')->latest()->get();
        return view('admin.comment.index',compact('comments'));
    }

    public function reported(){
        $comments = Comment::has('report_users')->with(['report_users' => function($q){$q->distinct()->get();}])->withCount('report_users')->orderBy('report_users_count','desc')->get();
        return view('admin.comment.index',compact('comments'));
    }

    public function update_status(Comment $comment,$status){
        
        if($status == 'viewed_by_admin' || 'deleted_by_admin'){

            if($status == 'deleted_by_admin'){
                $comment->delete();
            }else{
                $comment->update([
                    'status' => $status
                ]);
            }
 
        }else{
            return back();
        }

        return back()->with('message',['text' =>  'Comment status updated successfully!', 'class' => 'success']);
    }
}
